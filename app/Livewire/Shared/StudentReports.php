<?php

namespace App\Livewire\Shared;

use App\Models\Course;
use App\Models\Mark;
use App\Models\Subject;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentReports extends Component
{
    public $students = [];

    public $selectedStudentId = null;

    public $studentMarks = [];

    public $student = null;

    public function mount()
    {
        $this->loadStudents();
    }

    protected function loadStudents()
    {
        $user = Auth::user();
        $role = $user->role->name;

        $query = User::query()
            ->where('school_id', $user->school_id)
            ->whereHas('role', fn ($q) => $q->where('name', 'student'));

        if ($role === 'tutor') {
            $query->whereHas('subjects', function ($q) use ($user) {
                $q->where('tutor_id', $user->id);
            });
        }

        $this->students = $query->orderBy('name')->get();
    }

    public function selectStudent($studentId)
    {
        $this->selectedStudentId = $studentId;
        $this->student = User::with('school')->findOrFail($studentId);
        /*
        $this->studentMarks = Mark::where('user_id', $studentId)
            ->with('course')
            ->latest()
            ->get()
            ->groupBy('course_id');
            */
        $this->studentMarks = Mark::where('user_id', $studentId)
            ->with('subject')
            ->latest()
            ->get();
    }

    public function downloadReport($studentId)
    {
        $student = User::with('school')->findOrFail($studentId);

        // Ensure the downloader has permission
        $user = Auth::user();
        if ($user->school_id !== $student->school_id) {
            abort(403);
        }

        if ($user->role->name === 'tutor') {
            $hasCommonSubject = Subject::where('tutor_id', $user->id)
                ->whereHas('students', function ($q) use ($studentId) {
                    $q->where('users.id', $studentId);
                })->exists();

            if (! $hasCommonSubject) {
                abort(403);
            }
        }

        $marks = Mark::where('user_id', $studentId)
            ->with('subject')
            ->latest()
            ->get()
            ->groupBy('subject_id');

        $pdf = Pdf::loadView('reports.student-mark-report', [
            'student' => $student,
            'school' => $student->school,
            'marksBySubject' => $marks,
            'generatedAt' => now()->format('M d, Y H:i'),
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "Report_{$student->name}_{$student->surname}.pdf");
    }

    public function render()
    {
        return view('livewire.shared.student-reports')
            ->layout('layouts.app');
    }
}
