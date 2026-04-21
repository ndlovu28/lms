<?php

namespace Tests\Feature;

use App\Livewire\Student\StudentDashboard;
use App\Livewire\Tutor\TutorCourses;
use App\Models\Course;
use App\Models\LiveSession;
use App\Models\Phase;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use Tests\TestCase;

class ZoomIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected User $tutor;

    protected User $student;

    protected Course $course;

    protected function setUp(): void
    {
        parent::setUp();

        $school = School::factory()->create();
        $tutorRole = Role::create(['name' => 'tutor', 'description' => 'Tutor']);
        $studentRole = Role::create(['name' => 'student', 'description' => 'Student']);

        $this->tutor = User::factory()->create([
            'school_id' => $school->id,
            'role_id' => $tutorRole->id,
        ]);

        $this->student = User::factory()->create([
            'school_id' => $school->id,
            'role_id' => $studentRole->id,
        ]);

        $phase = Phase::factory()->create(['school_id' => $school->id]);

        $this->course = Course::factory()->create([
            'school_id' => $school->id,
            'tutor_id' => $this->tutor->id,
            'phase_id' => $phase->id,
        ]);

        $this->course->students()->attach($this->student->id);
    }

    public function test_tutor_can_start_live_session(): void
    {
        Http::fake([
            'zoom.us/oauth/token*' => Http::response(['access_token' => 'fake-token'], 200),
            'api.zoom.us/v2/users/me/meetings' => Http::response([
                'id' => '123456789',
                'topic' => 'Live Session: '.$this->course->name,
                'start_url' => 'https://zoom.us/s/123456789',
                'join_url' => 'https://zoom.us/j/123456789',
                'password' => '123456',
            ], 201),
        ]);

        Livewire::actingAs($this->tutor)
            ->test(TutorCourses::class)
            ->call('startLiveSession', $this->course->id)
            ->assertHasNoErrors()
            ->assertSee('Live session started successfully.');

        $this->assertDatabaseHas('live_sessions', [
            'course_id' => $this->course->id,
            'tutor_id' => $this->tutor->id,
            'meeting_id' => '123456789',
            'is_active' => true,
        ]);
    }

    public function test_tutor_can_end_live_session(): void
    {
        LiveSession::create([
            'course_id' => $this->course->id,
            'tutor_id' => $this->tutor->id,
            'meeting_id' => '123456789',
            'topic' => 'Test Topic',
            'start_url' => 'http://start',
            'join_url' => 'http://join',
            'is_active' => true,
        ]);

        Livewire::actingAs($this->tutor)
            ->test(TutorCourses::class)
            ->call('endLiveSession', $this->course->id)
            ->assertHasNoErrors()
            ->assertSee('Live session ended.');

        $this->assertDatabaseHas('live_sessions', [
            'course_id' => $this->course->id,
            'is_active' => false,
        ]);
    }

    public function test_student_sees_join_button_when_session_is_active(): void
    {
        LiveSession::create([
            'course_id' => $this->course->id,
            'tutor_id' => $this->tutor->id,
            'meeting_id' => '123456789',
            'topic' => 'Test Topic',
            'start_url' => 'http://start',
            'join_url' => 'http://join',
            'is_active' => true,
        ]);

        Livewire::actingAs($this->student)
            ->test(StudentDashboard::class)
            ->assertSee('Join Live Session')
            ->assertSee('http://join');
    }

    public function test_student_does_not_see_join_button_when_session_is_inactive(): void
    {
        LiveSession::create([
            'course_id' => $this->course->id,
            'tutor_id' => $this->tutor->id,
            'meeting_id' => '123456789',
            'topic' => 'Test Topic',
            'start_url' => 'http://start',
            'join_url' => 'http://join',
            'is_active' => false,
        ]);

        Livewire::actingAs($this->student)
            ->test(StudentDashboard::class)
            ->assertDontSee('Join Live Session');
    }
}
