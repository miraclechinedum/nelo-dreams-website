@extends('layouts.admin')

@section('title', 'Team')
@section('heading', 'Our team')
@section('subheading', 'The people shown in the team section of the home page.')

@section('actions')
    <a href="{{ route('admin.team.create') }}" class="admin-btn"><x-icon name="users" class="h-4 w-4" /> Add team member</a>
@endsection

@section('content')
    @if ($members->isEmpty())
        <div class="surface p-10 text-center">
            <span class="mx-auto inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-electric-50 text-electric-600">
                <x-icon name="users" class="h-7 w-7" />
            </span>
            <h2 class="mt-4 font-display text-lg font-bold text-navy-900">No one here yet</h2>
            <p class="mx-auto mt-2 max-w-sm text-sm text-navy-500">Add each member of the foundation with their name, role and photo.</p>
            <a href="{{ route('admin.team.create') }}" class="admin-btn mt-6">Add the first person</a>
        </div>
    @else
        <p class="mb-5 text-sm text-navy-500">
            {{ $members->count() }} {{ Str::plural('person', $members->count()) }} ·
            {{ $members->where('is_active', true)->count() }} showing on the site.
            Change the sort order on each person to reorder the section.
        </p>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($members as $member)
                <div class="surface flex flex-col gap-4 p-5">
                    <div class="flex items-start gap-4">
                        <div class="h-16 w-16 shrink-0 overflow-hidden rounded-2xl bg-navy-100">
                            @if ($member->hasPhoto())
                                <img src="{{ asset($member->photo) }}" alt="{{ $member->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-navy-900 font-display text-lg font-bold text-electric-300">
                                    {{ $member->initials() }}
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="truncate font-semibold text-navy-900">{{ $member->name }}</p>
                            <p class="text-xs leading-snug text-navy-500">{{ $member->role }}</p>

                            <div class="mt-2 flex flex-wrap gap-1.5">
                                <span class="admin-chip {{ $member->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-navy-100 text-navy-600' }}">
                                    {{ $member->is_active ? 'Showing' : 'Hidden' }}
                                </span>
                                <span class="admin-chip bg-navy-50 text-navy-600">#{{ $member->sort_order }}</span>
                                @unless ($member->hasPhoto())
                                    <span class="admin-chip bg-amber-50 text-amber-700">No photo</span>
                                @endunless
                            </div>
                        </div>
                    </div>

                    @if ($member->bio)
                        <p class="line-clamp-2 text-xs leading-relaxed text-navy-500">{{ $member->bio }}</p>
                    @endif

                    <div class="mt-auto flex items-center gap-2 pt-1">
                        <a href="{{ route('admin.team.edit', $member) }}" class="admin-btn px-4 py-2">Edit</a>

                        <form method="POST" action="{{ route('admin.team.toggle', $member) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="admin-btn-ghost px-3 py-2">{{ $member->is_active ? 'Hide' : 'Show' }}</button>
                        </form>

                        <form method="POST" action="{{ route('admin.team.destroy', $member) }}" class="ml-auto">
                            @csrf @method('DELETE')
                            <x-admin.confirm-button class="admin-btn-danger px-3 py-2"
                                :title="'Remove '.$member->name.'?'"
                                message="They will be taken off the website and their uploaded photo deleted. This cannot be undone.">
                                Remove
                            </x-admin.confirm-button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
