@if ($posts->isNotEmpty())
    <section id="updates" class="bg-white py-24 lg:py-32">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            <x-reveal>
                <div class="mb-14 flex flex-wrap items-end justify-between gap-6">
                    <x-section-header eyebrow="Latest Updates" title="Straight From the Field" class="mb-0">
                        The most recent outreaches, school visits and events — written up by the team, with the photos and videos from each day.
                    </x-section-header>

                    <x-button :href="route('updates.index')" variant="ghost" size="sm">All updates</x-button>
                </div>
            </x-reveal>

            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    <x-reveal :delay="$loop->index * 80" class="h-full">
                        <article class="surface group flex h-full flex-col overflow-hidden transition-all duration-500 hover:-translate-y-1">
                            <a href="{{ route('updates.show', $post) }}" class="relative block aspect-[16/10] overflow-hidden bg-navy-100">
                                <x-media :src="$post->coverPath()" :alt="$post->title" rounded="rounded-none" icon="megaphone"
                                         class="transition-transform duration-700 ease-out group-hover:scale-105" />
                                @if ($post->media->contains(fn ($m) => $m->isVideo()))
                                    <span class="absolute left-4 top-4 inline-flex items-center gap-1.5 rounded-full bg-navy-950/70 px-3 py-1 text-xs font-semibold text-white backdrop-blur">
                                        <x-icon name="play" class="h-3.5 w-3.5" /> Video
                                    </span>
                                @endif
                            </a>

                            <div class="flex flex-1 flex-col gap-3 p-6">
                                <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-semibold uppercase tracking-wide">
                                    @if ($post->category)<span class="text-electric-600">{{ $post->category }}</span>@endif
                                    @if ($post->dateLabel())<span class="text-navy-400">· {{ $post->dateLabel() }}</span>@endif
                                </div>

                                <h3 class="text-lg font-bold leading-snug text-navy-900">
                                    <a href="{{ route('updates.show', $post) }}" class="transition-colors hover:text-electric-600">{{ $post->title }}</a>
                                </h3>

                                <p class="text-[15px] leading-relaxed text-navy-600">{{ Str::limit($post->summary, 150) }}</p>

                                <a href="{{ route('updates.show', $post) }}"
                                   class="mt-auto inline-flex items-center gap-2 pt-2 text-sm font-semibold text-electric-600 transition-colors hover:text-electric-700">
                                    Read more
                                    <x-icon name="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
                                </a>
                            </div>
                        </article>
                    </x-reveal>
                @endforeach
            </div>
        </div>
    </section>
@endif
