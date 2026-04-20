<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tutor_id' => User::factory(),
            'course_id' => Course::factory(),
            'name' => fake()->words(2, true).' Quiz',
        ];
    }
}
