<?php

namespace App\Livewire\Shared;

use App\Models\Course;
use App\Models\Mark;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ManageMarks extends Component
{
    public Course $course;

    public $students;

    public $assessmentTitle = '';

    public $maxMark = '';

    public $studentMarks = []; // [student_id => mark]

    public $studentComments = []; // [student_id => comments]

    public $existingAssessments = [];

    public function mount(Course $course)
    {
        $this->course = $course;
        $this->authorizeAccess();
        $this->students = $course->students()->orderBy('name')->get();
        $this->loadExistingAssessments();
    }

    protected function authorizeAccess()
    {
        $user = Auth::user();
        $role = $user->role->name;

        if ($role === 'su') {
            return;
        }

        if ($role === 'admin') {
            if ($this->course->school_id !== $user->school_id) {
                abort(403);
            }

            return;
        }

        if ($role === 'tutor') {
            if ($this->course->tutor_id !== $user->id) {
                abort(403);
            }

            return;
        }

        abort(403);
    }

    public function loadExistingAssessments()
    {
        $this->existingAssessments = Mark::where('course_id', $this->course->id)
            ->select('title', 'max_mark')
            ->distinct()
            ->get();
    }

    public function saveMarks()
    {
        $this->validate([
            'assessmentTitle' => 'required|string|max:255',
            'maxMark' => 'nullable|string|max:255',
            'studentMarks.*' => 'nullable|string|max:255',
            'studentComments.*' => 'nullable|string',
        ]);

        foreach ($this->studentMarks as $studentId => $markValue) {
            if ($markValue !== null && $markValue !== '') {
                // Update or create mark for this student and this assessment title
                Mark::updateOrCreate(
                    [
                        'course_id' => $this->course->id,
                        'user_id' => $studentId,
                        'title' => $this->assessmentTitle,
                    ],
                    [
                        'mark' => $markValue,
                        'max_mark' => $this->maxMark,
                        'comments' => $this->studentComments[$studentId] ?? null,
                        'created_by' => Auth::id(),
                    ]
                );
            }
        }

        $this->reset(['studentMarks', 'studentComments', 'assessmentTitle', 'maxMark']);
        $this->loadExistingAssessments();
        session()->flash('success', 'Marks saved successfully.');
    }

    public function loadAssessment(string $title)
    {
        $marks = Mark::where('course_id', $this->course->id)
            ->where('title', $title)
            ->get();

        $this->assessmentTitle = $title;
        if ($marks->isNotEmpty()) {
            $this->maxMark = $marks->first()->max_mark;
        }

        $this->studentMarks = [];
        $this->studentComments = [];

        foreach ($marks as $mark) {
            $this->studentMarks[$mark->user_id] = $mark->mark;
            $this->studentComments[$mark->user_id] = $mark->comments;
        }
    }

    public function render()
    {
        return view('livewire.shared.manage-marks')
            ->layout('layouts.app');
    }
}
