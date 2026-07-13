<?php

namespace App\Livewire\Tutor;

use App\Models\LearningMaterial;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageLearningMaterials extends Component
{
    use WithFileUploads;

    public $subject_id;

    public $title;

    public $type = 'text';

    public $content;

    public $file;

    public $selectedSubject = null;

    protected $rules = [
        'subject_id' => 'required|exists:subjects,id',
        'title' => 'required|string|max:255',
        'type' => 'required|in:text,video,file',
        'content' => 'required_if:type,text,video',
        'file' => 'required_if:type,file|max:10240', // 10MB limit
    ];

    public function mount($subject_id = null)
    {
        if ($subject_id) {
            $this->subject_id = $subject_id;
            $this->selectedSubject = Subject::findOrFail($subject_id);
            if ($this->selectedSubject->tutor_id !== Auth::id()) {
                abort(403);
            }
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'subject_id' => $this->subject_id,
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
        $subjects = Subject::where('tutor_id', Auth::id())->get();
        $materials = [];

        if ($this->subject_id) {
            $materials = LearningMaterial::where('subject_id', $this->subject_id)->orderBy('created_at', 'desc')->get();
        }

        return view('livewire.tutor.manage-learning-materials', [
            'subjects' => $subjects,
            'materials' => $materials,
        ]);
    }
}
