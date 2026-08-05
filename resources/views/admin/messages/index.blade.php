@extends('layouts.admin')

@section('title', 'Messages')
@section('heading', 'Messages')
@section('subheading', 'Everything sent through the contact form on the website.')

@section('content')
    @if ($messages->isEmpty())
        <div class="surface p-10 text-center">
            <span class="mx-auto inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-electric-50 text-electric-600">
                <x-icon name="envelope" class="h-7 w-7" />
            </span>
            <h2 class="mt-4 font-display text-lg font-bold text-navy-900">No messages yet</h2>
            <p class="mt-2 text-sm text-navy-500">New enquiries from the contact form will land here.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($messages as $message)
                <article class="surface p-5 sm:p-6">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0">
                            <p class="font-semibold text-navy-900">{{ $message->name }}</p>
                            <p class="text-sm text-navy-500">
                                <a href="mailto:{{ $message->email }}" class="hover:text-electric-600">{{ $message->email }}</a>
                                @if ($message->phone) · {{ $message->phone }} @endif
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            @if ($message->interest)
                                <span class="admin-chip bg-electric-50 text-electric-700">{{ $message->interest }}</span>
                            @endif
                            <span class="text-xs text-navy-400">{{ $message->created_at?->format('j M Y, g:ia') }}</span>
                        </div>
                    </div>

                    <p class="mt-4 whitespace-pre-line text-[15px] leading-relaxed text-navy-700">{{ $message->message }}</p>

                    <div class="mt-5 flex items-center gap-3">
                        <a href="mailto:{{ $message->email }}" class="admin-btn px-4 py-2">Reply by email</a>
                        <form method="POST" action="{{ route('admin.messages.destroy', $message) }}">
                            @csrf @method('DELETE')
                            <x-admin.confirm-button class="admin-btn-danger"
                                title="Delete this message?"
                                :message="'The enquiry from '.$message->name.' will be removed permanently.'">
                                Delete
                            </x-admin.confirm-button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">{{ $messages->links() }}</div>
    @endif
@endsection
