<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class ImpactStory extends Model
{
    use Publishable;

    protected $fillable = [
        'title', 'slug', 'category', 'location', 'period', 'happened_on',
        'summary', 'body', 'image', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'happened_on' => 'date',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
