<?php

namespace Database\Factories;

use App\Models\Assignment;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assignment>
 */
class AssignmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject_id' => Subject::factory(),
            'tutor_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'file_path' => fake()->optional()->filePath(),
            'file_name' => fake()->optional()->word().'.pdf',
            'due_date' => fake()->dateTimeBetween('now', '+1 month'),
        ];
    }
}
