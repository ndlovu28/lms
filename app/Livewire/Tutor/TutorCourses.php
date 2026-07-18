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
            ->whereHas('subjects', function ($query) use ($tutor) {
                $query->where('tutor_id', $tutor->id);
            })
            ->withCount(['subjects' => function ($query) use ($tutor) {
                $query->where('tutor_id', $tutor->id);
            }])
            ->orderBy('name')
            ->get();

        return view('livewire.tutor.tutor-courses', [
            'courses' => $courses,
        ]);
    }
}
