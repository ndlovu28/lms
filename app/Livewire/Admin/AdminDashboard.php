<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminDashboard extends Component
{
    public function render()
    {
        $schoolId = Auth::user()->school_id;

        $tutorsCount = User::where('school_id', $schoolId)
            ->whereHas('role', fn($q) => $q->where('name', 'tutor'))
            ->count();

        $studentsCount = User::where('school_id', $schoolId)
            ->whereHas('role', fn($q) => $q->where('name', 'student'))
            ->count();

        $coursesCount = Course::where('school_id', $schoolId)->count();

        $pendingTutorsCount = User::where('school_id', $schoolId)
            ->whereHas('role', fn($q) => $q->where('name', 'tutor'))
            ->where(function($q) {
                $q->where('tutor_approved', false)
                  ->orWhereNull('tutor_approved');
            })
            ->count();

        return view('livewire.admin.admin-dashboard', [
            'tutorsCount' => $tutorsCount,
            'studentsCount' => $studentsCount,
            'coursesCount' => $coursesCount,
            'pendingTutorsCount' => $pendingTutorsCount,
        ]);
    }
}
