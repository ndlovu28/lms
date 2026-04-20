<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\LearningMaterial;
use App\Models\Phase;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Role;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Roles
        $this->call(RoleSeeder::class);
        $roles = Role::all();
        $rolesMap = $roles->pluck('id', 'name');

        // 2. Create a Super User
        User::factory()->create([
            'name' => 'Super',
            'surname' => 'User',
            'email' => 'su@example.com',
            'password' => Hash::make('password'),
            'role_id' => $rolesMap['su'],
            'school_id' => null,
        ]);

        // 3. Loop to create 2 Schools
        for ($i = 1; $i <= 2; $i++) {
            $school = School::factory()->create([
                'name' => "School $i",
                'slug' => "school-$i",
            ]);

            // 4. Create 7 Phases for this school
            $phases = Phase::factory()->count(7)->create([
                'school_id' => $school->id,
            ]);

            // 5. Create 2 Admins for this school
            User::factory()->count(2)->recycle($school)->create([
                'role_id' => $rolesMap['admin'],
            ]);

            // 6. Create 5 Tutors for this school
            $tutors = User::factory()->count(5)->recycle($school)->create([
                'role_id' => $rolesMap['tutor'],
            ]);

            // 7. Create 10 Courses for this school
            $courses = Course::factory()
                ->count(10)
                ->recycle($school)
                ->recycle($tutors)
                ->recycle($phases)
                ->create()
                ->each(function ($course) {
                    // 8. Create some content for each course
                    LearningMaterial::factory()->count(3)->recycle($course)->create([
                        'tutor_id' => $course->tutor_id,
                    ]);

                    Assignment::factory()->count(2)->recycle($course)->create([
                        'tutor_id' => $course->tutor_id,
                    ]);

                    $quiz = Quiz::factory()->recycle($course)->create([
                        'tutor_id' => $course->tutor_id,
                    ]);

                    Question::factory()->count(5)->recycle($quiz)->create();
                });

            // 9. Create 20 Students for this school
            $students = User::factory()->count(20)->recycle($school)->create([
                'role_id' => $rolesMap['student'],
            ]);

            // 10. Distribute students among courses and create some activity
            foreach ($students as $student) {
                // Enroll each student in 2-3 random courses from their school
                $studentCourses = $courses->random(rand(2, 3));
                $student->courses()->attach($studentCourses->pluck('id'));

                foreach ($studentCourses as $course) {
                    // Create some assignment submissions
                    foreach ($course->assignments as $assignment) {
                        if (rand(0, 1)) {
                            AssignmentSubmission::factory()
                                ->recycle($assignment)
                                ->recycle($student)
                                ->create([
                                    'submitted_at' => now()->subDays(rand(1, 10)),
                                ]);
                        }
                    }

                    // Create some quiz attempts
                    foreach ($course->quizzes as $quiz) {
                        if (rand(0, 1)) {
                            QuizAttempt::factory()
                                ->recycle($quiz)
                                ->recycle($student)
                                ->create([
                                    'completed_at' => now()->subDays(rand(1, 10)),
                                ]);
                        }
                    }
                }
            }
        }
    }
}
