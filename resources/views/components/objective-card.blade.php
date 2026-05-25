@props([
    'number' => null,
    'title',
    'icon' => 'sparkles',
])

<article {{ $attributes->merge(['class' => 'group surface relative flex h-full flex-col gap-5 overflow-hidden p-8 transition-all duration-500 hover:-translate-y-1.5 hover:border-electric-200']) }}>
    {{-- accent wash on hover --}}
    <div class="pointer-events-none absolute inset-x-0 -top-24 h-40 bg-gradient-to-b from-electric-100/60 to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>

    <div class="relative flex items-center justify-between">
        <span class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-navy-900 text-electric-300 transition-colors duration-500 group-hover:bg-electric-500 group-hover:text-white">
            <x-icon :name="$icon" class="h-7 w-7" />
        </span>
        @if ($number)
            <span class="font-display text-5xl font-extrabold text-navy-100 transition-colors duration-500 group-hover:text-electric-100">{{ $number }}</span>
        @endif
    </div>

    <div class="relative flex flex-col gap-3">
        <h3 class="text-xl font-bold leading-snug text-navy-900">{{ $title }}</h3>
        <p class="text-[15px] leading-relaxed text-navy-600">{{ $slot }}</p>
    </div>
</article>
