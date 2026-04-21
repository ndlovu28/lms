<?php

namespace App\Livewire\Tutor;

use App\Models\Course;
use App\Models\LiveSession;
use App\Services\ZoomService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TutorCourses extends Component
{
    public function render()
    {
        $tutor = Auth::user();

        $courses = Course::query()
            ->where('school_id', $tutor->school_id)
            ->where('tutor_id', $tutor->id)
            ->with(['phase', 'activeSession'])
            ->withCount('students')
            ->orderBy('name')
            ->get();

        return view('livewire.tutor.tutor-courses', [
            'courses' => $courses,
        ]);
    }

    public function startLiveSession(int $courseId, ZoomService $zoomService): void
    {
        $course = Course::query()
            ->where('tutor_id', Auth::id())
            ->findOrFail($courseId);

        // End any existing active session for this course
        LiveSession::where('course_id', $courseId)
            ->where('is_active', true)
            ->update(['is_active' => false]);

        try {
            $meeting = $zoomService->createMeeting($course);

            LiveSession::create([
                'course_id' => $course->id,
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

    public function endLiveSession(int $courseId): void
    {
        LiveSession::where('course_id', $courseId)
            ->where('tutor_id', Auth::id())
            ->where('is_active', true)
            ->update(['is_active' => false]);

        session()->flash('success', 'Live session ended.');
    }
}
