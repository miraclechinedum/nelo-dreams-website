@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Welcome back')
@section('subheading', 'Everything you publish here appears on the website straight away.')

@section('actions')
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.posts.create') }}" class="admin-btn"><x-icon name="megaphone" class="h-4 w-4" /> New post</a>
        <a href="{{ route('admin.media.create') }}" class="admin-btn-ghost"><x-icon name="sparkles" class="h-4 w-4" /> Upload media</a>
    </div>
@endsection

@section('content')
    @php
        $tiles = [
            ['label' => 'Posts', 'value' => $postCount, 'note' => $publishedCount.' live', 'icon' => 'megaphone', 'href' => route('admin.posts.index')],
            ['label' => 'Photos', 'value' => $photoCount, 'note' => 'in the media library', 'icon' => 'sparkles', 'href' => route('admin.media.index', ['type' => 'image'])],
            ['label' => 'Videos', 'value' => $videoCount, 'note' => 'in the media library', 'icon' => 'play', 'href' => route('admin.media.index', ['type' => 'video'])],
            ['label' => 'Messages', 'value' => $messageCount, 'note' => 'from the contact form', 'icon' => 'envelope', 'href' => route('admin.messages.index')],
        ];
    @endphp

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($tiles as $tile)
            <a href="{{ $tile['href'] }}" class="surface group p-5 transition hover:-translate-y-0.5">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-electric-50 text-electric-600">
                    <x-icon :name="$tile['icon']" class="h-5 w-5" />
                </span>
                <p class="mt-4 font-display text-3xl font-extrabold text-navy-900">{{ $tile['value'] }}</p>
                <p class="text-sm font-semibold text-navy-800">{{ $tile['label'] }}</p>
                <p class="text-xs text-navy-400">{{ $tile['note'] }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 lg:grid-cols-2">
        {{-- Recent posts --}}
        <section class="surface p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-display text-lg font-bold text-navy-900">Latest posts</h2>
                <a href="{{ route('admin.posts.index') }}" class="text-sm font-semibold text-electric-600 hover:text-electric-700">See all</a>
            </div>

            @forelse ($recentPosts as $post)
                <a href="{{ route('admin.posts.edit', $post) }}"
                   class="-mx-2 flex items-start gap-3 rounded-2xl px-2 py-3 transition hover:bg-navy-50">
                    <span @class([
                        'mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full',
                        'bg-emerald-500' => $post->is_active,
                        'bg-navy-200' => ! $post->is_active,
                    ])></span>
                    <span class="min-w-0">
                        <span class="block truncate text-sm font-semibold text-navy-900">{{ $post->title }}</span>
                        <span class="block text-xs text-navy-400">{{ $post->dateLabel() ?? 'No date' }}{{ $post->category ? ' · '.$post->category : '' }}</span>
                    </span>
                </a>
            @empty
                <p class="text-sm text-navy-500">No posts yet. <a href="{{ route('admin.posts.create') }}" class="font-semibold text-electric-600">Write the first one →</a></p>
            @endforelse
        </section>

        {{-- Recent uploads --}}
        <section class="surface p-6">
            <div class="mb-4 flex items-center justify-between">
                <h2 class="font-display text-lg font-bold text-navy-900">Recent uploads</h2>
                <a href="{{ route('admin.media.index') }}" class="text-sm font-semibold text-electric-600 hover:text-electric-700">See all</a>
            </div>

            @if ($recentMedia->isEmpty())
                <p class="text-sm text-navy-500">Nothing uploaded yet. <a href="{{ route('admin.media.create') }}" class="font-semibold text-electric-600">Upload a photo or video →</a></p>
            @else
                <div class="grid grid-cols-4 gap-2.5">
                    @foreach ($recentMedia as $item)
                        <a href="{{ route('admin.media.edit', $item) }}"
                           class="relative aspect-square overflow-hidden rounded-xl bg-navy-100">
                            <x-media :src="$item->stillPath()" :alt="$item->title ?? 'Upload'" rounded="rounded-xl" icon="sparkles" />
                            @if ($item->isVideo())
                                <span class="absolute inset-0 flex items-center justify-center bg-navy-950/35 text-white">
                                    <x-icon name="play" class="h-6 w-6" />
                                </span>
                            @endif
                        </a>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    <p class="mt-8 rounded-2xl border border-navy-100 bg-white px-5 py-4 text-sm text-navy-500">
        <strong class="font-semibold text-navy-800">Upload size:</strong>
        this server currently accepts files up to about <strong>{{ $uploadLimitMb }}MB</strong> each.
        If a large video is rejected, raise <code class="rounded bg-navy-50 px-1">upload_max_filesize</code> and
        <code class="rounded bg-navy-50 px-1">post_max_size</code> in cPanel → <em>Select PHP Version → Options</em>.
    </p>
@endsection
