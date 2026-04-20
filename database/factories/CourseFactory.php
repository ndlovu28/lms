<?php

namespace Database\Factories;

use App\Models\Course;
use App\Models\Phase;
use App\Models\School;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Course>
 */
class CourseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'school_id' => School::factory(),
            'tutor_id' => User::factory(),
            'phase_id' => Phase::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
        ];
    }
}
