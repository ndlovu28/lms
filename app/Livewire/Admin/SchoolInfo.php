<?php

namespace App\Livewire\Admin;

use App\Models\School;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

class SchoolInfo extends Component
{
    use WithFileUploads;

    public School $school;
    public string $name = '';
    public string $slug = '';
    public string $description = '';
    public $logo;

    public function mount()
    {
        $this->school = Auth::user()->school;
        $this->name = $this->school->name;
        $this->slug = $this->school->slug;
        $this->description = $this->school->description ?? '';
    }

    public function updateSchool()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('schools')->ignore($this->school->id)],
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048', // 2MB
        ]);

        $data = [
            'name' => $this->name,
            'slug' => Str::slug($this->slug),
            'description' => $this->description,
        ];

        if ($this->logo) {
            // Delete old logo if exists
            if ($this->school->logo_url) {
                Storage::disk('public')->delete($this->school->logo_url);
            }
            $data['logo_url'] = $this->logo->store('logos', 'public');
        }

        $this->school->update($data);

        $this->slug = $this->school->slug;
        $this->reset('logo');
        session()->flash('message', 'School information updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.school-info');
    }
}
