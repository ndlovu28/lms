<?php

namespace App\Livewire\Tutor;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Subject;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TutorDashboard extends Component
{
    public function render()
    {
        $tutor = Auth::user();

        $subjects = Subject::query()
            ->where('school_id', $tutor->school_id)
            ->where('tutor_id', $tutor->id)
            ->withCount('students')
            ->get();

        $studentsCount = User::query()
            ->where('school_id', $tutor->school_id)
            ->whereHas('role', fn ($query) => $query->where('name', 'student'))
            ->whereHas('subjects', fn ($query) => $query->where('tutor_id', $tutor->id))
            ->distinct('users.id')
            ->count('users.id');

        $quizAttemptsCount = QuizAttempt::whereHas('quiz', function ($query) use ($tutor) {
            $query->where('tutor_id', $tutor->id);
        })
            ->whereNotNull('completed_at')
            ->count();

        $quizzesCount = Quiz::where('tutor_id', $tutor->id)->count();

        $courses = Course::whereHas('subjects', function($q){
            return $q->where('tutor_id', Auth::user()->id);
        })
        ->get();

        return view('livewire.tutor.tutor-dashboard', [
            'subjects' => $subjects,
            'studentsCount' => $studentsCount,
            'quizAttemptsCount' => $quizAttemptsCount,
            'quizzesCount' => $quizzesCount,
            'courses' => $courses
        ]);
    }
}
