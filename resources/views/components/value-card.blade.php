@props([
    'letter' => '',
    'title',
])

<article {{ $attributes->merge(['class' => 'group relative flex h-full flex-col gap-4 overflow-hidden rounded-3xl border border-white/10 bg-white/[0.04] p-7 backdrop-blur-sm transition-all duration-500 hover:border-electric-400/40 hover:bg-white/[0.07]']) }}>
    <div class="flex items-center gap-4">
        <span class="font-display text-5xl font-black leading-none text-electric-400">{{ $letter }}</span>
        <span class="h-px flex-1 bg-white/10"></span>
    </div>
    <h3 class="text-xl font-bold text-white">{{ $title }}</h3>
    <p class="text-[15px] leading-relaxed text-electric-100/70">{{ $slot }}</p>
</article>
