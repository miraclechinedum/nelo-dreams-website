@extends('layouts.admin')

@section('title', 'My account')
@section('heading', 'My account')
@section('subheading', 'Change your name, sign-in email or password.')

@section('content')
    <form method="POST" action="{{ route('admin.account.update') }}" class="space-y-6">
        @csrf
        @method('PATCH')

        <section class="surface space-y-5 p-6 sm:p-7">
            <h2 class="font-display text-lg font-bold text-navy-900">Your details</h2>

            <div>
                <label for="name" class="admin-label">Name</label>
                <input id="name" name="name" type="text" required maxlength="120"
                       value="{{ old('name', auth()->user()->name) }}" class="admin-input">
                @error('name') <p class="admin-error">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="email" class="admin-label">Sign-in email</label>
                <input id="email" name="email" type="email" required maxlength="160"
                       value="{{ old('email', auth()->user()->email) }}" class="admin-input" autocomplete="username">
                @error('email') <p class="admin-error">{{ $message }}</p> @enderror
            </div>
        </section>

        <section class="surface space-y-5 p-6 sm:p-7">
            <h2 class="font-display text-lg font-bold text-navy-900">Change password</h2>
            <p class="text-sm text-navy-500">Leave these blank to keep your current password.</p>

            <div>
                <label for="current_password" class="admin-label">Current password</label>
                <input id="current_password" name="current_password" type="password"
                       class="admin-input" autocomplete="current-password">
                @error('current_password') <p class="admin-error">{{ $message }}</p> @enderror
            </div>

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label for="password" class="admin-label">New password</label>
                    <input id="password" name="password" type="password" class="admin-input" autocomplete="new-password">
                    <p class="admin-hint">At least 10 characters.</p>
                    @error('password') <p class="admin-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="admin-label">Repeat new password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           class="admin-input" autocomplete="new-password">
                </div>
            </div>
        </section>

        <button type="submit" class="admin-btn">Save changes</button>
    </form>
@endsection
