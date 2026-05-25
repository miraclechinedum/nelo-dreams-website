@php $tones = ['navy', 'electric', 'mixed', 'sky']; @endphp

<section id="programs" class="relative overflow-hidden bg-white py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <x-reveal>
            <div class="flex flex-col gap-6 md:flex-row md:items-end md:justify-between">
                <x-section-header eyebrow="What We Deliver" title="Programs Built Around Real Childhoods">
                    Practical, age-appropriate programs that turn mental health awareness into everyday skills — in schools, communities, and on the pitch.
                </x-section-header>
                <x-button href="#contact" variant="ghost" icon="arrow-right" class="shrink-0">Bring a program to your school</x-button>
            </div>
        </x-reveal>

        <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($programs as $i => $program)
                <x-reveal :delay="($i % 3) * 100" class="h-full">
                    <x-program-card :title="$program->title" :summary="$program->summary"
                                    :category="$program->category" :icon="$program->icon"
                                    :image="$program->image" :tone="$tones[$i % count($tones)]" class="h-full" />
                </x-reveal>
            @endforeach
        </div>
    </div>
</section>
