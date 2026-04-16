<?php

namespace App\Livewire\Student;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentDashboard extends Component
{
    public function render()
    {
        $student = Auth::user();

        $courses = $student->courses()
            ->with(['phase', 'tutor', 'quizzes.questions'])
            ->get();

        $attempts = $student->quizAttempts()
            ->with('quiz')
            ->get()
            ->groupBy('quiz_id');

        return view('livewire.student.student-dashboard', [
            'courses' => $courses,
            'attempts' => $attempts,
        ]);
    }
}
