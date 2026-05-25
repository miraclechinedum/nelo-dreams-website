@php
    $rangersName = $rangers->name ?? 'Rangers International FC Foundation';
    $rangersTagline = $rangers->tagline ?? 'Building Champions on the Pitch and in the Mind';
    $rangersWebsite = $rangers->website ?? null;

    $partnershipCards = [
        ['icon' => 'brain', 'title' => 'Mental Clarity & SEL Programs', 'body' => 'Guided sessions that build focus, emotional regulation, and self-belief — the mental game behind every great player.'],
        ['icon' => 'trophy', 'title' => 'Football for Development', 'body' => 'Structured coaching that channels energy into discipline, teamwork, and resilience that lasts far beyond the pitch.'],
        ['icon' => 'megaphone', 'title' => 'Community Outreach & Advocacy', 'body' => 'Joint campaigns that carry mental health conversations into stadiums, schools, and streets across the region.'],
    ];
@endphp

<section id="partnership" class="relative overflow-hidden bg-white py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <x-reveal>
            <div class="relative overflow-hidden rounded-[2.5rem] bg-gradient-to-br from-navy-950 via-navy-900 to-navy-950 p-8 text-white shadow-2xl shadow-navy-950/30 sm:p-12 lg:p-16">
                {{-- Rangers-red accent glow --}}
                <div class="pointer-events-none absolute -right-20 -top-20 h-72 w-72 rounded-full bg-[#D11F26]/25 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-24 left-1/3 h-72 w-72 rounded-full bg-electric-600/20 blur-3xl"></div>

                <div class="relative grid gap-12 lg:grid-cols-12 lg:items-center">
                    {{-- Left — Rangers logo --}}
                    <div class="lg:col-span-5">
                        <div class="flex flex-col items-start gap-6 rounded-3xl border border-white/10 bg-white/[0.04] p-8 backdrop-blur-sm">
                            <span class="inline-flex items-center gap-2 rounded-full bg-[#D11F26] px-3.5 py-1 text-xs font-semibold uppercase tracking-wider text-white">
                                Strategic Partner
                            </span>
                            <div class="h-36 w-36 overflow-hidden rounded-3xl bg-white p-3 shadow-xl">
                                <x-logo.rangers />
                            </div>
                            <div>
                                <h3 class="font-display text-2xl font-extrabold leading-tight">{{ $rangersName }}</h3>
                                <p class="mt-2 text-electric-100/80">“{{ $rangersTagline }}”</p>
                            </div>
                            @if ($rangersWebsite)
                                <a href="{{ $rangersWebsite }}" target="_blank" rel="noopener"
                                   class="group inline-flex items-center gap-2 text-sm font-semibold text-electric-300 hover:text-white">
                                    Visit the foundation <x-icon name="arrow-up-right" class="h-4 w-4" />
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Right — story --}}
                    <div class="lg:col-span-7">
                        <span class="eyebrow text-electric-300">
                            <span class="h-px w-6 bg-current opacity-60"></span>
                            The Partnership
                        </span>
                        <h2 class="mt-4 font-display text-3xl font-extrabold leading-[1.1] sm:text-4xl lg:text-5xl">
                            Football Builds More Than Players
                        </h2>
                        <p class="mt-5 max-w-xl text-lg leading-relaxed text-electric-100/80">
                            Nelo Dreams Foundation partners with Rangers International FC Foundation to combine mental health education, social-emotional learning, and football-based youth development — proving that the right coaching shapes character as much as it shapes athletes.
                        </p>

                        <div class="mt-8 grid gap-4 sm:grid-cols-3">
                            @foreach ($partnershipCards as $i => $card)
                                <x-reveal :delay="$i * 90" class="h-full">
                                    <x-card :icon="$card['icon']" :title="$card['title']" tone="dark" class="h-full">
                                        {{ $card['body'] }}
                                    </x-card>
                                </x-reveal>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </x-reveal>

        {{-- Partners & collaborators --}}
        @if (($partners ?? collect())->isNotEmpty())
            <div class="mt-16 lg:mt-20">
                <x-reveal>
                    <x-section-header align="center" eyebrow="Beyond the Pitch"
                        title="Partners & Collaborators" class="mb-12">
                        We work alongside organisations who share our belief that every child deserves the tools to understand their mind.
                    </x-section-header>
                </x-reveal>

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($partners as $i => $partner)
                        <x-reveal :delay="($i % 3) * 90" class="h-full">
                            <x-partner-card :name="$partner->name" :tagline="$partner->tagline"
                                :description="$partner->description" :logo="$partner->logo"
                                :website="$partner->website" class="h-full" />
                        </x-reveal>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
