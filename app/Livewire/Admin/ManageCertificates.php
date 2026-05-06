<?php

namespace App\Livewire\Admin;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class ManageCertificates extends Component
{
    use WithPagination;

    public $studentId;

    public $courseId;

    public $title = 'Certificate of Achievement';

    public $description;

    public $issuedAt;

    protected $rules = [
        'studentId' => 'required|exists:users,id',
        'courseId' => 'nullable|exists:courses,id',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'issuedAt' => 'required|date',
    ];

    public function mount()
    {
        $this->issuedAt = now()->format('Y-m-d');
    }

    public function issueCertificate()
    {
        $this->validate();

        $certificate = Certificate::create([
            'user_id' => $this->studentId,
            'course_id' => $this->courseId ?: null,
            'title' => $this->title,
            'description' => $this->description,
            'issued_at' => $this->issuedAt,
            'issued_by' => Auth::id(),
            'certificate_number' => 'CERT-'.strtoupper(Str::random(10)),
        ]);

        $this->reset(['studentId', 'courseId', 'description']);
        $this->title = 'Certificate of Achievement';

        session()->flash('success', 'Certificate issued successfully.');
    }

    public function downloadCertificate($id)
    {
        $certificate = Certificate::with(['student', 'course', 'student.school'])->findOrFail($id);

        $school = $certificate->student->school;

        $pdf = Pdf::loadView('reports.certificate-template', [
            'certificate' => $certificate,
            'student' => $certificate->student,
            'school' => $school,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, "Certificate_{$certificate->certificate_number}.pdf");
    }

    public function deleteCertificate($id)
    {
        Certificate::findOrFail($id)->delete();
        session()->flash('success', 'Certificate deleted.');
    }

    public function render()
    {
        $schoolId = Auth::user()->school_id;

        $students = User::where('school_id', $schoolId)
            ->whereHas('role', fn ($q) => $q->where('name', 'student'))
            ->orderBy('name')
            ->get();

        $courses = Course::where('school_id', $schoolId)->orderBy('name')->get();

        $issuedCertificates = Certificate::whereHas('student', function ($q) use ($schoolId) {
            $q->where('school_id', $schoolId);
        })
            ->with(['student', 'course'])
            ->latest()
            ->paginate(10);

        return view('livewire.admin.manage-certificates', [
            'students' => $students,
            'courses' => $courses,
            'issuedCertificates' => $issuedCertificates,
        ])->layout('layouts.app');
    }
}
