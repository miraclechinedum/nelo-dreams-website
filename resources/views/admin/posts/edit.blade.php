@extends('layouts.admin')

@section('title', 'Edit post')
@section('heading', 'Edit post')
@section('subheading', $post->title)

@section('actions')
    <div class="flex flex-wrap gap-3">
        @if ($post->is_active)
            <a href="{{ route('updates.show', $post) }}" target="_blank" rel="noopener" class="admin-btn-ghost">
                <x-icon name="arrow-up-right" class="h-4 w-4" /> View on site
            </a>
        @endif
        <a href="{{ route('admin.posts.index') }}" class="admin-btn-ghost">All posts</a>
    </div>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.posts._form', ['submit' => 'Save changes'])
    </form>

    {{-- Kept outside the main form: HTML forms cannot be nested, so the buttons
         above reference these by id via their `form` attribute. --}}
    <form id="delete-post" method="POST" action="{{ route('admin.posts.destroy', $post) }}" class="hidden">
        @csrf @method('DELETE')
    </form>

    @foreach ($post->media as $item)
        <form id="detach-{{ $item->id }}" method="POST"
              action="{{ route('admin.posts.media.destroy', ['post' => $post, 'media' => $item]) }}" class="hidden">
            @csrf @method('DELETE')
        </form>
    @endforeach
@endsection
