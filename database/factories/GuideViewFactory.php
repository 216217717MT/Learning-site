<?php

namespace Database\Factories;

use App\Models\Guide;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideViewFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'guide_id' => Guide::factory(),
            'user_id' => User::factory(),
            'viewed_at' => fake()->dateTime(),
        ];
    }
}
