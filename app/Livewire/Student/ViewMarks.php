<?php

namespace App\Livewire\Student;

use App\Models\Mark;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewMarks extends Component
{
    public function render()
    {
        $student = Auth::user();

        $marks = Mark::where('user_id', $student->id)
            ->with('course')
            ->latest()
            ->get()
            ->groupBy('course_id');

        return view('livewire.student.view-marks', [
            'marksByCourse' => $marks,
        ])->layout('layouts.app');
    }
}
