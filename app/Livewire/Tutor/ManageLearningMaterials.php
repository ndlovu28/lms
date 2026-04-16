<?php

namespace App\Livewire\Tutor;

use App\Models\Course;
use App\Models\LearningMaterial;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageLearningMaterials extends Component
{
    use WithFileUploads;

    public $course_id;
    public $title;
    public $type = 'text';
    public $content;
    public $file;
    
    public $selectedCourse = null;

    protected $rules = [
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:255',
        'type' => 'required|in:text,video,file',
        'content' => 'required_if:type,text,video',
        'file' => 'required_if:type,file|max:10240', // 10MB limit
    ];

    public function mount($course_id = null)
    {
        if ($course_id) {
            $this->course_id = $course_id;
            $this->selectedCourse = Course::findOrFail($course_id);
            if ($this->selectedCourse->tutor_id !== Auth::id()) {
                abort(403);
            }
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'course_id' => $this->course_id,
            'tutor_id' => Auth::id(),
            'title' => $this->title,
            'type' => $this->type,
        ];

        if ($this->type === 'file' && $this->file) {
            $path = $this->file->store('learning-materials', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $this->file->getClientOriginalName();
        } else {
            $data['content'] = $this->content;
        }

        LearningMaterial::create($data);

        $this->reset(['title', 'content', 'file']);
        $this->dispatch('material-added');
        session()->flash('message', 'Material added successfully.');
    }

    public function deleteMaterial($id)
    {
        $material = LearningMaterial::findOrFail($id);
        if ($material->tutor_id !== Auth::id()) {
            abort(403);
        }

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();
        session()->flash('message', 'Material deleted successfully.');
    }

    public function render()
    {
        $courses = Course::where('tutor_id', Auth::id())->get();
        $materials = [];
        
        if ($this->course_id) {
            $materials = LearningMaterial::where('course_id', $this->course_id)->orderBy('created_at', 'desc')->get();
        }

        return view('livewire.tutor.manage-learning-materials', [
            'courses' => $courses,
            'materials' => $materials,
        ]);
    }
}
