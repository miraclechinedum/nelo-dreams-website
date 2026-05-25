@props([
    'icon' => null,
    'title' => null,
    'tone' => 'light',   // light = card on light bg | dark = card on dark bg
])

@php
    $shell = $tone === 'dark'
        ? 'rounded-3xl border border-white/10 bg-white/[0.05] p-7 backdrop-blur-sm'
        : 'surface p-7';
    $iconWrap = $tone === 'dark' ? 'bg-electric-500/15 text-electric-300' : 'bg-electric-50 text-electric-600';
    $titleColor = $tone === 'dark' ? 'text-white' : 'text-navy-900';
    $bodyColor = $tone === 'dark' ? 'text-electric-100/70' : 'text-navy-600';
@endphp

<div {{ $attributes->merge(['class' => "group flex h-full flex-col gap-4 transition-all duration-500 hover:-translate-y-1 $shell"]) }}>
    @if ($icon)
        <span class="inline-flex h-12 w-12 items-center justify-center rounded-2xl {{ $iconWrap }} transition-transform duration-500 group-hover:scale-110">
            <x-icon :name="$icon" class="h-6 w-6" />
        </span>
    @endif
    @if ($title)
        <h3 class="text-lg font-bold {{ $titleColor }}">{{ $title }}</h3>
    @endif
    <div class="text-[15px] leading-relaxed {{ $bodyColor }}">{{ $slot }}</div>
</div>
