<?php

namespace App\Livewire\Su;

use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SuDashboard extends Component
{
    use WithFileUploads;

    public bool $showSchoolModal = false;

    public ?int $editingSchoolId = null;

    public string $schoolName = '';

    public string $schoolSlug = '';

    public ?string $schoolDescription = null;

    public bool $schoolIsActive = true;

    /**
     * @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null
     */
    public $schoolLogo = null;

    public ?string $existingLogoUrl = null;

    public string $adminName = '';

    public string $adminSurname = '';

    public string $adminEmail = '';

    public string $adminPassword = '';

    public string $adminPasswordConfirmation = '';

    public function render()
    {
        return view('livewire.su.su-dashboard', [
            'schools' => School::query()->latest()->get(),
        ]);
    }

    public function openCreateSchoolModal(): void
    {
        $this->resetSchoolForm();
        $this->showSchoolModal = true;
    }

    public function openEditSchoolModal(int $schoolId): void
    {
        $school = School::query()->findOrFail($schoolId);

        $this->editingSchoolId = $school->id;
        $this->schoolName = $school->name;
        $this->schoolSlug = $school->slug;
        $this->schoolDescription = $school->description;
        $this->schoolIsActive = $school->is_active;
        $this->existingLogoUrl = $school->logo_url;
        $this->schoolLogo = null;

        $adminRole = Role::query()->where('name', 'admin')->first();

        $adminUser = null;

        if ($adminRole) {
            $adminUser = User::query()
                ->where('school_id', $school->id)
                ->where('role_id', $adminRole->id)
                ->first();
        }

        if ($adminUser) {
            $this->adminName = $adminUser->name;
            $this->adminSurname = $adminUser->surname ?? '';
            $this->adminEmail = $adminUser->email;
        } else {
            $this->adminName = '';
            $this->adminSurname = '';
            $this->adminEmail = '';
        }

        $this->adminPassword = '';
        $this->adminPasswordConfirmation = '';

        $this->resetErrorBag();
        $this->showSchoolModal = true;
    }

    public function saveSchool(): void
    {
        $adminRole = Role::query()->where('name', 'admin')->first();

        if (! $adminRole) {
            $this->addError('adminEmail', 'Admin role not found. Please ensure the roles are seeded.');

            return;
        }

        $schoolId = $this->editingSchoolId;

        $adminUser = null;

        if ($schoolId) {
            $adminUser = User::query()
                ->where('school_id', $schoolId)
                ->where('role_id', $adminRole->id)
                ->first();
        }

        $this->validate($this->rules($adminUser));

        $logoUrl = $this->existingLogoUrl;

        if ($this->schoolLogo) {
            $path = $this->schoolLogo->store('schools/logos', 'public');
            $logoUrl = '/storage/'.$path;
        }

        if ($schoolId) {
            $school = School::query()->findOrFail($schoolId);
            $school->update([
                'name' => $this->schoolName,
                'slug' => $this->schoolSlug,
                'description' => $this->schoolDescription,
                'logo_url' => $logoUrl,
                'is_active' => $this->schoolIsActive,
            ]);
        } else {
            $school = School::query()->create([
                'name' => $this->schoolName,
                'slug' => $this->schoolSlug,
                'description' => $this->schoolDescription,
                'logo_url' => $logoUrl,
                'is_active' => $this->schoolIsActive,
            ]);
        }

        if ($adminUser) {
            $adminUser->name = $this->adminName;
            $adminUser->surname = $this->adminSurname;
            $adminUser->email = $this->adminEmail;

            if ($this->adminPassword !== '') {
                $adminUser->password = Hash::make($this->adminPassword);
            }

            $adminUser->save();
        } else {
            User::query()->create([
                'role_id' => $adminRole->id,
                'school_id' => $school->id,
                'name' => $this->adminName,
                'surname' => $this->adminSurname,
                'email' => $this->adminEmail,
                'password' => Hash::make($this->adminPassword),
                'status' => 1,
                'tutor_approved' => true,
            ]);
        }

        $this->showSchoolModal = false;
        $this->resetSchoolForm();
    }

    public function closeSchoolModal(): void
    {
        $this->showSchoolModal = false;
    }

    protected function rules(?User $adminUser = null): array
    {
        $schoolId = $this->editingSchoolId;

        $adminUserId = $adminUser?->id;

        $rules = [
            'schoolName' => ['required', 'string', 'max:255'],
            'schoolSlug' => [
                'required',
                'string',
                'max:255',
                Rule::unique('schools', 'slug')->ignore($schoolId),
            ],
            'schoolDescription' => ['nullable', 'string'],
            'schoolIsActive' => ['boolean'],
            'schoolLogo' => ['nullable', 'image', 'max:2048'],
            'adminName' => ['required', 'string', 'max:255'],
            'adminSurname' => ['nullable', 'string', 'max:255'],
            'adminEmail' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($adminUserId),
            ],
        ];

        if (! $schoolId || ! $adminUserId || $this->adminPassword !== '') {
            $rules['adminPassword'] = ['required', 'string', 'min:8'];
            $rules['adminPasswordConfirmation'] = ['same:adminPassword'];
        }

        return $rules;
    }

    protected function resetSchoolForm(): void
    {
        $this->editingSchoolId = null;
        $this->schoolName = '';
        $this->schoolSlug = '';
        $this->schoolDescription = null;
        $this->schoolIsActive = true;
        $this->schoolLogo = null;
        $this->existingLogoUrl = null;

        $this->adminName = '';
        $this->adminSurname = '';
        $this->adminEmail = '';
        $this->adminPassword = '';
        $this->adminPasswordConfirmation = '';

        $this->resetErrorBag();
    }
}

