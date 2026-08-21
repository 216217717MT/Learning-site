<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['slug' => 'wifi', 'name' => 'Wifi', 'icon' => 'W', 'sort_order' => 1],
            ['slug' => 'registration', 'name' => 'Registration', 'icon' => 'R', 'sort_order' => 2],
            ['slug' => 'email', 'name' => 'Email', 'icon' => 'E', 'sort_order' => 3],
            ['slug' => 'printing', 'name' => 'Printing', 'icon' => 'P', 'sort_order' => 4],
            ['slug' => 'password', 'name' => 'Passwords', 'icon' => 'PW', 'sort_order' => 5],
            ['slug' => 'learning', 'name' => 'Learning Platforms', 'icon' => 'LP', 'sort_order' => 6],
            ['slug' => 'crims', 'name' => 'CRIMS', 'icon' => 'CR', 'sort_order' => 7],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
