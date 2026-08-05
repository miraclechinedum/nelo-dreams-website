@extends('layouts.app')

@section('title', $post->title.' | Nelo Dreams Foundation International')
@section('meta_description', Str::limit(strip_tags($post->summary), 155))

@section('content')
    @php
        $photos = $post->media->where('type', 'image');
        $videos = $post->media->where('type', 'video');
    @endphp

    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-950 pb-16 pt-36 text-white lg:pb-20 lg:pt-44">
        <div class="pointer-events-none absolute -top-28 right-0 h-96 w-96 rounded-full bg-electric-600/25 blur-3xl"></div>

        <div class="relative mx-auto max-w-4xl px-5 sm:px-8">
            <a href="{{ route('updates.index') }}"
               class="inline-flex items-center gap-2 text-sm font-semibold text-electric-300 transition-colors hover:text-white">
                <x-icon name="arrow-right" class="h-4 w-4 rotate-180" /> All updates
            </a>

            <div class="mt-6 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs font-semibold uppercase tracking-wide">
                @if ($post->category)<span class="text-electric-300">{{ $post->category }}</span>@endif
                @if ($post->dateLabel())<span class="text-electric-100/60">· {{ $post->dateLabel() }}</span>@endif
            </div>

            <h1 class="mt-4 text-3xl font-bold leading-[1.1] sm:text-4xl lg:text-5xl">{{ $post->title }}</h1>

            @if ($post->location)
                <p class="mt-5 inline-flex items-center gap-2 text-[15px] text-electric-100/80">
                    <x-icon name="map-pin" class="h-5 w-5 shrink-0 text-electric-400" />{{ $post->location }}
                </p>
            @endif
        </div>
    </section>

    {{-- Body --}}
    <article class="bg-white py-16 lg:py-20">
        <div class="mx-auto max-w-4xl px-5 sm:px-8">
            @if ($cover = $post->coverPath())
                <x-reveal variant="image" class="mb-12 block overflow-hidden rounded-3xl">
                    <div class="aspect-[16/9] w-full bg-navy-100">
                        <x-media :src="$cover" :alt="$post->title" rounded="rounded-3xl" />
                    </div>
                </x-reveal>
            @endif

            <x-reveal>
                <p class="text-xl font-medium leading-relaxed text-navy-800">{{ $post->summary }}</p>
            </x-reveal>

            @if ($post->body)
                <x-reveal class="mt-8 space-y-4 text-[17px] leading-relaxed text-navy-600">
                    @foreach (preg_split("/\R{2,}/", trim($post->body)) as $block)
                        @php
                            $lines = preg_split("/\R/", trim($block));
                            $isList = collect($lines)->every(fn ($line) => Str::startsWith(trim($line), ['-', '•', '*']));
                        @endphp

                        @if ($isList)
                            <ul class="space-y-2.5">
                                @foreach ($lines as $line)
                                    <li class="flex gap-3">
                                        <x-icon name="check" class="mt-1.5 h-4 w-4 shrink-0 text-electric-500" />
                                        <span>{{ ltrim(trim($line), '-•* ') }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            {{-- Single line breaks inside a paragraph are kept as the author typed them. --}}
                            <p class="whitespace-pre-line">{{ implode("\n", array_map('trim', $lines)) }}</p>
                        @endif
                    @endforeach
                </x-reveal>
            @endif

            @if ($post->hashtagList())
                <x-reveal class="mt-10 flex flex-wrap gap-2">
                    @foreach ($post->hashtagList() as $tag)
                        <span class="rounded-full bg-electric-50 px-3.5 py-1.5 text-sm font-semibold text-electric-700">#{{ $tag }}</span>
                    @endforeach
                </x-reveal>
            @endif

            {{-- Videos --}}
            @if ($videos->isNotEmpty())
                <div class="mt-14 space-y-6">
                    @foreach ($videos as $video)
                        <x-reveal>
                            <figure class="surface overflow-hidden p-0">
                                <div class="aspect-video w-full bg-navy-900">
                                    <video controls preload="metadata" playsinline class="h-full w-full object-cover"
                                           @if ($video->poster) poster="{{ asset($video->poster) }}" @endif>
                                        <source src="{{ asset($video->path) }}" type="video/mp4">
                                        Your browser doesn’t support embedded video.
                                    </video>
                                </div>
                                @if ($video->caption)
                                    <figcaption class="border-t border-navy-100 p-5 text-sm text-navy-600">{{ $video->caption }}</figcaption>
                                @endif
                            </figure>
                        </x-reveal>
                    @endforeach
                </div>
            @endif

            {{-- Photos --}}
            @if ($photos->isNotEmpty())
                <div class="mt-14">
                    <x-reveal>
                        <h2 class="mb-6 flex items-center gap-3 text-lg font-bold text-navy-900">
                            <x-icon name="sparkles" class="h-5 w-5 text-electric-500" /> Photos from the day
                        </h2>
                    </x-reveal>

                    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3">
                        @foreach ($photos as $photo)
                            <x-reveal :delay="($loop->index % 3) * 70" class="group relative aspect-square overflow-hidden rounded-2xl bg-navy-100">
                                <x-media :src="$photo->path" :alt="$photo->title ?? $post->title" rounded="rounded-2xl"
                                         class="transition-transform duration-700 ease-out group-hover:scale-105" />
                                @if ($photo->caption)
                                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-navy-950/75 via-transparent to-transparent opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                                    <p class="pointer-events-none absolute inset-x-0 bottom-0 translate-y-2 p-4 text-sm font-medium text-white opacity-0 transition-all duration-500 group-hover:translate-y-0 group-hover:opacity-100">
                                        {{ $photo->caption }}
                                    </p>
                                @endif
                            </x-reveal>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </article>

    {{-- More updates --}}
    @if ($more->isNotEmpty())
        <section class="bg-navy-50/60 py-16 lg:py-20">
            <div class="mx-auto max-w-7xl px-5 sm:px-8">
                <x-reveal>
                    <h2 class="mb-8 font-display text-2xl font-bold text-navy-900">More from the foundation</h2>
                </x-reveal>

                <div class="grid gap-6 sm:grid-cols-3">
                    @foreach ($more as $other)
                        <x-reveal :delay="$loop->index * 70" class="h-full">
                            <a href="{{ route('updates.show', $other) }}"
                               class="surface group flex h-full flex-col overflow-hidden transition-all duration-500 hover:-translate-y-1">
                                <div class="aspect-[16/10] overflow-hidden bg-navy-100">
                                    <x-media :src="$other->coverPath()" :alt="$other->title" rounded="rounded-none" icon="megaphone"
                                             class="transition-transform duration-700 ease-out group-hover:scale-105" />
                                </div>
                                <div class="flex flex-1 flex-col gap-2 p-5">
                                    @if ($other->dateLabel())
                                        <span class="text-xs font-semibold uppercase tracking-wide text-electric-600">{{ $other->dateLabel() }}</span>
                                    @endif
                                    <h3 class="text-[15px] font-bold leading-snug text-navy-900 transition-colors group-hover:text-electric-600">{{ $other->title }}</h3>
                                </div>
                            </a>
                        </x-reveal>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
