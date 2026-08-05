<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use Publishable;

    protected $fillable = [
        'title', 'slug', 'category', 'location', 'period', 'happened_on',
        'summary', 'body', 'cover_image', 'hashtags', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'happened_on' => 'date',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /** Photos and videos attached to this post. */
    public function media(): HasMany
    {
        return $this->hasMany(MediaItem::class)->orderBy('sort_order')->orderBy('id');
    }

    /** Newest first — what a visitor expects from an updates feed. */
    public function scopeLatestFirst(Builder $query): Builder
    {
        return $query->orderByDesc('happened_on')->orderByDesc('id');
    }

    /** The cover, falling back to the first attached photo. */
    public function coverPath(): ?string
    {
        return $this->cover_image
            ?: $this->media->firstWhere('type', 'image')?->path
            ?: $this->media->first()?->poster;
    }

    /** A human date for display, preferring the hand-written label. */
    public function dateLabel(): ?string
    {
        return $this->period ?: $this->happened_on?->format('j F Y');
    }

    /** "#One #Two" → ['One', 'Two'] */
    public function hashtagList(): array
    {
        return collect(explode('#', (string) $this->hashtags))
            ->map(fn (string $tag) => trim($tag))
            ->filter()
            ->values()
            ->all();
    }
}
