@php
    $tones = ['navy', 'electric', 'mixed', 'sky'];
    $spanClass = ['wide' => 'sm:col-span-2', 'tall' => 'row-span-2', 'normal' => ''];
@endphp

<section id="impact" class="relative overflow-hidden bg-navy-50/60 py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <x-reveal>
            <x-section-header eyebrow="Our Impact" title="Where Awareness Becomes Change" class="mb-16">
                Behind every number is a classroom that grew kinder, a parent who learned to listen, a child who found the words. These are some of the moments along the way.
            </x-section-header>
        </x-reveal>

        {{-- Timeline --}}
        <div class="relative">
            @foreach ($stories as $i => $story)
                <x-reveal :delay="40">
                    <x-timeline-item :title="$story->title" :category="$story->category"
                        :location="$story->location" :period="$story->period"
                        :image="$story->image" :tone="$tones[$i % count($tones)]"
                        :last="$loop->last">
                        {{ $story->summary }}
                    </x-timeline-item>
                </x-reveal>
            @endforeach
        </div>

        {{-- Gallery --}}
        <div class="mt-12">
            <x-reveal>
                <h3 class="mb-6 flex items-center gap-3 text-lg font-bold text-navy-900">
                    <x-icon name="sparkles" class="h-5 w-5 text-electric-500" /> From the field
                </h3>
            </x-reveal>

            <div class="grid auto-rows-[160px] grid-cols-2 gap-4 sm:grid-cols-4 sm:auto-rows-[200px]">
                @foreach ($gallery as $i => $image)
                    <x-reveal :delay="($i % 4) * 70"
                        class="group relative overflow-hidden rounded-2xl {{ $spanClass[$image->span] ?? '' }}">
                        <x-media :src="$image->image" :alt="$image->title" :tone="$tones[$i % count($tones)]"
                                 :icon="'globe'" rounded="rounded-2xl"
                                 class="transition-transform duration-700 ease-out group-hover:scale-105" />
                        <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-navy-950/70 via-transparent to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                        @if ($image->caption)
                            <p class="pointer-events-none absolute inset-x-0 bottom-0 translate-y-2 p-4 text-sm font-medium text-white opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100">
                                {{ $image->caption }}
                            </p>
                        @endif
                    </x-reveal>
                @endforeach
            </div>
        </div>
    </div>
</section>
