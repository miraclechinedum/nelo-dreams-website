@props([
    'alt' => 'Nelo Dreams Foundation International',
])

@php
    // Use the real logo when present in public/images; otherwise render a
    // clean SVG emblem placeholder. Drop the real file at one of these paths.
    $candidates = ['images/logo-nelo.jpeg', 'images/logo-nelo.svg', 'images/logo-nelo.jpeg', 'images/logo-nelo.webp'];
    $found = collect($candidates)->first(fn ($p) => file_exists(public_path($p)));
@endphp

@if ($found)
    <img src="{{ asset($found) }}" alt="{{ $alt }}"
         {{ $attributes->merge(['class' => 'block h-full w-full rounded-full object-cover']) }} />
@else
    <svg viewBox="0 0 96 96" role="img" aria-label="{{ $alt }}"
         {{ $attributes->merge(['class' => 'block h-full w-full']) }}>
        <circle cx="48" cy="48" r="47" fill="#021B4E" />
        <circle cx="48" cy="48" r="40" fill="none" stroke="#0EA5E9" stroke-width="2.5" />
        <circle cx="48" cy="13" r="2" fill="#fff" />
        <circle cx="48" cy="83" r="2" fill="#fff" />
        <text x="48" y="46" text-anchor="middle" dominant-baseline="middle"
              font-family="'Plus Jakarta Sans', system-ui, sans-serif" font-size="26" font-weight="800" fill="#fff">ND</text>
        <text x="48" y="64" text-anchor="middle"
              font-family="'Plus Jakarta Sans', system-ui, sans-serif" font-size="6.2" letter-spacing="1.4" font-weight="600" fill="#7dd3fc">FOUNDATION INT’L</text>
    </svg>
@endif
