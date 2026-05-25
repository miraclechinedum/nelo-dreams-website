@props(['name', 'stroke' => 1.6])

@php
    // Outline (stroke) icons — Heroicons-style, viewBox 0 0 24 24
    $outline = [
        'users' => '<path d="M18 18.7a3 3 0 0 0-6 0M9 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm9 4a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5ZM3 19a4.5 4.5 0 0 1 9 0"/>',
        'academic-cap' => '<path d="m12 5 9 4-9 4-9-4 9-4Z"/><path d="M21 9v4M7 11v5c0 .9 2.2 2.4 5 2.4S17 16.9 17 16v-5"/>',
        'map-pin' => '<path d="M12 21s7-5.3 7-11a7 7 0 1 0-14 0c0 5.7 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/>',
        'heart' => '<path d="M12 20s-7-4.4-7-9.5A3.8 3.8 0 0 1 12 7a3.8 3.8 0 0 1 7-.5C19 11.6 12 20 12 20Z"/>',
        'sparkles' => '<path d="M12 4l1.6 4.4L18 10l-4.4 1.6L12 16l-1.6-4.4L6 10l4.4-1.6L12 4Z"/><path d="M18 15l.7 1.8L20.5 17l-1.8.7L18 19.5l-.7-1.8L15.5 17l1.8-.5L18 15Z"/>',
        'hand-raised' => '<path d="M9 11V5.5a1.5 1.5 0 0 1 3 0V10m0 0V4.5a1.5 1.5 0 0 1 3 0V11m0-1.5a1.5 1.5 0 0 1 3 0V15a6 6 0 0 1-6 6h-1a6 6 0 0 1-5.2-3l-2-3.4a1.5 1.5 0 0 1 2.5-1.6L9 13.5"/>',
        'trophy' => '<path d="M8 4h8v5a4 4 0 0 1-8 0V4Z"/><path d="M8 5H5v1a3 3 0 0 0 3 3M16 5h3v1a3 3 0 0 1-3 3M10 14h4M9 20h6M12 14v6"/>',
        'megaphone' => '<path d="M4 10v4a1 1 0 0 0 1 1h2l4 4V5L7 9H5a1 1 0 0 0-1 1Z"/><path d="M11 5l8-2v18l-8-2M16 9a3 3 0 0 1 0 6"/>',
        'arrow-right' => '<path d="M5 12h14m-6-6 6 6-6 6"/>',
        'arrow-up-right' => '<path d="M7 17 17 7M8 7h9v9"/>',
        'arrow-long-right' => '<path d="M4 12h16m-5-5 5 5-5 5"/>',
        'check' => '<path d="m5 13 4 4L19 7"/>',
        'check-circle' => '<circle cx="12" cy="12" r="9"/><path d="m8.5 12 2.5 2.5L16 9"/>',
        'chevron-down' => '<path d="m6 9 6 6 6-6"/>',
        'envelope' => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6"/>',
        'phone' => '<path d="M5 4h3l1.5 5-2 1.5a12 12 0 0 0 6 6l1.5-2 5 1.5V20a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2Z"/>',
        'brain' => '<path d="M9.5 5A2.5 2.5 0 0 0 7 7.5 2.5 2.5 0 0 0 5 12a2.5 2.5 0 0 0 2 4.5A2.5 2.5 0 0 0 12 19V5a2.5 2.5 0 0 0-2.5 0Z"/><path d="M14.5 5A2.5 2.5 0 0 1 17 7.5 2.5 2.5 0 0 1 19 12a2.5 2.5 0 0 1-2 4.5A2.5 2.5 0 0 1 12 19"/>',
        'shield-check' => '<path d="M12 3 5 6v5c0 4.5 3 7.6 7 9 4-1.4 7-4.5 7-9V6l-7-3Z"/><path d="m9 12 2 2 4-4"/>',
        'chart' => '<path d="M4 20h16M7 16v-4m5 4V8m5 8v-6"/>',
        'lightbulb' => '<path d="M9 18h6m-5 3h4M12 3a6 6 0 0 0-4 10.5c.6.6 1 1.3 1 2.1V16h6v-.4c0-.8.4-1.5 1-2.1A6 6 0 0 0 12 3Z"/>',
        'puzzle' => '<path d="M10 4h4v2a1.5 1.5 0 0 0 3 0V4h3v3h-2a1.5 1.5 0 0 0 0 3h2v4h-2a1.5 1.5 0 0 1 0 3h2v3h-4v-2a1.5 1.5 0 0 0-3 0v2H6v-4H4a1.5 1.5 0 0 1 0-3h2v-4H4a1.5 1.5 0 0 1 0-3h2V4Z"/>',
        'compass' => '<circle cx="12" cy="12" r="9"/><path d="m15 9-2 5-4 1 2-5 4-1Z"/>',
        'scale' => '<path d="M12 4v16M6 7h12M6 7 3 14h6L6 7Zm12 0-3 7h6l-3-7ZM8 20h8"/>',
        'fire' => '<path d="M12 3s4 3 4 7a4 4 0 0 1-8 0c0-1 .5-2 .5-2S6 11 6 14a6 6 0 0 0 12 0c0-5-6-11-6-11Z"/>',
        'link' => '<path d="M9 15l6-6M10 6.5 12 4.5a3.5 3.5 0 0 1 5 5l-2 2M14 17.5 12 19.5a3.5 3.5 0 0 1-5-5l2-2"/>',
        'menu' => '<path d="M4 7h16M4 12h16M4 17h16"/>',
        'close' => '<path d="M6 6l12 12M18 6 6 18"/>',
        'quote' => '<path d="M10 7H6a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h2v1a2 2 0 0 1-2 2m12-10h-4a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h2v1a2 2 0 0 1-2 2"/>',
        'play' => '<circle cx="12" cy="12" r="9"/><path d="m10 9 5 3-5 3V9Z" fill="currentColor" stroke="none"/>',
        'globe' => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3a14 14 0 0 1 0 18 14 14 0 0 1 0-18Z"/>',
        'calendar' => '<rect x="4" y="5" width="16" height="16" rx="2"/><path d="M4 9h16M8 3v4m8-4v4"/>',
    ];

    // Solid (fill) brand / social icons
    $solid = [
        'facebook' => '<path d="M14 9h2.5V6H14c-2 0-3.5 1.5-3.5 3.6V12H8v3h2.5v6H14v-6h2.3l.7-3H14V9.8c0-.5.4-.8 1-.8Z"/>',
        'instagram' => '<path d="M7.5 3h9A4.5 4.5 0 0 1 21 7.5v9A4.5 4.5 0 0 1 16.5 21h-9A4.5 4.5 0 0 1 3 16.5v-9A4.5 4.5 0 0 1 7.5 3Zm0 2A2.5 2.5 0 0 0 5 7.5v9A2.5 2.5 0 0 0 7.5 19h9a2.5 2.5 0 0 0 2.5-2.5v-9A2.5 2.5 0 0 0 16.5 5h-9ZM12 8a4 4 0 1 1 0 8 4 4 0 0 1 0-8Zm0 2a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm4.5-2.5a1 1 0 1 1 0 2 1 1 0 0 1 0-2Z"/>',
        'x-social' => '<path d="M17.5 3h3l-6.6 7.5L21.7 21h-6l-4.3-5.7L6.5 21h-3l7-8L2.6 3h6.1l3.9 5.2L17.5 3Zm-1 16h1.6L7.6 4.7H5.9L16.5 19Z"/>',
        'linkedin' => '<path d="M6.5 8.5h-3V21h3V8.5ZM5 3.5A1.8 1.8 0 1 0 5 7a1.8 1.8 0 0 0 0-3.5ZM21 21h-3v-6.3c0-1.6-.6-2.5-1.9-2.5-1 0-1.6.7-1.9 1.4-.1.2-.1.6-.1.9V21h-3V8.5h3v1.7c.4-.7 1.3-1.7 3-1.7 2.2 0 3.8 1.4 3.8 4.5V21Z"/>',
        'youtube' => '<path d="M22 12c0-1.9-.2-3.3-.4-4.1a2.7 2.7 0 0 0-1.9-1.9C18.2 5.7 12 5.7 12 5.7s-6.2 0-7.7.3A2.7 2.7 0 0 0 2.4 7.9C2.2 8.7 2 10.1 2 12s.2 3.3.4 4.1a2.7 2.7 0 0 0 1.9 1.9c1.5.3 7.7.3 7.7.3s6.2 0 7.7-.3a2.7 2.7 0 0 0 1.9-1.9c.2-.8.4-2.2.4-4.1Zm-12 3V9l5 3-5 3Z"/>',
    ];
@endphp

@if (isset($solid[$name]))
    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" {{ $attributes->merge(['class' => 'h-5 w-5']) }}>
        {!! $solid[$name] !!}
    </svg>
@else
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}"
         stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"
         {{ $attributes->merge(['class' => 'h-6 w-6']) }}>
        {!! $outline[$name] ?? $outline['sparkles'] !!}
    </svg>
@endif
