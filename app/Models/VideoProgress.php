<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoProgress extends Model
{
    protected $fillable = [
        'student_number',
        'guide_id',
        'guide_video_id',
        'status',
        'percent_watched',
        'last_watched_at',
    ];

    protected $casts = [
        'last_watched_at' => 'datetime',
    ];

    public function guide(): BelongsTo
    {
        return $this->belongsTo(Guide::class);
    }

    public function guideVideo(): BelongsTo
    {
        return $this->belongsTo(GuideVideo::class);
    }
}
