<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="theme-color" content="#021B4E">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <title>@yield('title', 'Admin') · Nelo Dreams Foundation</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-navy-50/50 text-ink antialiased">
@php
    $nav = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard', 'icon' => 'chart'],
        ['label' => 'Posts', 'route' => 'admin.posts.index', 'active' => 'admin.posts.*', 'icon' => 'megaphone'],
        ['label' => 'Photos & videos', 'route' => 'admin.media.index', 'active' => 'admin.media.*', 'icon' => 'sparkles'],
        ['label' => 'Messages', 'route' => 'admin.messages.index', 'active' => 'admin.messages.*', 'icon' => 'envelope'],
    ];
@endphp

<div x-data="{ sidebar: false }" class="min-h-screen lg:flex">
    {{-- Mobile top bar --}}
    <div class="flex items-center justify-between gap-3 border-b border-navy-100 bg-white px-4 py-3 lg:hidden">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
            <span class="h-9 w-9"><x-logo.nelo /></span>
            <span class="font-display text-sm font-extrabold text-navy-900">Nelo Dreams Admin</span>
        </a>
        <button type="button" @click="sidebar = !sidebar"
                class="inline-flex h-10 w-10 items-center justify-center rounded-full text-navy-900 hover:bg-navy-50"
                :aria-expanded="sidebar" aria-label="Toggle admin menu">
            <x-icon name="menu" x-show="!sidebar" class="h-6 w-6" />
            <x-icon name="close" x-show="sidebar" x-cloak class="h-6 w-6" />
        </button>
    </div>

    {{-- Sidebar --}}
    <aside :class="{ 'hidden': ! sidebar }"
           class="hidden w-full shrink-0 border-b border-navy-100 bg-white px-4 py-5 lg:sticky lg:top-0 lg:block lg:h-screen lg:w-72 lg:overflow-y-auto lg:border-b-0 lg:border-r lg:px-5 lg:py-7">
        <a href="{{ route('admin.dashboard') }}" class="mb-8 hidden items-center gap-3 lg:flex">
            <span class="h-11 w-11"><x-logo.nelo /></span>
            <span class="flex flex-col leading-tight">
                <span class="font-display text-base font-extrabold text-navy-900">Nelo Dreams</span>
                <span class="text-[11px] font-semibold uppercase tracking-[0.16em] text-electric-600">Admin panel</span>
            </span>
        </a>

        <nav class="space-y-1" aria-label="Admin">
            @foreach ($nav as $item)
                @php $isActive = request()->routeIs($item['active']); @endphp
                <a href="{{ route($item['route']) }}"
                   @click="sidebar = false"
                   @class([
                       'flex items-center gap-3 rounded-2xl px-4 py-3 text-sm font-semibold transition',
                       'bg-navy-900 text-white shadow-sm' => $isActive,
                       'text-navy-700 hover:bg-navy-50 hover:text-navy-900' => ! $isActive,
                   ])
                   @if ($isActive) aria-current="page" @endif>
                    <x-icon :name="$item['icon']" class="h-5 w-5" />
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="mt-8 space-y-3 border-t border-navy-100 pt-6">
            <a href="{{ route('home') }}" target="_blank" rel="noopener"
               class="flex items-center gap-2 px-4 text-sm font-semibold text-navy-600 hover:text-electric-600">
                <x-icon name="arrow-up-right" class="h-4 w-4" /> View the website
            </a>

            <a href="{{ route('admin.account.edit') }}"
               class="block rounded-2xl px-4 py-3 transition hover:bg-navy-50">
                <span class="block text-xs uppercase tracking-wider text-navy-400">Signed in as</span>
                <span class="block truncate text-sm font-semibold text-navy-900">{{ auth()->user()?->name }}</span>
                <span class="block truncate text-xs text-navy-500">{{ auth()->user()?->email }}</span>
                <span class="mt-1 inline-block text-xs font-semibold text-electric-600">Edit account &amp; password →</span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="px-4 pt-2">
                @csrf
                <button type="submit" class="admin-btn-ghost w-full">Sign out</button>
            </form>
        </div>
    </aside>

    {{-- Content --}}
    <main class="min-w-0 flex-1 px-4 py-7 sm:px-8 lg:py-10">
        <div class="mx-auto max-w-5xl">
            <div class="mb-7 flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h1 class="font-display text-2xl font-extrabold text-navy-900 sm:text-3xl">@yield('heading', 'Admin')</h1>
                    @hasSection('subheading')
                        <p class="mt-1.5 text-[15px] text-navy-500">@yield('subheading')</p>
                    @endif
                </div>
                @yield('actions')
            </div>

            @if (session('status'))
                <div class="mb-6 flex items-start gap-3 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800">
                    <x-icon name="check-circle" class="mt-0.5 h-5 w-5 shrink-0" />
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-800">
                    <p class="font-semibold">Please fix the following:</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @include('partials.admin.confirm-modal')
</div>
</body>
</html>
