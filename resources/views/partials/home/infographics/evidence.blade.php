{{-- Evidence-based completion ring + pillars (animate via parent .reveal.is-shown) --}}
<div class="flex flex-col items-center gap-6 sm:flex-row sm:items-center sm:gap-8">
    <div class="relative h-36 w-36 shrink-0">
        <svg viewBox="0 0 120 120" class="h-full w-full -rotate-90">
            <circle cx="60" cy="60" r="52" fill="none" stroke="#d6e1f4" stroke-width="12" />
            <circle cx="60" cy="60" r="52" fill="none" stroke="#0EA5E9" stroke-width="12" stroke-linecap="round"
                    stroke-dasharray="326.7" class="viz-ring" />
        </svg>
        <div class="absolute inset-0 flex flex-col items-center justify-center">
            <x-icon name="shield-check" class="h-7 w-7 text-electric-600" />
            <span class="mt-1 text-xs font-bold uppercase tracking-wide text-navy-500">SEL-rooted</span>
        </div>
    </div>

    <ul class="flex flex-col gap-3">
        @foreach (['Grounded in SEL research', 'Age-appropriate by design', 'Adapted to local culture'] as $item)
            <li class="flex items-center gap-3 text-sm font-medium text-navy-700">
                <span class="inline-flex h-6 w-6 items-center justify-center rounded-full bg-electric-50 text-electric-600">
                    <x-icon name="check" class="h-4 w-4" />
                </span>
                {{ $item }}
            </li>
        @endforeach
    </ul>
</div>
