<?php

namespace Database\Factories;

use App\Models\Phase;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Phase>
 */
class PhaseFactory extends Factory
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
            'name' => 'Phase '.fake()->unique()->numberBetween(1, 100),
            'description' => fake()->sentence(),
        ];
    }
}
