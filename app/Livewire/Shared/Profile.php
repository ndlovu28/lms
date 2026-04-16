<?php

namespace App\Livewire\Shared;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Profile extends Component
{
    public ?User $user = null;
    
    public string $name = '';
    public string $surname = '';
    public string $email = '';
    public string $password = '';
    public ?int $role_id = null;
    public ?int $status = null;
    
    public bool $isEditingOther = false;

    public function mount(?User $user = null)
    {
        // If no user provided, use authenticated user
        if (!$user || $user->id === null) {
            $this->user = Auth::user();
            $this->isEditingOther = false;
        } else {
            $this->user = $user;
            $this->isEditingOther = Auth::id() !== $user->id;
            
            // Check permission to edit others
            if ($this->isEditingOther && !in_array(Auth::user()->role->name, ['su', 'admin'])) {
                abort(403, 'Unauthorized to edit other users.');
            }
        }

        $this->name = $this->user->name;
        $this->surname = $this->user->surname;
        $this->email = $this->user->email;
        $this->role_id = $this->user->role_id;
        $this->status = $this->user->status;
    }

    public function updateProfile()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($this->user->id)],
            'password' => 'nullable|min:8',
        ];

        $currentAuthRole = Auth::user()->role->name;

        // Only Admin/SU can change roles or status
        if (in_array($currentAuthRole, ['su', 'admin'])) {
            $rules['role_id'] = [
                'required',
                'exists:roles,id',
                function ($attribute, $value, $fail) use ($currentAuthRole) {
                    $selectedRole = \App\Models\Role::find($value);
                    if ($selectedRole && $selectedRole->name === 'su' && $currentAuthRole !== 'su') {
                        $fail('Only Super Users can assign the Super User role.');
                    }
                },
            ];
            $rules['status'] = 'required|in:0,1';
        }

        $this->validate($rules);

        $data = [
            'name' => $this->name,
            'surname' => $this->surname,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if (in_array($currentAuthRole, ['su', 'admin'])) {
            $data['role_id'] = $this->role_id;
            $data['status'] = $this->status;
        }

        $this->user->update($data);

        $this->password = '';
        session()->flash('message', 'Profile updated successfully.');
    }

    public function render()
    {
        $roles = [];
        $currentAuthRole = Auth::user()->role->name;

        if (in_array($currentAuthRole, ['su', 'admin'])) {
            $rolesQuery = Role::query();
            
            // If Admin, hide the 'su' role from the list
            if ($currentAuthRole === 'admin') {
                $rolesQuery->where('name', '!=', 'su');
            }
            
            $roles = $rolesQuery->get();
        }

        return view('livewire.shared.profile', [
            'roles' => $roles,
        ]);
    }
}
