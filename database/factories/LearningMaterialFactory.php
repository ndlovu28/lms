<?php

namespace Database\Factories;

use App\Models\LearningMaterial;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LearningMaterial>
 */
class LearningMaterialFactory extends Factory
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
            'type' => fake()->randomElement(['text', 'video', 'file']),
            'content' => fake()->paragraph(),
            'file_path' => fake()->optional()->filePath(),
            'file_name' => fake()->optional()->word().'.pdf',
        ];
    }
}
