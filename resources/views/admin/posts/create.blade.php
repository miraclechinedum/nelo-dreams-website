@extends('layouts.admin')

@section('title', 'New post')
@section('heading', 'New post')
@section('subheading', 'Write the update, then attach the photos and videos that go with it.')

@section('actions')
    <a href="{{ route('admin.posts.index') }}" class="admin-btn-ghost">Cancel</a>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('admin.posts._form', ['submit' => 'Create post'])
    </form>
@endsection
