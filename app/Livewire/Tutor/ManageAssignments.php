<?php

namespace App\Livewire\Tutor;

use App\Models\Assignment;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageAssignments extends Component
{
    use WithFileUploads;

    public $subject_id;

    public $title;

    public $description;

    public $due_date;

    public $file;

    protected $rules = [
        'subject_id' => 'required|exists:subjects,id',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'due_date' => 'required|after:now',
        'file' => 'nullable|max:10240', // 10MB
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'subject_id' => $this->subject_id,
            'tutor_id' => Auth::id(),
            'title' => $this->title,
            'description' => $this->description,
            'due_date' => $this->due_date,
        ];

        if ($this->file) {
            $path = $this->file->store('assignments', 'public');
            $data['file_path'] = $path;
            $data['file_name'] = $this->file->getClientOriginalName();
        }

        Assignment::create($data);

        $this->reset(['title', 'description', 'due_date', 'file']);
        session()->flash('message', 'Assignment created successfully.');
    }

    public function deleteAssignment($id)
    {
        $assignment = Assignment::findOrFail($id);
        if ($assignment->tutor_id !== Auth::id()) {
            abort(403);
        }

        if ($assignment->file_path) {
            Storage::disk('public')->delete($assignment->file_path);
        }

        $assignment->delete();
        session()->flash('message', 'Assignment deleted successfully.');
    }

    public function render()
    {
        $subjects = Subject::where('tutor_id', Auth::id())->get();
        $assignments = [];

        if ($this->subject_id) {
            $assignments = Assignment::where('subject_id', $this->subject_id)->orderBy('due_date', 'asc')->get();
        }

        return view('livewire.tutor.manage-assignments', [
            'subjects' => $subjects,
            'assignments' => $assignments,
        ]);
    }
}
