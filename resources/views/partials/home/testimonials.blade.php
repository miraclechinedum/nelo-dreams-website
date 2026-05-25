<section class="relative bg-white py-24 lg:py-32">
    <div class="mx-auto max-w-7xl px-5 sm:px-8">
        <x-reveal>
            <x-section-header align="center" eyebrow="Voices" title="What Our Communities Say" class="mb-16">
                Teachers, parents, and coaches describe what changes when children are given the language and tools to understand their minds.
            </x-section-header>
        </x-reveal>

        <div class="grid gap-6 lg:grid-cols-3">
            @foreach ($testimonials as $i => $testimonial)
                <x-reveal :delay="$i * 100" class="h-full">
                    <x-testimonial :name="$testimonial->name" :role="$testimonial->role"
                        :organization="$testimonial->organization" :quote="$testimonial->quote" class="h-full" />
                </x-reveal>
            @endforeach
        </div>
    </div>
</section>
