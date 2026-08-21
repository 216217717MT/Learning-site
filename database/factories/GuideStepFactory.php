<?php

namespace Database\Factories;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideStepFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'guide_id' => Guide::factory(),
            'step_number' => fake()->numberBetween(-10000, 10000),
            'content' => fake()->paragraphs(3, true),
        ];
    }
}
