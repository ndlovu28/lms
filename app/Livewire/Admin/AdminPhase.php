<?php

namespace App\Livewire\Admin;

use App\Models\Phase;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminPhase extends Component
{
    public ?int $editingPhaseId = null;

    public string $name = '';

    public ?string $description = null;

    public function render()
    {
        $schoolId = $this->currentSchoolId();

        return view('livewire.admin.admin-phase', [
            'phases' => Phase::query()
                ->where('school_id', $schoolId)
                ->withCount('courses')
                ->latest()
                ->get(),
        ]);
    }

    public function startCreate(): void
    {
        $this->resetForm();
    }

    public function startEdit(int $phaseId): void
    {
        $phase = Phase::query()
            ->where('school_id', $this->currentSchoolId())
            ->findOrFail($phaseId);

        $this->editingPhaseId = $phase->id;
        $this->name = $phase->name;
        $this->description = $phase->description;

        $this->resetErrorBag();
    }

    public function save(): void
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $schoolId = $this->currentSchoolId();

        if ($this->editingPhaseId) {
            $phase = Phase::query()
                ->where('school_id', $schoolId)
                ->findOrFail($this->editingPhaseId);
            $phase->update([
                'school_id' => $schoolId,
                'name' => $this->name,
                'description' => $this->description,
            ]);
        } else {
            Phase::query()->create([
                'school_id' => $schoolId,
                'name' => $this->name,
                'description' => $this->description,
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
        $this->editingPhaseId = null;
        $this->name = '';
        $this->description = null;

        $this->resetErrorBag();
    }
}
