<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;

class Statistic extends Model
{
    use Publishable;

    protected $fillable = [
        'label', 'value', 'suffix', 'prefix', 'icon', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'value' => 'integer',
        'is_active' => 'boolean',
    ];
}
