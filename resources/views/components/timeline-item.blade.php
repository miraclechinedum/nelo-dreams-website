@props([
    'title',
    'category' => null,
    'location' => null,
    'period' => null,
    'image' => null,
    'tone' => 'navy',
    'last' => false,
])

<div {{ $attributes->merge(['class' => 'relative grid gap-6 pb-12 pl-10 sm:grid-cols-2 sm:gap-10 sm:pl-14']) }}>
    {{-- rail + node --}}
    <span class="absolute left-[7px] top-2 z-10 h-3.5 w-3.5 rounded-full bg-electric-500 ring-4 ring-electric-100 sm:left-[15px]"></span>
    @unless ($last)
        <span class="absolute left-3 top-2 h-full w-px bg-navy-100 sm:left-5"></span>
    @endunless

    {{-- copy --}}
    <div class="flex flex-col gap-3">
        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-semibold uppercase tracking-wide">
            @if ($category)<span class="text-electric-600">{{ $category }}</span>@endif
            @if ($period)<span class="text-navy-400">· {{ $period }}</span>@endif
        </div>
        <h3 class="text-xl font-bold leading-snug text-navy-900">{{ $title }}</h3>
        @if ($location)
            <p class="inline-flex items-center gap-1.5 text-sm text-navy-500">
                <x-icon name="map-pin" class="h-4 w-4 text-electric-500" />{{ $location }}
            </p>
        @endif
        <p class="text-[15px] leading-relaxed text-navy-600">{{ $slot }}</p>
    </div>

    {{-- image --}}
    <div class="order-first aspect-[16/10] overflow-hidden rounded-2xl sm:order-none">
        <x-media :src="$image" :alt="$title" :tone="$tone" />
    </div>
</div>
