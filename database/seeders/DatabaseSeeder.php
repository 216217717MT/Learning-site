<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            GuideSeeder::class,
            GuideStepSeeder::class,
            GuideVideoSeeder::class,
            GuideFeedbackSeeder::class,
            GuideViewSeeder::class,
            SearchLogSeeder::class,
            AuditLogSeeder::class,
        ]);
    }
}
