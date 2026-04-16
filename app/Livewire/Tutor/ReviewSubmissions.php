<?php

namespace App\Livewire\Tutor;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ReviewSubmissions extends Component
{
    public Assignment $assignment;
    public $feedback = [];
    public $grade = [];

    public function mount(Assignment $assignment)
    {
        if ($assignment->tutor_id !== Auth::id()) {
            abort(403);
        }
        $this->assignment = $assignment;

        foreach ($assignment->submissions as $submission) {
            $this->feedback[$submission->id] = $submission->feedback;
            $this->grade[$submission->id] = $submission->grade;
        }
    }

    public function saveReview($submissionId)
    {
        $submission = AssignmentSubmission::findOrFail($submissionId);
        
        $submission->update([
            'feedback' => $this->feedback[$submissionId],
            'grade' => $this->grade[$submissionId],
            'status' => 'reviewed',
        ]);

        session()->flash('message-'.$submissionId, 'Review saved.');
    }

    public function render()
    {
        $submissions = AssignmentSubmission::where('assignment_id', $this->assignment->id)
            ->with('user')
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('livewire.tutor.review-submissions', [
            'submissions' => $submissions,
        ]);
    }
}
