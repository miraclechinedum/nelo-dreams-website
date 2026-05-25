@props([
    'value' => 0,
    'label' => '',
    'suffix' => '',
    'prefix' => '',
    'icon' => null,
    'tone' => 'light',   // light = for dark backgrounds | dark = for light backgrounds
])

@php
    $valueColor = $tone === 'light' ? 'text-white' : 'text-navy-900';
    $labelColor = $tone === 'light' ? 'text-electric-100/70' : 'text-navy-500';
    $iconWrap = $tone === 'light' ? 'bg-white/10 text-electric-300' : 'bg-electric-50 text-electric-600';
@endphp

<div {{ $attributes->merge(['class' => 'flex flex-col gap-3']) }}
     x-data="counter({{ (int) $value }})"
     x-intersect.once="start()">
    @if ($icon)
        <span class="mb-1 inline-flex h-11 w-11 items-center justify-center rounded-2xl {{ $iconWrap }}">
            <x-icon :name="$icon" class="h-5 w-5" />
        </span>
    @endif

    <div class="flex items-baseline font-display text-4xl font-extrabold tracking-tight sm:text-5xl {{ $valueColor }}">
        @if ($prefix)<span>{{ $prefix }}</span>@endif
        <span x-text="display">0</span>
        @if ($suffix)<span class="text-electric-400">{{ $suffix }}</span>@endif
    </div>

    <p class="text-sm font-medium uppercase tracking-wide {{ $labelColor }}">{{ $label }}</p>
</div>
