<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use Publishable;

    protected $fillable = [
        'title', 'slug', 'category', 'summary', 'description',
        'icon', 'image', 'is_featured', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
