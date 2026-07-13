<?php

namespace App\Livewire\Student;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentSubjects extends Component
{
    public function render()
    {
        $student = Auth::user();

        $subjects = $student->subjects()
            ->with(['course.phase', 'tutor', 'quizzes.questions', 'activeSession', 'course'])
            ->get();

        $attempts = $student->quizAttempts()
            ->with('quiz')
            ->get()
            ->groupBy('quiz_id');

        return view('livewire.student.student-subjects', [
            'subjects' => $subjects,
            'attempts' => $attempts,
        ]);
    }
}
