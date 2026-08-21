<?php

namespace Database\Seeders;

use App\Models\SearchLog;
use Illuminate\Database\Seeder;

class SearchLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SearchLog::factory()->count(5)->create();
    }
}
