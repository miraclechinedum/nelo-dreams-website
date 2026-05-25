<section id="objectives" class="relative bg-navy-50/60 py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <x-reveal>
            <x-section-header align="center" eyebrow="Our Objectives"
                title="Three Commitments That Shape Everything We Do" class="mb-16">
                Each program we run advances one of three objectives — clear, measurable, and built around the child.
            </x-section-header>
        </x-reveal>

        <div class="grid gap-6 lg:grid-cols-3">
            @foreach ($objectives as $i => $objective)
                <x-reveal :delay="$i * 100" class="h-full">
                    <x-objective-card :number="str_pad($i + 1, 2, '0', STR_PAD_LEFT)"
                                      :title="$objective->title" :icon="$objective->icon" class="h-full">
                        {{ $objective->description }}
                    </x-objective-card>
                </x-reveal>
            @endforeach
        </div>
    </div>
</section>
