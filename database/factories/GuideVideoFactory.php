<?php

namespace Database\Factories;

use App\Models\Guide;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideVideoFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'guide_id' => Guide::factory(),
            'provider' => fake()->randomElement(["youtube","vimeo","upload"]),
            'video_url' => fake()->regexify('[A-Za-z0-9]{500}'),
            'duration_seconds' => fake()->numberBetween(-10000, 10000),
            'sort_order' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
