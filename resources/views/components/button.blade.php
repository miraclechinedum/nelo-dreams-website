@props([
    'href' => null,
    'variant' => 'primary',   // primary | secondary | white | ghost
    'size' => 'md',           // sm | md | lg
    'icon' => 'arrow-right',  // trailing icon name, or null to hide
])

@php
    $base = 'group inline-flex items-center justify-center gap-2 rounded-full font-semibold transition-all duration-300 ease-out focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-electric-500 disabled:opacity-60 disabled:pointer-events-none';

    $sizes = [
        'sm' => 'px-5 py-2.5 text-sm',
        'md' => 'px-7 py-3.5 text-[15px]',
        'lg' => 'px-9 py-4 text-base',
    ];

    $variants = [
        'primary' => 'bg-electric-500 text-white shadow-lg shadow-electric-500/25 hover:bg-electric-600 hover:shadow-electric-500/40 hover:-translate-y-0.5',
        'secondary' => 'bg-navy-900 text-white shadow-lg shadow-navy-900/20 hover:bg-navy-800 hover:-translate-y-0.5',
        'white' => 'bg-white text-navy-900 shadow-lg shadow-navy-950/20 hover:bg-navy-50 hover:-translate-y-0.5',
        'ghost' => 'bg-white/0 text-navy-900 ring-1 ring-inset ring-navy-200 hover:ring-navy-300 hover:bg-navy-50',
        'ghost-light' => 'text-white ring-1 ring-inset ring-white/30 hover:bg-white/10 hover:ring-white/50',
    ];

    $classes = trim("$base {$sizes[$size]} ".($variants[$variant] ?? $variants['primary']));
    $tag = $href ? 'a' : 'button';
@endphp

<{{ $tag }}
    @if ($href) href="{{ $href }}" @endif
    {{ $attributes->merge(['class' => $classes]) }}
>
    <span>{{ $slot }}</span>
    @if ($icon)
        <x-icon :name="$icon" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
    @endif
</{{ $tag }}>
