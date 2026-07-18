<?php

namespace App\Livewire\Student;

use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StudentCourses extends Component
{
    public function render()
    {
        $student = Auth::user();

        $courses = Course::query()
            ->whereHas('subjects', function ($query) use ($student) {
                $query->whereHas('students', function ($query) use ($student) {
                    $query->where('users.id', $student->id);
                });
            })
            ->withCount(['subjects' => function ($query) use ($student) {
                $query->whereHas('students', function ($query) use ($student) {
                    $query->where('users.id', $student->id);
                });
            }])
            ->orderBy('name')
            ->get();

        return view('livewire.student.student-courses', [
            'courses' => $courses,
        ]);
    }
}
