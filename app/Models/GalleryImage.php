<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class GalleryImage extends Model
{
    use Publishable;

    protected $fillable = [
        'title', 'caption', 'image', 'category', 'span', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
