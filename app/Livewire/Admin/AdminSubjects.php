<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminSubjects extends Component
{
    public ?int $editingSubjectId = null;

    public string $name = '';

    public ?string $description = null;

    public ?int $filterCourseId = null;

    public ?int $courseId = null;

    public ?int $tutorId = null;

    public function render()
    {
        $schoolId = $this->currentSchoolId();

        $courses = Course::query()
            ->with('phase')
            ->orderBy('name')
            ->get();

        $tutors = User::query()
            ->where('school_id', $schoolId)
            ->whereHas('role', function ($query): void {
                $query->where('name', 'tutor');
            })
            ->orderBy('name')
            ->get();

        $subjectsQuery = Subject::query()
            ->where('school_id', $schoolId)
            ->with(['tutor', 'course', 'course.phase'])
            ->latest();

        if ($this->filterCourseId) {
            $subjectsQuery->where('course_id', $this->filterCourseId);
        }

        return view('livewire.admin.admin-subjects', [
            'courses' => $courses,
            'tutors' => $tutors,
            'subjects' => $subjectsQuery->get(),
        ]);
    }

    public function updatedFilterCourseId(): void
    {
        // Trigger re-render when filter changes.
    }

    public function startCreate(): void
    {
        $this->resetForm();
        $this->dispatch('show-subject-modal');
    }

    public function startEdit(int $subjectId): void
    {
        $subject = Subject::query()
            ->where('school_id', $this->currentSchoolId())
            ->findOrFail($subjectId);

        $this->editingSubjectId = $subject->id;
        $this->name = $subject->name;
        $this->description = $subject->description;
        $this->courseId = $subject->course_id;
        $this->tutorId = $subject->tutor_id;

        $this->resetErrorBag();

        $this->dispatch('show-subject-modal');
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'courseId' => ['required', 'integer', 'exists:courses,id'],
            'tutorId' => ['required', 'integer', 'exists:users,id'],
        ]);

        $schoolId = $this->currentSchoolId();

        if ($this->editingSubjectId) {
            $subject = Subject::query()
                ->where('school_id', $schoolId)
                ->findOrFail($this->editingSubjectId);
            $subject->update([
                'school_id' => $schoolId,
                'name' => $this->name,
                'description' => $this->description,
                'course_id' => $this->courseId,
                'tutor_id' => $this->tutorId,
            ]);
        } else {
            Subject::query()->create([
                'school_id' => $schoolId,
                'name' => $this->name,
                'description' => $this->description,
                'course_id' => $this->courseId,
                'tutor_id' => $this->tutorId,
            ]);
        }

        $this->resetForm();
        $this->dispatch('close-modal');
    }

    protected function currentSchoolId(): int
    {
        $user = Auth::user();

        return (int) $user->school_id;
    }

    protected function resetForm(): void
    {
        $this->editingSubjectId = null;
        $this->name = '';
        $this->description = null;
        $this->courseId = null;
        $this->tutorId = null;

        $this->resetErrorBag();
    }
}
