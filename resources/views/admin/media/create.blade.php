@extends('layouts.admin')

@section('title', 'Upload')
@section('heading', 'Upload a photo or video')
@section('subheading', 'Goes straight to the website once you save it.')

@section('actions')
    <a href="{{ route('admin.media.index') }}" class="admin-btn-ghost">Cancel</a>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('admin.media._form', ['submit' => 'Upload'])
    </form>
@endsection
