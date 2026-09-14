@extends('layouts.admin')

@section('title', 'Add a team member')
@section('heading', 'Add a team member')
@section('subheading', 'They appear in the home-page team section as soon as you save.')

@section('actions')
    <a href="{{ route('admin.team.index') }}" class="admin-btn-ghost">Cancel</a>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @include('admin.team._form', ['submit' => 'Add to the team'])
    </form>
@endsection
