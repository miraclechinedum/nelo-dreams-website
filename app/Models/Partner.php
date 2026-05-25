<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use Publishable;

    protected $fillable = [
        'name', 'tagline', 'description', 'logo', 'website',
        'is_strategic', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_strategic' => 'boolean',
        'is_active' => 'boolean',
    ];
}
