<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Models\LearningMaterial;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ViewLearningMaterials extends Component
{
    public Course $course;
    public $selectedMaterial = null;

    public function mount(Course $course)
    {
        // Check if student is enrolled in the course
        if (!Auth::user()->courses->contains($course->id)) {
            abort(403, 'You are not enrolled in this course.');
        }

        $this->course = $course;
        
        // Auto-select the first material if it exists
        $firstMaterial = LearningMaterial::where('course_id', $course->id)->orderBy('created_at', 'asc')->first();
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
        $materials = LearningMaterial::where('course_id', $this->course->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.student.view-learning-materials', [
            'materials' => $materials,
        ]);
    }
}
