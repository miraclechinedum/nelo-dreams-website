@props(['member'])

@php
    $links = array_filter([
        ['icon' => 'envelope', 'href' => $member->email ? 'mailto:'.$member->email : null, 'label' => 'Email '.$member->name],
        ['icon' => 'phone', 'href' => $member->phone ? 'tel:'.preg_replace('/[^\d+]/', '', $member->phone) : null, 'label' => 'Call '.$member->name],
        ['icon' => 'facebook', 'href' => $member->facebook_url, 'label' => $member->name.' on Facebook'],
        ['icon' => 'linkedin', 'href' => $member->linkedin_url, 'label' => $member->name.' on LinkedIn'],
    ], fn ($link) => (bool) $link['href']);
@endphp

<figure {{ $attributes->merge(['class' => 'surface group flex h-full flex-col overflow-hidden transition-all duration-500 hover:-translate-y-1']) }}>
    <div class="relative aspect-[4/5] overflow-hidden bg-navy-900">
        @if ($member->hasPhoto())
            <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" loading="lazy" decoding="async"
                 class="h-full w-full object-cover object-top transition-transform duration-700 group-hover:scale-105" />
        @else
            {{-- No headshot on file yet — initials on the brand gradient. --}}
            <div role="img" aria-label="{{ $member->name }}"
                 class="flex h-full w-full items-center justify-center bg-gradient-to-br from-navy-950 via-navy-900 to-electric-800">
                <span class="font-display text-5xl font-extrabold tracking-tight text-electric-300">{{ $member->initials() }}</span>
            </div>
        @endif

        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-24 bg-gradient-to-t from-navy-950/70 to-transparent"></div>
    </div>

    <figcaption class="flex flex-1 flex-col gap-3 p-6">
        <div>
            <h3 class="text-lg font-bold leading-snug text-navy-900">{{ $member->name }}</h3>
            <p class="mt-1 text-sm font-semibold text-electric-600">{{ $member->role }}</p>
        </div>

        @if ($member->bio)
            <p class="text-[15px] leading-relaxed text-navy-600">{{ $member->bio }}</p>
        @endif

        @if ($links)
            <div class="mt-auto flex items-center gap-2 pt-2">
                @foreach ($links as $link)
                    <a href="{{ $link['href'] }}" aria-label="{{ $link['label'] }}"
                       @if (Str::startsWith($link['href'], 'http')) target="_blank" rel="noopener" @endif
                       class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-navy-50 text-navy-600 transition-colors hover:bg-electric-500 hover:text-white">
                        <x-icon :name="$link['icon']" class="h-4 w-4" />
                    </a>
                @endforeach
            </div>
        @endif
    </figcaption>
</figure>
