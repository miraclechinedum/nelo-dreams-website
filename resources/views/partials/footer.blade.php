@php
    $footerCols = [
        'Foundation' => [
            ['label' => 'About Us', 'href' => '#about'],
            ['label' => 'Our Objectives', 'href' => '#objectives'],
            ['label' => 'Core Values', 'href' => '#values'],
            ['label' => 'Our Impact', 'href' => '#impact'],
        ],
        'Our Work' => [
            ['label' => 'Programs', 'href' => '#programs'],
            ['label' => 'Rangers Partnership', 'href' => '#partnership'],
            ['label' => 'Our Approach', 'href' => '#approach'],
        ],
        'Get Involved' => [
            ['label' => 'Become a Partner', 'href' => '#contact'],
            ['label' => 'Donate', 'href' => '#contact'],
            ['label' => 'Volunteer', 'href' => '#contact'],
            ['label' => 'Contact', 'href' => '#contact'],
        ],
    ];
    $socials = [
        ['name' => 'facebook', 'href' => '#', 'label' => 'Facebook'],
        ['name' => 'instagram', 'href' => '#', 'label' => 'Instagram'],
        ['name' => 'x-social', 'href' => '#', 'label' => 'X'],
        ['name' => 'linkedin', 'href' => '#', 'label' => 'LinkedIn'],
        ['name' => 'youtube', 'href' => '#', 'label' => 'YouTube'],
    ];
@endphp

<footer class="relative overflow-hidden bg-navy-950 text-white">
    {{-- ambient glow --}}
    <div class="pointer-events-none absolute -top-24 right-0 h-72 w-72 rounded-full bg-electric-600/20 blur-3xl"></div>

    <div class="relative mx-auto max-w-7xl px-5 sm:px-8">
        {{-- top --}}
        <div class="grid gap-12 py-16 lg:grid-cols-[1.4fr_2fr] lg:py-20">
            <div class="max-w-sm">
                <a href="#top" class="flex items-center gap-3" aria-label="Nelo Dreams Foundation — home">
                    <span class="h-12 w-12"><x-logo.nelo /></span>
                    <span class="flex flex-col leading-tight">
                        <span class="font-display text-lg font-extrabold">Nelo Dreams</span>
                        <span class="text-[11px] font-medium uppercase tracking-[0.16em] text-electric-300">Foundation Int’l</span>
                    </span>
                </a>
                <p class="mt-6 text-[15px] leading-relaxed text-electric-100/70">
                    Equipping every child with mental health knowledge, emotional skills, and the confidence to thrive — at school, at home, and in life.
                </p>
                <p class="mt-6 font-display text-xl font-bold text-white">“Glad You Were Born”</p>

                <div class="mt-7 flex items-center gap-3">
                    @foreach ($socials as $social)
                        <a href="{{ $social['href'] }}" aria-label="{{ $social['label'] }}"
                           class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 text-white transition-colors hover:bg-electric-500">
                            <x-icon :name="$social['name']" class="h-5 w-5" />
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="grid grid-cols-2 gap-8 sm:grid-cols-3">
                @foreach ($footerCols as $heading => $links)
                    <nav aria-label="{{ $heading }}">
                        <h3 class="text-sm font-semibold uppercase tracking-wider text-electric-300">{{ $heading }}</h3>
                        <ul class="mt-4 space-y-3">
                            @foreach ($links as $link)
                                <li>
                                    <a href="{{ $link['href'] }}" class="text-[15px] text-electric-100/70 transition-colors hover:text-white">{{ $link['label'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                @endforeach
            </div>
        </div>

        {{-- contact strip --}}
        <div class="grid gap-4 border-t border-white/10 py-8 sm:grid-cols-2">
            <a href="mailto:rangersintlfcfoundation@gmail.com" class="group inline-flex items-center gap-3 text-electric-100/80 transition-colors hover:text-white">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10 group-hover:bg-electric-500"><x-icon name="envelope" class="h-5 w-5" /></span>
                rangersintlfcfoundation@gmail.com
            </a>
            <div class="inline-flex items-center gap-3 text-electric-100/80 sm:justify-end">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-white/10"><x-icon name="map-pin" class="h-5 w-5" /></span>
                Enugu, Nigeria
            </div>
        </div>

        {{-- bottom --}}
        <div class="flex flex-col gap-4 border-t border-white/10 py-7 text-sm text-electric-100/60 sm:flex-row sm:items-center sm:justify-between">
            <p>© 2018–{{ date('Y') }} Nelo Dreams Foundation International. All rights reserved.</p>
            <p class="flex items-center gap-2">
                In strategic partnership with
                <span class="font-semibold text-white">Rangers Int’l FC Foundation</span>
            </p>
        </div>

        {{-- designer credit --}}
        <div class="border-t border-white/5 py-5 text-center text-xs text-electric-100/40">
            This website was designed by
            <a href="https://dti.technology" target="_blank" rel="noopener"
               class="font-medium text-electric-200/70 underline-offset-2 transition-colors hover:text-white hover:underline">
                Diamond Tech Innovations
            </a>
        </div>
    </div>
</footer>
