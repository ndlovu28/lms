<?php

namespace App\Livewire\Su;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\LearningMaterial;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Livewire\Component;

class SuStats extends Component
{
    public function render()
    {
        $roles = Role::all()->pluck('id', 'name');

        return view('livewire.su.su-stats', [
            'totalSchools' => School::count(),
            'totalUsers' => User::count(),
            'adminsCount' => User::where('role_id', $roles['admin'] ?? 0)->count(),
            'tutorsCount' => User::where('role_id', $roles['tutor'] ?? 0)->count(),
            'studentsCount' => User::where('role_id', $roles['student'] ?? 0)->count(),
            'totalCourses' => Course::count(),
            'totalQuizzes' => Quiz::count(),
            'totalAttempts' => QuizAttempt::count(),
            'totalMaterials' => LearningMaterial::count(),
            'totalAssignments' => Assignment::count(),
            'totalSubmissions' => AssignmentSubmission::count(),
            'activeSchools' => School::where('is_active', true)->count(),
            'recentUsers' => User::latest()->take(5)->get(),
            'recentSchools' => School::latest()->take(5)->get(),
        ]);
    }
}
