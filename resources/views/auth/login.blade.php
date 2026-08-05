<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#021B4E">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <title>Sign in · Nelo Dreams Foundation</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-navy-950 px-5 py-12 text-ink antialiased">
    {{-- ambient glow --}}
    <div class="pointer-events-none fixed -top-32 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full bg-electric-600/25 blur-3xl"></div>

    <div class="relative w-full max-w-md">
        <div class="mb-8 flex flex-col items-center text-center">
            <span class="h-14 w-14"><x-logo.nelo /></span>
            <p class="mt-4 font-display text-xl font-extrabold text-white">Nelo Dreams Foundation</p>
            <p class="mt-1 text-[13px] font-semibold uppercase tracking-[0.18em] text-electric-300">Admin panel</p>
        </div>

        <div class="surface p-7 sm:p-8">
            <h1 class="text-xl font-bold text-navy-900">Sign in</h1>
            <p class="mt-1.5 text-sm text-navy-500">Post photos, videos and updates to the website.</p>

            @if (session('status'))
                <p class="mt-5 rounded-xl bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">{{ session('status') }}</p>
            @endif

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-5">
                @csrf

                <div>
                    <label for="email" class="admin-label">Email address</label>
                    <input id="email" name="email" type="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username" class="admin-input">
                    @error('email') <p class="admin-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="password" class="admin-label">Password</label>
                    <input id="password" name="password" type="password"
                           required autocomplete="current-password" class="admin-input">
                    @error('password') <p class="admin-error">{{ $message }}</p> @enderror
                </div>

                <label class="flex items-center gap-2.5 text-sm text-navy-600">
                    <input type="checkbox" name="remember" value="1"
                           class="rounded border-navy-300 text-electric-500 focus:ring-electric-400">
                    Keep me signed in
                </label>

                <button type="submit" class="admin-btn w-full">Sign in</button>
            </form>
        </div>

        <p class="mt-6 text-center text-sm text-electric-100/60">
            <a href="{{ route('home') }}" class="hover:text-white">← Back to the website</a>
        </p>
    </div>
</body>
</html>
