<?php

namespace App\Livewire\Auth;

use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class Register extends Component
{
    public ?School $school = null;

    public string $schoolIdentifier = '';

    public string $name = '';

    public string $surname = '';

    public string $email = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public string $userType = 'student';

    public function render()
    {
        return view('livewire.auth.register');
    }

    public function findSchool(): void
    {
        $this->resetErrorBag('schoolIdentifier');

        $this->validate([
            'schoolIdentifier' => ['required', 'string'],
        ]);

        $this->loadSchoolBySlug($this->schoolIdentifier);
    }

    public function register(): void
    {
        $this->resetErrorBag();

        if (! $this->school) {
            $this->addError('schoolIdentifier', 'Please select a valid school before registering.');

            return;
        }

        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'passwordConfirmation' => ['same:password'],
            'userType' => ['required', 'in:student,tutor'],
        ]);

        $roleName = $this->userType === 'tutor' ? 'tutor' : 'student';

        $role = Role::query()
            ->where('name', $roleName)
            ->first();

        if (! $role) {
            $this->addError('userType', 'The selected user type is not available. Please contact support.');

            return;
        }

        User::query()->create([
            'role_id' => $role->id,
            'school_id' => $this->school->id,
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'status' => 1,
            'tutor_approved' => $this->userType === 'tutor' ? null : true,
        ]);

        $this->reset([
            'name',
            'surname',
            'email',
            'password',
            'passwordConfirmation',
            'userType',
        ]);

        session()->flash('registration_success', 'Registration successful. You can now log in.');
    }

    protected function loadSchoolBySlug(string $slug): void
    {
        $this->school = School::query()
            ->where('slug', $slug)
            ->first();

        if (! $this->school) {
            $this->addError('schoolIdentifier', 'School not found.');
            $this->schoolIdentifier = $slug;
        } else {
            $this->schoolIdentifier = $this->school->slug;
        }
    }
}
