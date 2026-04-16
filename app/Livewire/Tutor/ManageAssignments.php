<?php

namespace App\Livewire\Tutor;

use App\Models\Course;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class ManageAssignments extends Component
{
    use WithFileUploads;

    public $course_id;
    public $title;
    public $description;
    public $due_date;
    public $file;

    protected $rules = [
        'course_id' => 'required|exists:courses,id',
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'due_date' => 'required|after:now',
        'file' => 'nullable|max:10240', // 10MB
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'course_id' => $this->course_id,
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
        $courses = Course::where('tutor_id', Auth::id())->get();
        $assignments = [];
        
        if ($this->course_id) {
            $assignments = Assignment::where('course_id', $this->course_id)->orderBy('due_date', 'asc')->get();
        }

        return view('livewire.tutor.manage-assignments', [
            'courses' => $courses,
            'assignments' => $assignments,
        ]);
    }
}
