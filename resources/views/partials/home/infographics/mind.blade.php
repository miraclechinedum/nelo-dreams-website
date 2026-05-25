{{-- Mind-behind-behaviour node diagram --}}
<div class="flex flex-col items-center gap-4 text-center">
    <span class="rounded-full border border-navy-200 bg-navy-50 px-4 py-2 text-sm font-semibold text-navy-500">
        Visible behaviour
    </span>

    <span class="h-8 w-px bg-gradient-to-b from-navy-200 to-electric-400"></span>

    <div class="relative flex h-28 w-28 items-center justify-center rounded-full bg-navy-900 text-electric-300 shadow-lg shadow-navy-900/20">
        <span class="absolute inset-0 animate-ping rounded-full bg-electric-500/10"></span>
        <x-icon name="brain" :stroke="1.4" class="h-12 w-12" />
    </div>
    <p class="text-sm font-bold uppercase tracking-wider text-navy-900">The mind</p>

    <div class="mt-1 flex flex-wrap justify-center gap-2">
        @foreach (['Thoughts', 'Feelings', 'Needs'] as $chip)
            <span class="rounded-full bg-electric-50 px-3 py-1.5 text-xs font-semibold text-electric-700">{{ $chip }}</span>
        @endforeach
    </div>
    <p class="mt-1 text-sm text-navy-500">We start here — then behaviour follows.</p>
</div>
