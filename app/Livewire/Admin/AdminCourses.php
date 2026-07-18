<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Phase;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminCourses extends Component
{
    public ?int $editingCourseId = null;

    public string $name = '';

    public ?string $description = null;

    public ?int $phaseId = null;

    public $show_form = false;

    public function render()
    {
        $schoolId = Auth::user()->school_id;

        $coursesQuery = Course::query()
            ->with('phase')
            ->latest();

        $phases = Phase::query()
            ->where('school_id', $schoolId)
            ->orderBy('name')
            ->get();

        return view('livewire.admin.admin-courses', [
            'courses' => $coursesQuery->get(),
            'phases' => $phases,
        ]);
    }

    public function startCreate(): void
    {
        $this->resetForm();
        $this->dispatch('show-course-modal');
    }

    public function startEdit(int $courseId): void
    {
        $course = Course::query()
            ->findOrFail($courseId);

        $this->editingCourseId = $course->id;
        $this->name = $course->name;
        $this->description = $course->description;
        $this->phaseId = $course->phase_id;

        $this->show_form = true;
        $this->dispatch('show-course-modal');

        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'phaseId' => ['required', 'integer', 'exists:phases,id'],
        ]);

        if ($this->editingCourseId) {
            $course = Course::query()
                ->findOrFail($this->editingCourseId);
            $course->update([
                'name' => $this->name,
                'description' => $this->description,
                'phase_id' => $this->phaseId,
            ]);
        } else {
            Course::query()->create([
                'name' => $this->name,
                'description' => $this->description,
                'phase_id' => $this->phaseId,
            ]);
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    protected function resetForm(): void
    {
        $this->editingCourseId = null;
        $this->name = '';
        $this->description = null;
        $this->phaseId = null;
        $this->show_form = false;

        $this->resetErrorBag();
    }
}
