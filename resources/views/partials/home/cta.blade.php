<section class="relative overflow-hidden bg-navy-950 py-24 text-white lg:py-36">
    {{-- background treatment --}}
    @if (file_exists(public_path('images/cta.jpg')))
        <img src="{{ asset('images/cta.jpg') }}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-30" />
    @endif
    <div class="absolute inset-0 bg-[radial-gradient(70%_60%_at_50%_0%,rgba(14,165,233,0.3),transparent)]"></div>
    <div class="pointer-events-none absolute inset-0 opacity-[0.08]"
         style="background-image: radial-gradient(#fff 1px, transparent 1.4px); background-size: 26px 26px;"></div>

    <div class="relative mx-auto max-w-4xl px-5 text-center sm:px-8">
        <x-reveal>
            <span class="eyebrow justify-center text-electric-300">
                <span class="h-px w-6 bg-current opacity-60"></span>
                Join the movement
                <span class="h-px w-6 bg-current opacity-60"></span>
            </span>
            <h2 class="mx-auto mt-6 max-w-3xl font-display text-4xl font-extrabold leading-[1.08] sm:text-5xl lg:text-6xl">
                Help Build a Generation That Understands Its Mind
            </h2>
            <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-electric-100/80">
                Every partnership, every gift, and every volunteer hour reaches a child with the knowledge and confidence to thrive. Stand with us.
            </p>
        </x-reveal>

        <x-reveal :delay="120">
            <div class="mt-10 flex flex-col items-center justify-center gap-3 sm:flex-row">
                <x-button href="#partnership" variant="primary" size="lg" icon="arrow-right">Become a Partner</x-button>
                <x-button href="#contact" variant="white" size="lg" icon="heart">Donate</x-button>
                <x-button href="#contact" variant="ghost-light" size="lg" icon="hand-raised">Volunteer</x-button>
            </div>
        </x-reveal>

        <x-reveal :delay="200">
            <p class="mt-10 font-display text-xl font-bold text-white/90">“Glad You Were Born”</p>
        </x-reveal>
    </div>
</section>
