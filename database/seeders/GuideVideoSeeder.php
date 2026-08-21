<?php

namespace Database\Seeders;

use App\Models\Guide;
use Illuminate\Database\Seeder;

class GuideVideoSeeder extends Seeder
{
    public function run(): void
    {
        // Guide title => video link. If a guide's title doesn't match
        // exactly, that video will just be skipped (and printed below).
        $videos = [
            'Changing your password before it expires' => 'https://youtube.com/shorts/HaLZ3xKiIP8',
            'Logging into Blackboard for online classes' => 'https://youtube.com/shorts/HaLZ3xKiIP8',
            'Unlocking your account after too many attempts' => 'https://youtube.com/shorts/L0AbevCWjkA',
            'Resetting your student password' => 'https://youtube.com/shorts/y4LETEgePV0',
            'Connecting to CPUT wifi' => 'https://youtube.com/shorts/HaLZ3xKiIP8',
            'Getting your proof of registration' => 'https://youtube.com/shorts/L0AbevCWjkA',
            'Reporting a lecturer who is not attending scheduled classes' => 'https://youtube.com/shorts/L0AbevCWjkA',
            'Applying for a deferred exam or sick test on CRIMS' => 'https://youtube.com/shorts/HaLZ3xKiIP8',
            'Checking your marks on CRIMS' => 'https://youtube.com/shorts/y4LETEgePV0',
            'Joining a Microsoft Teams class link' => 'https://youtube.com/shorts/L0AbevCWjkA',
            'Printing from your own laptop on campus' => 'https://youtube.com/shorts/HaLZ3xKiIP8',
            'Loading printing credits' => 'https://youtube.com/shorts/L0AbevCWjkA',
            'Recovering a locked student email account' => 'https://youtube.com/shorts/HaLZ3xKiIP8',
            'Setting up your student email on your phone' => 'https://youtube.com/shorts/HaLZ3xKiIP8',
            'Applying for a deferred or aegrotat exam' => 'https://youtube.com/shorts/y4LETEgePV0',
            'Registering online for the new academic year' => 'https://youtube.com/shorts/HaLZ3xKiIP8',
            'Wifi is connected but you have no internet access' => 'https://youtube.com/shorts/HaLZ3xKiIP8',
            'Connecting to eduroam off campus' => 'https://youtube.com/shorts/y4LETEgePV0',
        ];

        foreach ($videos as $title => $url) {
            $guide = Guide::where('title', $title)->first();

            if (! $guide) {
                echo "Could not find a guide titled: {$title}\n";
                continue;
            }

            $alreadyExists = $guide->guideVideos()->where('video_url', $url)->exists();

            if ($alreadyExists) {
                echo "Already added, skipping: {$title}\n";
                continue;
            }

            $guide->guideVideos()->create([
                'provider' => 'youtube',
                'video_url' => $url,
                'sort_order' => 0,
            ]);

            echo "Added video to: {$title}\n";
        }
    }
}
