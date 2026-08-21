<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class GuideFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::inRandomOrder()->first()?->id,
            'tag' => strtoupper(fake()->lexify('???')) . '-' . fake()->numberBetween(1, 99),
            'slug' => fake()->unique()->slug(),
            'title' => fake()->sentence(4),
            'summary' => fake()->text(120),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'views_count' => fake()->numberBetween(0, 200),
            'helpful_count' => fake()->numberBetween(0, 40),
            'not_helpful_count' => fake()->numberBetween(0, 15),
            'created_by_id' => User::factory(),
            'updated_by_id' => User::factory(),
            'published_at' => fake()->dateTime(),
        ];
    }
}
