<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class StudentAssignments extends Component
{
    use WithFileUploads;

    public Course $course;
    public $submissionFile;
    public $selectedAssignmentId;

    public function mount(Course $course)
    {
        if (!Auth::user()->courses->contains($course->id)) {
            abort(403);
        }
        $this->course = $course;
    }

    public function submitWork($assignmentId)
    {
        $this->validate([
            'submissionFile' => 'required|max:10240', // 10MB
        ]);

        $assignment = Assignment::findOrFail($assignmentId);
        
        // Delete previous submission file if exists
        $oldSubmission = AssignmentSubmission::where('assignment_id', $assignmentId)
            ->where('user_id', Auth::id())
            ->first();

        if ($oldSubmission) {
            Storage::disk('public')->delete($oldSubmission->file_path);
        }

        $path = $this->submissionFile->store('submissions', 'public');

        AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $assignmentId,
                'user_id' => Auth::id(),
            ],
            [
                'file_path' => $path,
                'file_name' => $this->submissionFile->getClientOriginalName(),
                'submitted_at' => now(),
                'status' => 'pending'
            ]
        );

        $this->reset('submissionFile');
        session()->flash('message', 'Work submitted successfully.');
    }

    public function render()
    {
        $assignments = Assignment::where('course_id', $this->course->id)
            ->with(['submissions' => function($query) {
                $query->where('user_id', Auth::id());
            }])
            ->orderBy('due_date', 'asc')
            ->get();

        return view('livewire.student.student-assignments', [
            'assignments' => $assignments,
        ]);
    }
}
