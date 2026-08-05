@extends('layouts.admin')

@section('title', 'Photos & videos')
@section('heading', 'Photos & videos')
@section('subheading', 'Everything uploaded to the site — the home-page gallery and post attachments.')

@section('actions')
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('admin.media.create', ['type' => 'image']) }}" class="admin-btn"><x-icon name="sparkles" class="h-4 w-4" /> Upload photo</a>
        <a href="{{ route('admin.media.create', ['type' => 'video']) }}" class="admin-btn-ghost"><x-icon name="play" class="h-4 w-4" /> Upload video</a>
    </div>
@endsection

@section('content')
    @php
        $filters = [
            ['label' => 'Everything', 'value' => null],
            ['label' => 'Photos', 'value' => 'image'],
            ['label' => 'Videos', 'value' => 'video'],
        ];
    @endphp

    <div class="mb-6 flex flex-wrap gap-2">
        @foreach ($filters as $filter)
            <a href="{{ route('admin.media.index', array_filter(['type' => $filter['value']])) }}"
               @class([
                   'rounded-full px-4 py-2 text-sm font-semibold transition',
                   'bg-navy-900 text-white' => $type === $filter['value'],
                   'bg-white text-navy-700 ring-1 ring-inset ring-navy-200 hover:bg-navy-50' => $type !== $filter['value'],
               ])>{{ $filter['label'] }}</a>
        @endforeach
    </div>

    @if ($items->isEmpty())
        <div class="surface p-10 text-center">
            <span class="mx-auto inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-electric-50 text-electric-600">
                <x-icon name="sparkles" class="h-7 w-7" />
            </span>
            <h2 class="mt-4 font-display text-lg font-bold text-navy-900">Nothing here yet</h2>
            <p class="mx-auto mt-2 max-w-sm text-sm text-navy-500">Upload a photo or video and choose whether it shows in the home-page gallery.</p>
            <a href="{{ route('admin.media.create') }}" class="admin-btn mt-6">Upload something</a>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($items as $item)
                <div class="surface overflow-hidden">
                    <div class="relative aspect-[4/3] bg-navy-100">
                        @if ($item->isVideo())
                            <video class="h-full w-full object-cover" preload="metadata" controls
                                   @if ($item->poster) poster="{{ asset($item->poster) }}" @endif>
                                <source src="{{ asset($item->path) }}">
                            </video>
                            <span class="pointer-events-none absolute left-3 top-3 admin-chip bg-navy-950/70 text-white">
                                <x-icon name="play" class="h-3.5 w-3.5" /> Video
                            </span>
                        @else
                            <x-media :src="$item->path" :alt="$item->title ?? 'Photo'" rounded="rounded-none" />
                        @endif

                        @unless ($item->is_active)
                            <span class="absolute right-3 top-3 admin-chip bg-navy-950/70 text-white">Hidden</span>
                        @endunless
                    </div>

                    <div class="space-y-3 p-4">
                        <div>
                            <p class="truncate font-semibold text-navy-900">{{ $item->title ?: 'Untitled' }}</p>
                            <p class="line-clamp-2 text-xs text-navy-500">{{ $item->caption }}</p>
                        </div>

                        <div class="flex flex-wrap gap-1.5">
                            @if ($item->in_gallery)
                                <span class="admin-chip bg-electric-50 text-electric-700">Home gallery</span>
                            @endif
                            @if ($item->post)
                                <a href="{{ route('admin.posts.edit', $item->post) }}"
                                   class="admin-chip bg-navy-100 text-navy-700 hover:bg-navy-200">{{ Str::limit($item->post->title, 26) }}</a>
                            @endif
                            @if ($item->category)
                                <span class="admin-chip bg-navy-50 text-navy-600">{{ $item->category }}</span>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 pt-1">
                            <a href="{{ route('admin.media.edit', $item) }}" class="admin-btn px-4 py-2">Edit</a>

                            <form method="POST" action="{{ route('admin.media.toggle', $item) }}">
                                @csrf @method('PATCH')
                                <button type="submit" class="admin-btn-ghost px-3 py-2">{{ $item->is_active ? 'Hide' : 'Show' }}</button>
                            </form>

                            <form method="POST" action="{{ route('admin.media.destroy', $item) }}" class="ml-auto">
                                @csrf @method('DELETE')
                                <x-admin.confirm-button class="admin-btn-danger px-3 py-2"
                                    :title="'Delete '.($item->isVideo() ? 'this video' : 'this photo').'?'"
                                    message="It will be removed from the website and deleted from the server. This cannot be undone.">
                                    Delete
                                </x-admin.confirm-button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">{{ $items->links() }}</div>
    @endif
@endsection
