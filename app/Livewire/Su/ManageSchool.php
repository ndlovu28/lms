<?php

namespace App\Livewire\Su;

use App\Models\Role;
use App\Models\School;
use App\Models\User;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\LearningMaterial;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ManageSchool extends Component
{
    use WithFileUploads, WithPagination;

    public $school;
    public bool $isNew = false;
    public string $activeTab = 'info';

    // School Form Fields
    public string $schoolName = '';

    public string $schoolSlug = '';

    public ?string $schoolDescription = null;

    public bool $schoolIsActive = true;

    public $schoolLogo = null;

    public ?string $existingLogoUrl = null;

    public $schoolBanner = null;

    public ?string $existingBannerUrl = null;

    // User Management
    public string $userTab = 'all';

    public bool $showUserModal = false;

    public ?int $editingUserId = null;

    public string $userName = '';

    public string $userSurname = '';

    public string $userEmail = '';

    public string $userPassword = '';

    public int $userRoleId = 0;

    public int $userStatus = 1;

    protected $queryString = ['userTab' => ['except' => 'all']];

    public function mount($school)
    {
        if ($school === 'new') {
            $this->isNew = true;
            $this->school = new School;
        } else {
            $this->school = School::findOrFail($school);
            $this->loadSchoolData();
        }
    }

    public function loadSchoolData()
    {
        $this->schoolName = $this->school->name;
        $this->schoolSlug = $this->school->slug;
        $this->schoolDescription = $this->school->description;
        $this->schoolIsActive = $this->school->is_active;
        $this->existingLogoUrl = $this->school->logo_url;
        $this->existingBannerUrl = $this->school->banner_url;
    }

    public function saveSchool()
    {
        $this->validate([
            'schoolName' => ['required', 'string', 'max:255'],
            'schoolSlug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('schools', 'slug')->ignore($this->school->id),
            ],
            'schoolDescription' => ['nullable', 'string'],
            'schoolIsActive' => ['boolean'],
            'schoolLogo' => ['nullable', 'image', 'max:2048'],
            'schoolBanner' => ['nullable', 'image', 'max:2048'],
        ]);

        $logoUrl = $this->existingLogoUrl;
        if ($this->schoolLogo) {
            $path = $this->schoolLogo->store('schools/logos', 'public');
            $logoUrl = '/storage/'.$path;
        }

        $bannerUrl = $this->existingBannerUrl;
        if ($this->schoolBanner) {
            $path = $this->schoolBanner->store('schools/banners', 'public');
            $bannerUrl = '/storage/'.$path;
        }

        $data = [
            'name' => $this->schoolName,
            'slug' => $this->schoolSlug,
            'description' => $this->schoolDescription,
            'logo_url' => $logoUrl,
            'banner_url' => $bannerUrl,
            'is_active' => $this->schoolIsActive,
        ];

        if ($this->isNew) {
            $this->school = School::create($data);

            return redirect()->route('su.manage-school', $this->school->id);
        } else {
            $this->school->update($data);
            $this->dispatch('schoolUpdated');
            session()->flash('message', 'School information updated successfully.');
        }
    }

    public function setUserTab($tab)
    {
        $this->userTab = $tab;
        $this->resetPage();
    }

    public function openCreateUserModal()
    {
        $this->resetUserForm();
        $this->showUserModal = true;
    }

    public function openEditUserModal($userId)
    {
        $user = User::findOrFail($userId);
        $this->editingUserId = $user->id;
        $this->userName = $user->name;
        $this->userSurname = $user->surname ?? '';
        $this->userEmail = $user->email;
        $this->userRoleId = $user->role_id;
        $this->userStatus = $user->status;
        $this->userPassword = '';
        $this->showUserModal = true;
    }

    public function saveUser()
    {
        $rules = [
            'userName' => ['required', 'string', 'max:255'],
            'userSurname' => ['nullable', 'string', 'max:255'],
            'userEmail' => [
                'required', 'email', 'max:255',
                Rule::unique('users', 'email')->ignore($this->editingUserId),
            ],
            'userRoleId' => ['required', 'exists:roles,id'],
            'userStatus' => ['required', 'in:0,1'],
        ];

        if (! $this->editingUserId || $this->userPassword) {
            $rules['userPassword'] = ['required', 'min:8'];
        }

        $this->validate($rules);

        $data = [
            'school_id' => $this->school->id,
            'name' => $this->userName,
            'surname' => $this->userSurname,
            'email' => $this->userEmail,
            'role_id' => $this->userRoleId,
            'status' => $this->userStatus,
            'tutor_approved' => true,
        ];

        if ($this->userPassword) {
            $data['password'] = Hash::make($this->userPassword);
        }

        if ($this->editingUserId) {
            User::findOrFail($this->editingUserId)->update($data);
            session()->flash('user-message', 'User updated successfully.');
        } else {
            User::create($data);
            session()->flash('user-message', 'User created successfully.');
        }

        $this->showUserModal = false;
        $this->resetUserForm();
    }

    public function toggleUserStatus($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => $user->status ? 0 : 1]);
    }

    public function resetUserForm()
    {
        $this->editingUserId = null;
        $this->userName = '';
        $this->userSurname = '';
        $this->userEmail = '';
        $this->userPassword = '';
        $this->userRoleId = Role::where('name', 'student')->first()?->id ?? 0;
        $this->userStatus = 1;
        $this->resetErrorBag();
    }

    public function render()
    {
        $roles = Role::all();
        $rolesMap = $roles->pluck('id', 'name');

        $usersQuery = User::where('school_id', $this->school->id);

        if ($this->userTab !== 'all') {
            $role = Role::where('name', $this->userTab)->first();
            if ($role) {
                $usersQuery->where('role_id', $role->id);
            }
        }

        $stats = [];
        if (!$this->isNew && $this->activeTab === 'stats') {
            $stats = [
                'totalUsers' => User::where('school_id', $this->school->id)->count(),
                'adminsCount' => User::where('school_id', $this->school->id)->where('role_id', $rolesMap['admin'] ?? 0)->count(),
                'tutorsCount' => User::where('school_id', $this->school->id)->where('role_id', $rolesMap['tutor'] ?? 0)->count(),
                'studentsCount' => User::where('school_id', $this->school->id)->where('role_id', $rolesMap['student'] ?? 0)->count(),
                'totalCourses' => Course::where('school_id', $this->school->id)->count(),
                'totalQuizzes' => Quiz::whereHas('course', fn($q) => $q->where('school_id', $this->school->id))->count(),
                'totalAttempts' => QuizAttempt::whereHas('user', fn($q) => $q->where('school_id', $this->school->id))->count(),
                'totalMaterials' => LearningMaterial::whereHas('course', fn($q) => $q->where('school_id', $this->school->id))->count(),
                'totalAssignments' => Assignment::whereHas('course', fn($q) => $q->where('school_id', $this->school->id))->count(),
                'totalSubmissions' => AssignmentSubmission::whereHas('user', fn($q) => $q->where('school_id', $this->school->id))->count(),
            ];
        }

        return view('livewire.su.manage-school', [
            'users' => $usersQuery->latest()->paginate(10),
            'roles' => $roles,
            'stats' => $stats,
        ]);
    }}
