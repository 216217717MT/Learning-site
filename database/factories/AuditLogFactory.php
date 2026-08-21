<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AuditLogFactory extends Factory
{
    public function definition(): array
    {
        return [
            'actor_id' => User::factory(),
            'action' => fake()->randomElement([
                'guide.created', 'guide.updated', 'guide.published',
                'guide.unpublished', 'guide.deleted', 'category.created',
            ]),
            'entity_type' => fake()->randomElement(['guide', 'category']),
            'entity_id' => Str::uuid(),
            'metadata' => '{}',
        ];
    }
}
