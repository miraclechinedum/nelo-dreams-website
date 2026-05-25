{{-- Shame → Skill comparison bars (animate via parent .reveal.is-shown) --}}
<div class="flex flex-col gap-7">
    <div>
        <div class="mb-2 flex items-center justify-between text-sm">
            <span class="font-semibold text-navy-400">Shame-based correction</span>
            <span class="font-bold text-navy-400">Low growth</span>
        </div>
        <div class="h-3 w-full overflow-hidden rounded-full bg-navy-100">
            <div class="viz-bar h-full rounded-full bg-navy-300" style="--w: 22%"></div>
        </div>
    </div>

    <div class="flex items-center justify-center gap-2 text-electric-600">
        <span class="h-px w-8 bg-electric-300"></span>
        <span class="text-xs font-bold uppercase tracking-wider">We choose skill</span>
        <x-icon name="arrow-right" class="h-4 w-4" />
    </div>

    <div>
        <div class="mb-2 flex items-center justify-between text-sm">
            <span class="font-semibold text-navy-900">Skill-based teaching</span>
            <span class="font-bold text-electric-600">High growth</span>
        </div>
        <div class="h-3 w-full overflow-hidden rounded-full bg-navy-100">
            <div class="viz-bar h-full rounded-full bg-gradient-to-r from-electric-500 to-electric-400"
                 style="--w: 92%; transition-delay: 0.2s"></div>
        </div>
    </div>
</div>
