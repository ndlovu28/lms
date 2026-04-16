<?php

namespace App\Livewire\Tutor;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TutorCourses extends Component
{
    public function render()
    {
        $tutor = Auth::user();

        $courses = Course::query()
            ->where('school_id', $tutor->school_id)
            ->where('tutor_id', $tutor->id)
            ->with(['phase'])
            ->withCount('students')
            ->orderBy('name')
            ->get();

        return view('livewire.tutor.tutor-courses', [
            'courses' => $courses,
        ]);
    }
}
