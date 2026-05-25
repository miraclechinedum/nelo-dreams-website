{{-- Measurable impact — growth bar chart (animate via parent .reveal.is-shown) --}}
@php $bars = [['Term 1', 35], ['Term 2', 58], ['Term 3', 76], ['Term 4', 95]]; @endphp
<div class="flex flex-col gap-5">
    <div class="flex items-end justify-between gap-3 sm:gap-4" style="height: 180px">
        @foreach ($bars as $b => $bar)
            <div class="flex h-full flex-1 flex-col items-center justify-end gap-2">
                <span class="viz-label text-xs font-bold text-navy-900">{{ $bar[1] }}%</span>
                <div class="viz-col w-full overflow-hidden rounded-t-xl bg-gradient-to-t from-navy-900 to-electric-500"
                     style="--h: {{ $bar[1] }}%; transition-delay: {{ $b * 0.12 }}s"></div>
                <span class="text-[11px] font-medium text-navy-500">{{ $bar[0] }}</span>
            </div>
        @endforeach
    </div>
    <div class="flex items-center gap-2 border-t border-navy-100 pt-4 text-sm">
        <span class="inline-flex items-center gap-1.5 rounded-full bg-electric-50 px-3 py-1 font-bold text-electric-700">
            <x-icon name="arrow-up-right" class="h-4 w-4" /> Growth across terms
        </span>
        <span class="text-navy-500">Awareness → engagement → change</span>
    </div>
</div>
