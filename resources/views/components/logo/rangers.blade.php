@props([
    'alt' => 'Rangers International FC Foundation',
])

@php
    // Drop the real Rangers Foundation logo at one of these paths to replace
    // the SVG placeholder below.
    $candidates = ['images/logo-rangers.png', 'images/logo-rangers.svg', 'images/logo-rangers.jpg', 'images/logo-rangers.webp'];
    $found = collect($candidates)->first(fn ($p) => file_exists(public_path($p)));
@endphp

@if ($found)
    <img src="{{ asset($found) }}" alt="{{ $alt }}"
         {{ $attributes->merge(['class' => 'block h-full w-full object-contain']) }} />
@else
    <svg viewBox="0 0 120 120" role="img" aria-label="{{ $alt }}"
         {{ $attributes->merge(['class' => 'block h-full w-full']) }}>
        <rect width="120" height="120" rx="16" fill="#D11F26" />
        <path d="M60 24l5.5 11.2L78 37l-9 8.8 2.1 12.4L60 52.4 48.9 58.2 51 45.8 42 37l12.5-1.8L60 24Z" fill="#fff" />
        <text x="60" y="78" text-anchor="middle"
              font-family="'Plus Jakarta Sans', system-ui, sans-serif" font-size="13" font-weight="800" letter-spacing="0.5" fill="#fff">RANGERS</text>
        <text x="60" y="94" text-anchor="middle"
              font-family="'Plus Jakarta Sans', system-ui, sans-serif" font-size="7.5" letter-spacing="3" font-weight="600" fill="#fff">FOUNDATION</text>
    </svg>
@endif
