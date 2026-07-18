<?php

namespace App\Livewire\Student;

use App\Models\Subject;
use App\Models\LearningMaterial;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewLearningMaterials extends Component
{
    public $course = [];
    public $selectedMaterial = null;
    public $cur_id;

    public function mount($subject)
    {
        // Check if student is enrolled in the course
        // if (!Auth::user()->subjects->contains($course->id)) {
            // abort(403, 'You are not enrolled in this course.');
        // }
        $course = Subject::find($subject);
        $this->cur_id = $subject;

        $this->course = $course;
        
        // Auto-select the first material if it exists
        $firstMaterial = LearningMaterial::where('subject_id', $subject)->orderBy('created_at', 'asc')->first();
        if ($firstMaterial) {
            $this->selectedMaterial = $firstMaterial;
        }
    }

    public function selectMaterial($id)
    {
        $this->selectedMaterial = LearningMaterial::findOrFail($id);
        $this->dispatch('material-selected');
    }

    public function render()
    {
        $materials = LearningMaterial::where('subject_id', $this->cur_id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.student.view-learning-materials', [
            'materials' => $materials,
        ]);
    }
}
