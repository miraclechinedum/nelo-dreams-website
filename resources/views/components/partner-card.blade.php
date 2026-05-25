@props([
    'name',
    'tagline' => null,
    'description' => null,
    'logo' => null,
    'website' => null,
    'role' => null,        // small label, e.g. "Technology Partner"
])

@php
    // Resolve the logo across common extensions so dropping in any format works.
    $logoPath = null;
    if ($logo) {
        $base = preg_replace('/\.[^.]+$/', '', $logo);
        $candidates = array_merge([$logo], array_map(fn ($e) => "{$base}.{$e}", ['png', 'svg', 'webp', 'jpg', 'jpeg']));
        $logoPath = collect($candidates)->first(fn ($p) => file_exists(public_path($p)));
    }
    $hasLogo = (bool) $logoPath;
    $initials = \Illuminate\Support\Str::of($name)->explode(' ')->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('');
    $host = $website ? preg_replace('#^https?://(www\.)?#', '', rtrim($website, '/')) : null;
@endphp

<article {{ $attributes->merge(['class' => 'group surface flex h-full flex-col gap-5 p-7 transition-all duration-500 hover:-translate-y-1 hover:border-electric-200']) }}>
    <div class="flex items-center gap-4">
        <span class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-white ring-1 ring-navy-100">
            @if ($hasLogo)
                <img src="{{ asset($logoPath) }}" alt="{{ $name }} logo" class="h-full w-full object-contain p-1.5" loading="lazy" />
            @else
                <span class="flex h-full w-full items-center justify-center rounded-2xl bg-gradient-to-br from-navy-900 to-electric-600 font-display text-lg font-extrabold text-white">{{ $initials }}</span>
            @endif
        </span>
        <div class="min-w-0">
            @if ($role)
                <span class="text-[11px] font-semibold uppercase tracking-[0.14em] text-electric-600">{{ $role }}</span>
            @endif
            <h3 class="truncate text-lg font-bold text-navy-900">{{ $name }}</h3>
            @if ($tagline)
                <p class="truncate text-sm text-navy-500">{{ $tagline }}</p>
            @endif
        </div>
    </div>

    @if ($description)
        <p class="text-[15px] leading-relaxed text-navy-600">{{ $description }}</p>
    @endif

    @if ($website)
        <a href="{{ $website }}" target="_blank" rel="noopener"
           class="mt-auto inline-flex items-center gap-2 pt-1 text-sm font-semibold text-electric-600 transition-colors hover:text-electric-700">
            {{ $host }}
            <x-icon name="arrow-up-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5" />
        </a>
    @endif
</article>
