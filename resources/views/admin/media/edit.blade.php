@extends('layouts.admin')

@section('title', 'Edit upload')
@section('heading', 'Edit upload')
@section('subheading', $item->title ?: 'Untitled')

@section('actions')
    <a href="{{ route('admin.media.index') }}" class="admin-btn-ghost">Back to library</a>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.media.update', $item) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.media._form', ['submit' => 'Save changes'])
    </form>

    <form method="POST" action="{{ route('admin.media.destroy', $item) }}" class="mt-6">
        @csrf @method('DELETE')
        <x-admin.confirm-button class="admin-btn-danger"
            title="Delete this file?"
            message="It will be removed from the website and deleted from the server. This cannot be undone.">
            Delete this file
        </x-admin.confirm-button>
    </form>
@endsection
