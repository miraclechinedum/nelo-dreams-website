<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MediaItem extends Model
{
    use Publishable;

    protected $fillable = [
        'post_id', 'type', 'path', 'poster', 'title', 'caption',
        'category', 'span', 'in_gallery', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'in_gallery' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /** Only the items chosen to appear in the home-page "From the field" grid. */
    public function scopeInGallery(Builder $query): Builder
    {
        return $query->where('in_gallery', true);
    }

    public function isVideo(): bool
    {
        return $this->type === 'video';
    }

    /** The still image to show: the photo itself, or a video's poster frame. */
    public function stillPath(): ?string
    {
        return $this->isVideo() ? $this->poster : $this->path;
    }
}
