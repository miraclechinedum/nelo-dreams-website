@php
    $blocks = [
        [
            'icon' => 'brain',
            'title' => 'We Train the Mind Behind the Behaviour',
            'body' => 'Behaviour is the surface. We work underneath it — helping children understand the thoughts and feelings that drive how they act, so change comes from understanding, not punishment.',
        ],
        [
            'icon' => 'shield-check',
            'title' => 'Skill Over Shame',
            'body' => 'We replace shame with skill. Instead of telling children what’s wrong with them, we teach them what to do — naming emotions, calming the body, and asking for help with confidence.',
        ],
        [
            'icon' => 'chart',
            'title' => 'Evidence-Based Development',
            'body' => 'Every program is grounded in social-emotional learning research and adapted to local culture and language — rigorous in design, warm in delivery.',
        ],
        [
            'icon' => 'check-circle',
            'title' => 'Measurable Impact',
            'body' => 'We track what matters — reach, engagement, and growth across terms — so partners can see exactly how awareness turns into lasting change.',
        ],
    ];
@endphp

<section id="approach" class="relative overflow-hidden bg-white py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <x-reveal>
            <x-section-header align="center" eyebrow="Why Our Approach Works"
                title="Designed by How Children Actually Learn" class="mb-20">
                Four principles separate a one-off awareness talk from real, durable change.
            </x-section-header>
        </x-reveal>

        <div class="flex flex-col gap-20 lg:gap-28">
            @foreach ($blocks as $i => $block)
                <div class="grid items-center gap-10 lg:grid-cols-2 lg:gap-16">
                    {{-- Copy --}}
                    <x-reveal @class(['lg:order-2' => $i % 2 === 1])>
                        <div class="flex flex-col gap-5">
                            <span class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-navy-900 text-electric-300">
                                <x-icon :name="$block['icon']" class="h-7 w-7" />
                            </span>
                            <span class="font-display text-sm font-bold uppercase tracking-[0.18em] text-electric-600">
                                {{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}
                            </span>
                            <h3 class="text-2xl font-bold leading-tight text-navy-900 sm:text-3xl">{{ $block['title'] }}</h3>
                            <p class="max-w-lg text-lg leading-relaxed text-navy-600">{{ $block['body'] }}</p>
                        </div>
                    </x-reveal>

                    {{-- Infographic --}}
                    <x-reveal :delay="120" @class(['lg:order-1' => $i % 2 === 1])>
                        <div class="surface relative overflow-hidden p-8 sm:p-10">
                            <div class="pointer-events-none absolute -right-10 -top-10 h-40 w-40 rounded-full bg-electric-100/50 blur-2xl"></div>
                            <div class="relative">
                                @switch($i)
                                    @case(0) @include('partials.home.infographics.mind') @break
                                    @case(1) @include('partials.home.infographics.skill') @break
                                    @case(2) @include('partials.home.infographics.evidence') @break
                                    @default @include('partials.home.infographics.measurable')
                                @endswitch
                            </div>
                        </div>
                    </x-reveal>
                </div>
            @endforeach
        </div>
    </div>
</section>
