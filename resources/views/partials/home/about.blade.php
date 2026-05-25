<section id="about" class="relative overflow-hidden bg-white py-24 lg:py-32">
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-5 sm:px-8 lg:grid-cols-2 lg:gap-16">
        {{-- Visual --}}
        <x-reveal variant="image" class="relative order-last lg:order-first">
            <div class="relative aspect-[4/5] overflow-hidden rounded-[2rem] sm:aspect-square lg:aspect-[4/5]">
                <x-media src="images/about.jpg" tone="mixed" icon="heart"
                         alt="Children participating in a Nelo Dreams mental health awareness activity"
                         rounded="rounded-[2rem]" />
            </div>

            {{-- Floating badge --}}
            <div class="absolute -bottom-6 -right-3 flex items-center gap-3 rounded-2xl bg-white p-4 shadow-[0_20px_50px_-15px_rgba(2,27,78,0.35)] sm:-right-6">
                <span class="h-12 w-12 shrink-0"><x-logo.nelo /></span>
                <div class="pr-2">
                    <p class="font-display text-sm font-bold text-navy-900">Glad You Were Born</p>
                    <p class="text-xs text-navy-500">Every child. Every mind.</p>
                </div>
            </div>
        </x-reveal>

        {{-- Copy --}}
        <div class="flex flex-col gap-7">
            <x-reveal>
                <x-section-header eyebrow="Who We Are"
                    title="Every Child Should Know Their Mind Matters">
                    We believe mental health is not a luxury — it is a childhood right. From the classroom to the community, we make emotional skills and mental health awareness something every child can understand, practise, and carry for life.
                </x-section-header>
            </x-reveal>

            <div class="grid gap-5 sm:grid-cols-2">
                <x-reveal :delay="80">
                    <x-card icon="compass" title="Our Mission" class="h-full">
                        To equip every child with mental health knowledge and emotional skills through awareness programs, so they grow up resilient, confident, and able to support others.
                    </x-card>
                </x-reveal>
                <x-reveal :delay="160">
                    <x-card icon="globe" title="Our Vision" class="h-full">
                        To be Africa’s leading voice for child mental health awareness — where no child grows up ashamed of their struggles or ignorant of their mind.
                    </x-card>
                </x-reveal>
            </div>

            <x-reveal :delay="220">
                <div class="flex flex-wrap items-center gap-x-8 gap-y-3 rounded-2xl bg-navy-50 px-6 py-5">
                    <p class="text-sm font-semibold text-navy-700">Rooted in dignity, evidence, and joy.</p>
                    <a href="#objectives" class="group inline-flex items-center gap-2 text-sm font-semibold text-electric-600">
                        See our objectives
                        <x-icon name="arrow-right" class="h-4 w-4 transition-transform group-hover:translate-x-1" />
                    </a>
                </div>
            </x-reveal>
        </div>
    </div>
</section>
