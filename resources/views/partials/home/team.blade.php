@if ($team->isNotEmpty())
    <section id="team" class="relative overflow-hidden bg-navy-50/60 py-24 lg:py-32">
        {{-- ambient glow --}}
        <div class="pointer-events-none absolute -left-24 top-24 h-72 w-72 rounded-full bg-electric-400/10 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-5 sm:px-8">
            <x-reveal>
                <x-section-header align="center" eyebrow="Our Team" title="The People Behind the Work" class="mb-16">
                    A small team of coaches, field officers and programme staff who show up in schools and
                    communities across Nigeria — every week, for every child.
                </x-section-header>
            </x-reveal>

            {{-- Flex rather than grid so an incomplete last row stays centred. --}}
            <div class="flex flex-wrap justify-center gap-6">
                @foreach ($team as $i => $member)
                    <x-reveal :delay="($i % 3) * 100"
                              class="w-full sm:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)]">
                        <x-team-member :member="$member" class="h-full" />
                    </x-reveal>
                @endforeach
            </div>

            <x-reveal :delay="150">
                <p class="mt-12 text-center text-[15px] text-navy-500">
                    Want to work alongside them?
                    <a href="#contact" class="font-semibold text-electric-600 underline-offset-4 hover:underline">Volunteer with us →</a>
                </p>
            </x-reveal>
        </div>
    </section>
@endif
