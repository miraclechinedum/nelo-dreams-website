<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#021B4E">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    <title>@yield('title', 'Nelo Dreams Foundation International — Glad You Were Born')</title>
    <meta name="description" content="@yield('meta_description', 'Nelo Dreams Foundation International equips children with mental health knowledge, emotional skills, and confidence to thrive — in partnership with Rangers International FC Foundation.')">

    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('title', 'Nelo Dreams Foundation International')">
    <meta property="og:description" content="Every child deserves mental health knowledge. Glad You Were Born.">
    <meta property="og:type" content="website">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-ink antialiased selection:bg-electric-500 selection:text-white">
    {{-- Skip link for keyboard / screen-reader users --}}
    <a href="#main" class="sr-only focus:not-sr-only focus:fixed focus:left-4 focus:top-4 focus:z-[100] focus:rounded-full focus:bg-navy-900 focus:px-5 focus:py-2.5 focus:text-sm focus:font-semibold focus:text-white">
        Skip to main content
    </a>

    @include('partials.header')

    <main id="main">
        {{ $slot ?? '' }}
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
