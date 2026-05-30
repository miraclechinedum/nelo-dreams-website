@php
    $heroImage = file_exists(public_path('images/hero.jpg')) ? 'images/hero.jpg' : null;
@endphp

<section class="relative isolate flex min-h-screen items-center overflow-hidden bg-navy-950 pt-28 pb-16 sm:pt-32"
         x-data="{ y: 0 }" x-init="window.addEventListener('scroll', () => { if (window.scrollY < 900) y = window.scrollY }, { passive: true })">

    {{-- Parallax background layer (image → gradient) --}}
    <div class="absolute inset-0 -z-10 will-change-transform" :style="`transform: translateY(${y * 0.25}px) scale(1.08)`">
        @if ($heroImage)
            <img src="{{ asset($heroImage) }}" alt=""
                 loading="eager" fetchpriority="high" decoding="async"
                 class="h-full w-full object-cover" />
        @else
            <div class="h-full w-full bg-gradient-to-br from-navy-950 via-navy-900 to-electric-900"></div>
        @endif
    </div>

    {{-- Overlays for legibility — left-weighted so the photo stays visible on the right --}}
    <div class="absolute inset-0 -z-10 bg-gradient-to-r from-navy-950 via-navy-950/75 to-navy-950/25"></div>
    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-navy-950 via-transparent to-navy-950/40"></div>
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(55%_45%_at_85%_15%,rgba(14,165,233,0.22),transparent)]"></div>
    <div class="pointer-events-none absolute inset-0 -z-10 opacity-[0.08]"
         style="background-image: radial-gradient(#fff 1px, transparent 1.4px); background-size: 26px 26px;"></div>
    <div class="pointer-events-none absolute -left-24 top-1/3 -z-10 h-72 w-72 animate-float rounded-full bg-electric-500/20 blur-3xl"></div>

    <div class="mx-auto grid w-full max-w-7xl gap-14 px-5 sm:px-8 lg:grid-cols-12 lg:items-center">
        {{-- Copy --}}
        <div class="lg:col-span-7">
            <span class="reveal is-shown inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/5 px-4 py-1.5 text-xs font-semibold uppercase tracking-[0.16em] text-electric-200 backdrop-blur">
                <span class="h-1.5 w-1.5 rounded-full bg-electric-400"></span>
                Child Mental Health Awareness
            </span>

            <h1 class="mt-6 max-w-2xl font-display text-4xl font-extrabold leading-[1.05] text-white sm:text-5xl lg:text-6xl xl:text-7xl">
                Every Child Deserves
                <span class="relative whitespace-nowrap text-electric-400">Mental Health
                    <svg class="absolute -bottom-2 left-0 w-full" viewBox="0 0 300 12" fill="none" preserveAspectRatio="none" aria-hidden="true">
                        <path d="M2 9C70 3 230 3 298 9" stroke="#0EA5E9" stroke-width="3.5" stroke-linecap="round" />
                    </svg>
                </span>
                Knowledge
            </h1>

            <p class="mt-7 max-w-xl text-lg leading-relaxed text-electric-100/80 sm:text-xl">
                Nelo Dreams Foundation International equips children with emotional skills, mental health awareness, and the confidence to thrive — in school, at home, and in life.
            </p>

            <div class="mt-9 flex flex-col gap-3 sm:flex-row sm:items-center">
                <x-button href="#partnership" variant="primary" size="lg" icon="arrow-right">Partner With Us</x-button>
                <x-button href="#contact" variant="ghost-light" size="lg" icon="heart">Support Our Mission</x-button>
            </div>

            <p class="mt-8 flex items-center gap-3 text-sm text-electric-100/60">
                <span class="h-px w-8 bg-electric-300/50"></span>
                In strategic partnership with <span class="font-semibold text-white">Rangers Int’l FC Foundation</span>
            </p>
        </div>

        {{-- Stats card --}}
        <div class="lg:col-span-5">
            <x-reveal :delay="150" class="rounded-[2rem] border border-white/10 bg-white/[0.06] p-7 shadow-2xl shadow-navy-950/40 backdrop-blur-xl sm:p-9">
                <p class="text-sm font-semibold uppercase tracking-wider text-electric-300">Our Impact So Far</p>
                <div class="mt-6 grid grid-cols-2 gap-x-6 gap-y-8">
                    @foreach ($statistics as $stat)
                        <x-stat :value="$stat->value" :label="$stat->label" :suffix="$stat->suffix"
                                :prefix="$stat->prefix" :icon="$stat->icon" tone="light" />
                    @endforeach
                </div>
            </x-reveal>
        </div>
    </div>

    {{-- Scroll cue --}}
    <a href="#about" class="absolute bottom-6 left-1/2 hidden -translate-x-1/2 flex-col items-center gap-2 text-electric-200/70 transition-colors hover:text-white lg:flex" aria-label="Scroll to learn more">
        <span class="text-[11px] font-medium uppercase tracking-[0.2em]">Scroll</span>
        <span class="flex h-9 w-5 items-start justify-center rounded-full border border-electric-200/40 p-1">
            <span class="h-2 w-1 animate-bounce rounded-full bg-electric-300"></span>
        </span>
    </a>
</section>
