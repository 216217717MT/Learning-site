<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuideVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'guide_id',
        'provider',
        'video_url',
        'duration_seconds',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'guide_id' => 'integer',
        ];
    }

    public function guide(): BelongsTo
    {
        return $this->belongsTo(Guide::class);
    }

    // Takes whatever URL an admin pasted in (a normal "watch" link,
    // a short youtu.be link, a Vimeo page link) and converts it into
    // the special "embed" link format needed to actually play the
    // video inside an <iframe> on the page. Without this, pasting a
    // normal YouTube link into an <iframe> just shows a blank box.
    public function getEmbedUrlAttribute(): ?string
    {
        $url = $this->video_url;

        if ($this->provider === 'youtube') {
            // Matches both:
            //   https://www.youtube.com/watch?v=VIDEOID
            //   https://youtu.be/VIDEOID
            if (preg_match('/(?:youtu\.be\/|v=)([A-Za-z0-9_-]{11})/', $url, $matches)) {
                return 'https://www.youtube.com/embed/' . $matches[1];
            }
        }

        if ($this->provider === 'youtube') {
            if (preg_match('/(?:youtu\.be\/|v=|shorts\/)([A-Za-z0-9_-]{11})/', $url, $matches)) {
                return 'https://www.youtube.com/embed/' . $matches[1] . '?enablejsapi=1';
            }
        }

        // 'upload' provider, or a URL we couldn't recognize -- fall back
        // to the raw URL as-is (the Blade view will just show a link
        // instead of an embedded player in this case).
        return null;
    }
}
