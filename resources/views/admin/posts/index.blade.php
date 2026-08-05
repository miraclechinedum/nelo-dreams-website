@extends('layouts.admin')

@section('title', 'Posts')
@section('heading', 'Posts')
@section('subheading', 'News, outreach reports and upcoming events.')

@section('actions')
    <a href="{{ route('admin.posts.create') }}" class="admin-btn"><x-icon name="megaphone" class="h-4 w-4" /> New post</a>
@endsection

@section('content')
    @if ($posts->isEmpty())
        <div class="surface p-10 text-center">
            <span class="mx-auto inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-electric-50 text-electric-600">
                <x-icon name="megaphone" class="h-7 w-7" />
            </span>
            <h2 class="mt-4 font-display text-lg font-bold text-navy-900">No posts yet</h2>
            <p class="mx-auto mt-2 max-w-sm text-sm text-navy-500">
                A post is a write-up with photos or videos attached — an outreach report, a school visit, an upcoming event.
            </p>
            <a href="{{ route('admin.posts.create') }}" class="admin-btn mt-6">Write your first post</a>
        </div>
    @else
        <div class="surface divide-y divide-navy-100 overflow-hidden">
            @foreach ($posts as $post)
                <div class="flex flex-wrap items-center gap-4 p-4 sm:flex-nowrap sm:p-5">
                    <div class="h-16 w-24 shrink-0 overflow-hidden rounded-xl bg-navy-100">
                        <x-media :src="$post->coverPath()" :alt="$post->title" rounded="rounded-xl" icon="megaphone" />
                    </div>

                    <div class="min-w-0 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span @class([
                                'admin-chip',
                                'bg-emerald-50 text-emerald-700' => $post->is_active,
                                'bg-navy-100 text-navy-600' => ! $post->is_active,
                            ])>{{ $post->is_active ? 'Live' : 'Draft' }}</span>
                            @if ($post->category)
                                <span class="admin-chip bg-electric-50 text-electric-700">{{ $post->category }}</span>
                            @endif
                            <span class="text-xs text-navy-400">{{ $post->media_count }} {{ Str::plural('attachment', $post->media_count) }}</span>
                        </div>
                        <a href="{{ route('admin.posts.edit', $post) }}"
                           class="mt-1.5 block truncate font-semibold text-navy-900 hover:text-electric-600">{{ $post->title }}</a>
                        <p class="truncate text-xs text-navy-400">
                            {{ $post->dateLabel() ?? 'No date' }}{{ $post->location ? ' · '.$post->location : '' }}
                        </p>
                    </div>

                    <div class="flex shrink-0 items-center gap-2">
                        @if ($post->is_active)
                            <a href="{{ route('updates.show', $post) }}" target="_blank" rel="noopener"
                               class="admin-btn-ghost px-3 py-2" title="View on the site">
                                <x-icon name="arrow-up-right" class="h-4 w-4" />
                            </a>
                        @endif

                        <form method="POST" action="{{ route('admin.posts.toggle', $post) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="admin-btn-ghost px-3 py-2">
                                {{ $post->is_active ? 'Unpublish' : 'Publish' }}
                            </button>
                        </form>

                        <a href="{{ route('admin.posts.edit', $post) }}" class="admin-btn px-4 py-2">Edit</a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $posts->links() }}</div>
    @endif
@endsection
