<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SearchLogFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'query_text' => fake()->regexify('[A-Za-z0-9]{255}'),
            'normalized_query' => fake()->regexify('[A-Za-z0-9]{255}'),
            'result_count' => fake()->numberBetween(-10000, 10000),
            'user_id' => User::factory(),
        ];
    }
}
