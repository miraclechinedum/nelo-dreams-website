<section id="values" class="relative overflow-hidden bg-navy-950 py-24 text-white lg:py-32">
    {{-- ambient texture --}}
    <div class="absolute inset-0 bg-[radial-gradient(70%_60%_at_15%_0%,rgba(14,165,233,0.22),transparent)]"></div>
    <div class="pointer-events-none absolute inset-0 opacity-[0.08]"
         style="background-image: radial-gradient(#fff 1px, transparent 1.4px); background-size: 28px 28px;"></div>

    {{-- giant watermark acronym --}}
    <span aria-hidden="true"
          class="pointer-events-none absolute -top-6 right-4 select-none font-display text-[7rem] font-black leading-none text-white/[0.04] sm:text-[12rem] lg:text-[16rem]">
        AIDDT
    </span>

    <div class="relative mx-auto max-w-7xl px-5 sm:px-8">
        <x-reveal>
            <x-section-header tone="light" eyebrow="Core Values · AIDDT"
                title="The Principles We Refuse to Compromise" class="mb-14">
                Five values guide every decision, every program, and every relationship we hold with the children and communities we serve.
            </x-section-header>
        </x-reveal>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5">
            @foreach ($coreValues as $i => $value)
                <x-reveal :delay="$i * 80" class="h-full">
                    <x-value-card :letter="$value->letter" :title="$value->title" class="h-full">
                        {{ $value->description }}
                    </x-value-card>
                </x-reveal>
            @endforeach
        </div>
    </div>
</section>
