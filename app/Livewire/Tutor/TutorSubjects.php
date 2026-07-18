<?php

namespace App\Livewire\Tutor;

use App\Models\LiveSession;
use App\Models\Subject;
use App\Services\ZoomService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TutorSubjects extends Component
{
    public function render()
    {
        $tutor = Auth::user();

        $subjects = Subject::query()
            ->where('school_id', $tutor->school_id)
            ->where('tutor_id', $tutor->id)
            ->with(['course.phase', 'activeSession'])
            ->withCount('students')
            ->orderBy('name')
            ->get();

        return view('livewire.tutor.tutor-subjects', [
            'subjects' => $subjects,
        ]);
    }

    public function startLiveSession(int $subjectId, ZoomService $zoomService): void
    {
        $subject = Subject::query()
            ->where('tutor_id', Auth::id())
            ->findOrFail($subjectId);

        // End any existing active session for this subject
        LiveSession::where('subject_id', $subjectId)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        try {
            $meeting = $zoomService->createMeeting($subject);

            LiveSession::create([
                'subject_id' => $subject->id,
                'tutor_id' => Auth::id(),
                'meeting_id' => $meeting['id'],
                'topic' => $meeting['topic'],
                'start_url' => $meeting['start_url'],
                'join_url' => $meeting['join_url'],
                'password' => $meeting['password'] ?? null,
                'is_active' => true,
            ]);

            session()->flash('success', 'Live session started successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to start live session: '.$e->getMessage());
        }
    }

    public function endLiveSession(int $subjectId): void
    {
        LiveSession::where('subject_id', $subjectId)
            ->where('tutor_id', Auth::id())
            ->where('is_active', true)
            ->update(['is_active' => false]);

        session()->flash('success', 'Live session ended.');
    }
}
