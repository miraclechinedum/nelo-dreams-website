@props([
    'delay' => 0,        // ms
    'variant' => 'up',   // up | image
    'as' => 'div',
])

@php
    $cls = $variant === 'image' ? 'img-reveal' : 'reveal';
@endphp

{{-- Reveal class is driven by the global IntersectionObserver in app.js --}}
<{{ $as }}
    @style(["transition-delay: {$delay}ms" => $delay])
    {{ $attributes->merge(['class' => $cls]) }}
>{{ $slot }}</{{ $as }}>
