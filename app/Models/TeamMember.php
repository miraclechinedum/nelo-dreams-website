<?php

namespace App\Models;

use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TeamMember extends Model
{
    use Publishable;

    protected $fillable = [
        'name', 'role', 'photo', 'bio', 'email', 'phone',
        'facebook_url', 'linkedin_url', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** Titles that are not part of someone's name, so they never become an initial. */
    private const HONORIFICS = ['coach', 'dr', 'dr.', 'mr', 'mr.', 'mrs', 'mrs.', 'ms', 'ms.', 'prof', 'prof.', 'rev', 'rev.', 'engr', 'engr.'];

    /**
     * First and last name initials — the fallback shown when there is no photo.
     * "Coach Ebere Amariazu" → "EA", "Amaka S Obi" → "AO".
     */
    public function initials(): string
    {
        $words = Str::of($this->name)
            ->squish()
            ->explode(' ')
            ->reject(fn (string $word) => in_array(Str::lower($word), self::HONORIFICS, true))
            ->filter()
            ->values();

        if ($words->isEmpty()) {
            return '?';
        }

        $letters = $words->count() === 1
            ? [$words->first()]
            : [$words->first(), $words->last()];

        return collect($letters)
            ->map(fn (string $word) => mb_strtoupper(mb_substr($word, 0, 1)))
            ->implode('');
    }

    /** Whether the photo on record is actually on disk. */
    public function hasPhoto(): bool
    {
        return (bool) $this->photo && file_exists(public_path($this->photo));
    }
}
