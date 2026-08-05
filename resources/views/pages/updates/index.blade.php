@extends('layouts.app')

@section('title', 'Updates & Outreach | Nelo Dreams Foundation International')
@section('meta_description', 'Reports, photos and videos from Nelo Dreams Foundation International — school campaigns, community outreach and events, with the Rangers International FC Foundation.')

@section('content')
    {{-- Hero --}}
    <section class="relative overflow-hidden bg-navy-950 pb-20 pt-36 text-white lg:pb-24 lg:pt-44">
        <div class="pointer-events-none absolute -top-28 right-0 h-96 w-96 rounded-full bg-electric-600/25 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-28 -left-16 h-80 w-80 rounded-full bg-electric-500/15 blur-3xl"></div>

        <div class="relative mx-auto max-w-7xl px-5 sm:px-8">
            <x-section-header eyebrow="Updates" title="From our work, as it happens" tone="light">
                Outreach reports, school campaigns and events — with the photos and videos from each visit.
            </x-section-header>
        </div>
    </section>

    {{-- Posts --}}
    <section class="bg-white py-20 lg:py-24">
        <div class="mx-auto max-w-7xl px-5 sm:px-8">
            @if ($posts->isEmpty())
                <p class="mx-auto max-w-md text-center text-lg text-navy-500">
                    There’s nothing published here just yet — please check back soon.
                </p>
            @else
                <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($posts as $post)
                        <x-reveal :delay="($loop->index % 3) * 80" class="h-full">
                            <article class="surface group flex h-full flex-col overflow-hidden transition-all duration-500 hover:-translate-y-1">
                                <a href="{{ route('updates.show', $post) }}" class="relative block aspect-[16/10] overflow-hidden bg-navy-100">
                                    <x-media :src="$post->coverPath()" :alt="$post->title" rounded="rounded-none"
                                             icon="megaphone"
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

                                    <h2 class="text-lg font-bold leading-snug text-navy-900">
                                        <a href="{{ route('updates.show', $post) }}" class="transition-colors hover:text-electric-600">{{ $post->title }}</a>
                                    </h2>

                                    @if ($post->location)
                                        <p class="inline-flex items-center gap-1.5 text-sm text-navy-500">
                                            <x-icon name="map-pin" class="h-4 w-4 shrink-0 text-electric-500" />{{ $post->location }}
                                        </p>
                                    @endif

                                    <p class="text-[15px] leading-relaxed text-navy-600">{{ Str::limit($post->summary, 160) }}</p>

                                    <a href="{{ route('updates.show', $post) }}"
                                       class="mt-auto inline-flex items-center gap-2 pt-2 text-sm font-semibold text-electric-600 transition-colors hover:text-electric-700">
                                        Read the full story
                                        <x-icon name="arrow-right" class="h-4 w-4 transition-transform duration-300 group-hover:translate-x-1" />
                                    </a>
                                </div>
                            </article>
                        </x-reveal>
                    @endforeach
                </div>

                <div class="mt-14">{{ $posts->links() }}</div>
            @endif
        </div>
    </section>
@endsection
