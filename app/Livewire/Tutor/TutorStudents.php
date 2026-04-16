<?php

namespace App\Livewire\Tutor;

use App\Models\Phase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

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

        $studentsQuery = User::query()
            ->where('school_id', $tutor->school_id)
            ->whereHas('role', fn ($query) => $query->where('name', 'student'))
            ->whereHas('courses', function ($query): void {
                $query->where('tutor_id', Auth::id());

                if ($this->filterPhaseId) {
                    $query->where('phase_id', $this->filterPhaseId);
                }
            })
            ->with(['courses' => function ($query): void {
                $query->where('tutor_id', Auth::id())
                    ->with('phase');
            }])
            ->select('users.*')
            ->distinct();

        $students = $studentsQuery->orderBy('name')->get();

        return view('livewire.tutor.tutor-students', [
            'phases' => $phases,
            'students' => $students,
        ]);
    }
}
