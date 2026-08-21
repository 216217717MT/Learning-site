<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'slug' => fake()->slug(),
            'name' => fake()->name(),
            'icon' => fake()->regexify('[A-Za-z0-9]{20}'),
            'sort_order' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
