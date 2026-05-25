@props([
    'eyebrow' => null,
    'title' => null,
    'align' => 'left',     // left | center
    'tone' => 'dark',      // dark (on light bg) | light (on dark bg)
    'as' => 'h2',
])

@php
    $isCenter = $align === 'center';
    $wrap = $isCenter ? 'mx-auto max-w-3xl text-center items-center' : 'max-w-3xl';
    $titleColor = $tone === 'light' ? 'text-white' : 'text-navy-900';
    $bodyColor = $tone === 'light' ? 'text-electric-100/80' : 'text-navy-600';
@endphp

<div {{ $attributes->merge(['class' => "flex flex-col gap-5 $wrap"]) }}>
    @if ($eyebrow)
        <span class="eyebrow {{ $tone === 'light' ? 'text-electric-300' : '' }}">
            <span class="h-px w-6 bg-current opacity-60"></span>
            {{ $eyebrow }}
        </span>
    @endif

    @if ($title)
        <{{ $as }} class="text-3xl font-bold leading-[1.08] sm:text-4xl lg:text-5xl {{ $titleColor }}">
            {{ $title }}
        </{{ $as }}>
    @endif

    @if (trim($slot))
        <p class="text-lg leading-relaxed {{ $bodyColor }}">{{ $slot }}</p>
    @endif
</div>
