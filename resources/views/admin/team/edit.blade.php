@extends('layouts.admin')

@section('title', 'Edit team member')
@section('heading', 'Edit team member')
@section('subheading', $member->name)

@section('actions')
    <a href="{{ route('admin.team.index') }}" class="admin-btn-ghost">Back to the team</a>
@endsection

@section('content')
    <form method="POST" action="{{ route('admin.team.update', $member) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        @include('admin.team._form', ['submit' => 'Save changes'])
    </form>

    <form method="POST" action="{{ route('admin.team.destroy', $member) }}" class="mt-6">
        @csrf @method('DELETE')
        <x-admin.confirm-button class="admin-btn-danger"
            :title="'Remove '.$member->name.'?'"
            message="They will be taken off the website and their uploaded photo deleted. This cannot be undone.">
            Remove from the team
        </x-admin.confirm-button>
    </form>
@endsection
