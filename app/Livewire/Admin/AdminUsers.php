<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminUsers extends Component
{
    public string $tab = 'all';

    public bool $showAssignCoursesModal = false;

    public bool $showCreateUserModal = false;

    public string $name = '';

    public string $surname = '';

    public string $email = '';

    public string $password = '';

    public ?int $role_id = null;

    public ?int $assignUserId = null;

    public ?string $assignUserType = null;

    /**
     * @var array<int>
     */
    public array $selectedCourseIds = [];

    public function render()
    {
        $schoolId = $this->currentSchoolId();

        $baseQuery = User::query()
            ->with('role')
            ->where('school_id', $schoolId)
            ->orderBy('name');

        if ($this->tab === 'pending') {
            $users = (clone $baseQuery)
                ->whereHas('role', fn ($query) => $query->where('name', 'tutor'))
                ->where(function ($query): void {
                    $query->where('tutor_approved', false)
                        ->orWhereNull('tutor_approved');
                })
                ->get();
        } elseif ($this->tab === 'tutors') {
            $users = (clone $baseQuery)
                ->whereHas('role', fn ($query) => $query->where('name', 'tutor'))
                ->get();
        } elseif ($this->tab === 'students') {
            $users = (clone $baseQuery)
                ->whereHas('role', fn ($query) => $query->where('name', 'student'))
                ->get();
        } else {
            $users = $baseQuery->get();
        }

        $coursesForAssign = collect();

        if ($this->showAssignCoursesModal && $this->assignUserId !== null) {
            $coursesForAssign = Course::query()
                ->where('school_id', $schoolId)
                ->orderBy('name')
                ->get();
        }

        return view('livewire.admin.admin-users', [
            'users' => $users,
            'coursesForAssign' => $coursesForAssign,
            'roles' => Role::where('name', '!=', 'su')->get(),
        ]);
    }

    public function openCreateUserModal(): void
    {
        $this->reset(['name', 'surname', 'email', 'password', 'role_id']);
        $this->showCreateUserModal = true;
    }

    public function closeCreateUserModal(): void
    {
        $this->showCreateUserModal = false;
    }

    public function createUser(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'password' => $this->password,
            'role_id' => $this->role_id,
            'school_id' => $this->currentSchoolId(),
            'status' => 1,
            'tutor_approved' => true, // Auto-approve if created by admin
        ]);

        $this->showCreateUserModal = false;
        $this->reset(['name', 'surname', 'email', 'password', 'role_id']);

        session()->flash('success', 'User created successfully.');
    }

    public function setTab(string $tab): void
    {
        $this->tab = $tab;
    }

    public function toggleUserStatus(int $userId): void
    {
        $user = User::query()
            ->where('school_id', $this->currentSchoolId())
            ->findOrFail($userId);

        $user->status = $user->status === 1 ? 0 : 1;
        $user->save();
    }

    public function toggleTutorApproval(int $userId): void
    {
        $user = User::query()
            ->where('school_id', $this->currentSchoolId())
            ->whereHas('role', fn ($q) => $q->where('name', 'tutor'))
            ->findOrFail($userId);

        $user->tutor_approved = ! $user->tutor_approved;
        $user->save();
    }

    public function openAssignCourses(int $userId): void
    {
        $user = User::query()
            ->where('school_id', $this->currentSchoolId())
            ->with('role')
            ->findOrFail($userId);

        if ($user->role?->name === 'tutor' && ! $user->tutor_approved) {
            session()->flash('error', 'Cannot assign courses to an unapproved tutor.');

            return;
        }

        $this->assignUserId = $user->id;
        $this->assignUserType = $user->role?->name;

        if ($this->assignUserType === 'tutor') {
            $this->selectedCourseIds = Course::query()
                ->where('school_id', $this->currentSchoolId())
                ->where('tutor_id', $user->id)
                ->pluck('id')
                ->all();
        } else {
            $this->selectedCourseIds = $user->courses()->pluck('courses.id')->all();
        }

        $this->showAssignCoursesModal = true;
    }

    public function saveAssignedCourses(): void
    {
        if ($this->assignUserId === null || $this->assignUserType === null) {
            return;
        }

        $schoolId = $this->currentSchoolId();

        $user = User::query()
            ->where('school_id', $schoolId)
            ->with('role')
            ->findOrFail($this->assignUserId);

        if ($this->assignUserType === 'tutor') {
            Course::query()
                ->where('school_id', $schoolId)
                ->where('tutor_id', $user->id)
                ->whereNotIn('id', $this->selectedCourseIds)
                ->update(['tutor_id' => null]);

            if (! empty($this->selectedCourseIds)) {
                Course::query()
                    ->where('school_id', $schoolId)
                    ->whereIn('id', $this->selectedCourseIds)
                    ->update(['tutor_id' => $user->id]);
            }
        } else {
            $user->courses()->sync($this->selectedCourseIds);
        }

        $this->showAssignCoursesModal = false;
        $this->assignUserId = null;
        $this->assignUserType = null;
        $this->selectedCourseIds = [];
    }

    public function closeAssignCoursesModal(): void
    {
        $this->showAssignCoursesModal = false;
    }

    protected function currentSchoolId(): int
    {
        $user = Auth::user();

        return (int) $user->school_id;
    }
}
