<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'interest', 'is_handled',
    ];

    protected $casts = [
        'is_handled' => 'boolean',
    ];
}
