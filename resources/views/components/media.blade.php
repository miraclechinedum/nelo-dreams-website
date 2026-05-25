@props([
    'src' => null,
    'alt' => '',
    'tone' => 'navy',         // navy | electric | sky | mixed
    'label' => null,          // small caption shown on the placeholder
    'icon' => 'sparkles',     // watermark icon on the placeholder
    'rounded' => 'rounded-3xl',
])

@php
    $exists = $src && file_exists(public_path($src));

    $tones = [
        'navy' => 'from-navy-950 via-navy-900 to-electric-800',
        'electric' => 'from-electric-700 via-electric-500 to-electric-300',
        'sky' => 'from-electric-500 via-electric-300 to-navy-100',
        'mixed' => 'from-navy-900 via-electric-700 to-electric-400',
    ];
    $grad = $tones[$tone] ?? $tones['navy'];
@endphp

@if ($exists)
    <img src="{{ asset($src) }}" alt="{{ $alt }}" loading="lazy" decoding="async"
         {{ $attributes->merge(['class' => "block h-full w-full object-cover {$rounded}"]) }} />
@else
    <div role="img" aria-label="{{ $alt ?: $label }}"
         {{ $attributes->merge(['class' => "relative isolate flex h-full w-full overflow-hidden bg-gradient-to-br {$grad} {$rounded}"]) }}>
        {{-- soft light blooms --}}
        <div class="pointer-events-none absolute -right-10 -top-10 h-44 w-44 rounded-full bg-white/15 blur-2xl"></div>
        <div class="pointer-events-none absolute -bottom-12 -left-8 h-52 w-52 rounded-full bg-electric-300/20 blur-3xl"></div>
        {{-- dot grid texture --}}
        <div class="pointer-events-none absolute inset-0 opacity-[0.18]"
             style="background-image: radial-gradient(currentColor 1px, transparent 1.4px); background-size: 22px 22px; color: white;"></div>
        {{-- watermark icon --}}
        <x-icon :name="$icon" :stroke="1.2" class="pointer-events-none absolute -bottom-6 -right-4 h-40 w-40 text-white/10" />
        @if ($label)
            <div class="relative z-10 mt-auto p-5">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/15 px-3 py-1 text-xs font-medium text-white backdrop-blur">
                    {{ $label }}
                </span>
            </div>
        @endif
    </div>
@endif
