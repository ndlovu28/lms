<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Phase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminCourses extends Component
{
    public ?int $editingCourseId = null;

    public string $name = '';

    public ?string $description = null;

    public ?int $phaseId = null;

    public ?int $filterPhaseId = null;

    public ?int $tutorId = null;

    public function render()
    {
        $schoolId = $this->currentSchoolId();

        $phases = Phase::query()
            ->where('school_id', $schoolId)
            ->orderBy('name')
            ->get();

        $tutors = User::query()
            ->where('school_id', $schoolId)
            ->whereHas('role', function ($query): void {
                $query->where('name', 'tutor');
            })
            ->orderBy('name')
            ->get();

        $coursesQuery = Course::query()
            ->where('school_id', $schoolId)
            ->with(['phase', 'tutor'])
            ->latest();

        if ($this->filterPhaseId) {
            $coursesQuery->where('phase_id', $this->filterPhaseId);
        }

        return view('livewire.admin.admin-courses', [
            'phases' => $phases,
            'tutors' => $tutors,
            'courses' => $coursesQuery->get(),
        ]);
    }

    public function updatedFilterPhaseId(): void
    {
        // Trigger re-render when filter changes.
    }

    public function startCreate(): void
    {
        $this->resetForm();
    }

    public function startEdit(int $courseId): void
    {
        $course = Course::query()
            ->where('school_id', $this->currentSchoolId())
            ->findOrFail($courseId);

        $this->editingCourseId = $course->id;
        $this->name = $course->name;
        $this->description = $course->description;
        $this->phaseId = $course->phase_id;
        $this->tutorId = $course->tutor_id;

        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'phaseId' => ['required', 'integer', 'exists:phases,id'],
            'tutorId' => ['required', 'integer', 'exists:users,id'],
        ]);

        $schoolId = $this->currentSchoolId();

        if ($this->editingCourseId) {
            $course = Course::query()
                ->where('school_id', $schoolId)
                ->findOrFail($this->editingCourseId);
            $course->update([
                'school_id' => $schoolId,
                'name' => $this->name,
                'description' => $this->description,
                'phase_id' => $this->phaseId,
                'tutor_id' => $this->tutorId,
            ]);
        } else {
            Course::query()->create([
                'school_id' => $schoolId,
                'name' => $this->name,
                'description' => $this->description,
                'phase_id' => $this->phaseId,
                'tutor_id' => $this->tutorId,
            ]);
        }

        $this->resetForm();
    }

    protected function currentSchoolId(): int
    {
        $user = Auth::user();

        return (int) $user->school_id;
    }

    protected function resetForm(): void
    {
        $this->editingCourseId = null;
        $this->name = '';
        $this->description = null;
        $this->phaseId = null;
        $this->tutorId = null;

        $this->resetErrorBag();
    }
}
