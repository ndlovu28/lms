<?php

namespace App\Livewire\Su;

use App\Models\School;
use Livewire\Component;

class SuDashboard extends Component
{
    public function render()
    {
        return view('livewire.su.su-dashboard', [
            'schools' => School::query()->latest()->get(),
        ]);
    }
}
