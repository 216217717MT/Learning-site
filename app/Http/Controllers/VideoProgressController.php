<?php

namespace App\Http\Controllers;

use App\Models\VideoProgress;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class VideoProgressController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        // We deliberately read the student number from the session (set
        // when they typed it in on the identify page), not from anything
        // the browser sends us directly -- this stops someone from faking
        // a different student number just by editing the page's JavaScript.
        $studentNumber = $request->session()->get('student_number');

        if (! $studentNumber) {
            return response()->json(['ok' => false], 403);
        }

        $data = $request->validate([
            'guide_id' => ['required', 'integer', 'exists:guides,id'],
            'guide_video_id' => ['required', 'integer', 'exists:guide_videos,id'],
            'status' => ['required', 'in:started,completed'],
            'percent_watched' => ['required', 'integer', 'min:0', 'max:100'],
        ]);

        $existing = VideoProgress::where('student_number', $studentNumber)
            ->where('guide_video_id', $data['guide_video_id'])
            ->first();

        // Never let percent watched go backwards, and never downgrade a
        // "completed" back to "started" just because they replayed part of it.
        $newPercent = max($existing->percent_watched ?? 0, $data['percent_watched']);
        $newStatus = ($existing && $existing->status === 'completed') ? 'completed' : $data['status'];

        VideoProgress::updateOrCreate(
            ['student_number' => $studentNumber, 'guide_video_id' => $data['guide_video_id']],
            [
                'guide_id' => $data['guide_id'],
                'status' => $newStatus,
                'percent_watched' => $newPercent,
                'last_watched_at' => now(),
            ]
        );

        return response()->json(['ok' => true]);
    }
}
