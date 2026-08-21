<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guide extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'tag',
        'slug',
        'title',
        'summary',
        'status',
        'views_count',
        'helpful_count',
        'not_helpful_count',
        'created_by_id',
        'updated_by_id',
        'published_at',
        'steps_document',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'category_id' => 'integer',
            'created_by_id' => 'integer',
            'updated_by_id' => 'integer',
            'published_at' => 'timestamp',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function guideSteps(): HasMany
    {
        return $this->hasMany(GuideStep::class);
    }

    public function guideVideos(): HasMany
    {
        return $this->hasMany(GuideVideo::class);
    }

    public function guideFeedbacks(): HasMany
    {
        return $this->hasMany(GuideFeedback::class);
    }

    public function guideViews(): HasMany
    {
        return $this->hasMany(GuideView::class);
    }
}
