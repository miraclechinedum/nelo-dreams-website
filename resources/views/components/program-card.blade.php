@props([
    'title',
    'summary' => '',
    'category' => null,
    'icon' => 'sparkles',
    'image' => null,
    'tone' => 'navy',
])

<article {{ $attributes->merge(['class' => 'group surface flex h-full flex-col overflow-hidden transition-all duration-500 hover:-translate-y-1.5 hover:shadow-[0_24px_60px_-20px_rgba(2,27,78,0.28)]']) }}>
    <div class="relative aspect-[16/10] overflow-hidden">
        <x-media :src="$image" :alt="$title" :tone="$tone" :icon="$icon" rounded="rounded-none"
                 class="transition-transform duration-700 ease-out group-hover:scale-[1.04]" />
        <span class="absolute left-4 top-4 inline-flex h-11 w-11 items-center justify-center rounded-2xl bg-white/90 text-navy-900 shadow-sm backdrop-blur">
            <x-icon :name="$icon" class="h-5 w-5" />
        </span>
    </div>

    <div class="flex flex-1 flex-col gap-3 p-6">
        @if ($category)
            <span class="text-xs font-semibold uppercase tracking-[0.14em] text-electric-600">{{ $category }}</span>
        @endif
        <h3 class="text-xl font-bold leading-snug text-navy-900">{{ $title }}</h3>
        <p class="text-[15px] leading-relaxed text-navy-600">{{ $summary }}</p>

        <div class="mt-auto flex items-center gap-2 pt-3 text-sm font-semibold text-electric-600">
            <span>Learn more</span>
            <x-icon name="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
        </div>
    </div>
</article>
