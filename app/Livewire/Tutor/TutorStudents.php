<?php

namespace App\Livewire\Tutor;

use App\Models\Phase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class TutorStudents extends Component
{
    public ?int $filterPhaseId = null;

    public function render()
    {
        $tutor = Auth::user();

        $phases = Phase::query()
            ->where('school_id', $tutor->school_id)
            ->orderBy('name')
            ->get();

        $students = User::query()
        ->where('school_id', $tutor->school_id)
        ->whereHas('role', fn ($query) => $query->where('name', 'student'))
        ->whereIn('id', function ($q) {
            $q->select('user_id')
                ->from('subject_user')
                ->whereIn('subject_id', function ($query) {
                    $query->select('id')
                        ->from('subjects')
                        ->where('tutor_id', Auth::id());
                });
        })
        ->get();

        return view('livewire.tutor.tutor-students', [
            'phases' => $phases,
            'students' => $students,
        ]);
    }
}
