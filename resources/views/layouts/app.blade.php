<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#021B4E">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    @php
        $siteName = 'Nelo Dreams Foundation International';
        $defaultTitle = $siteName.' | Empowering Lives, Transforming Communities';
        $defaultDescription = 'Nelo Dreams Foundation International is dedicated to empowering vulnerable children, women, and communities through education, humanitarian support, skills development, healthcare initiatives, and sustainable programs that create lasting impact and hope for a brighter future.';
        $shareImage = asset('images/og-image.jpg');
    @endphp

    <title>@yield('title', $defaultTitle)</title>
    <meta name="description" content="@yield('meta_description', $defaultDescription)">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph (Facebook, WhatsApp, LinkedIn, Slack…) --}}
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', $defaultTitle)">
    <meta property="og:description" content="@yield('meta_description', $defaultDescription)">
    <meta property="og:image" content="{{ $shareImage }}">
    <meta property="og:image:secure_url" content="{{ $shareImage }}">
    <meta property="og:image:type" content="image/jpeg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="{{ $siteName }} — Glad You Were Born">
    <meta property="og:locale" content="en_US">

    {{-- Twitter / X cards --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $defaultTitle)">
    <meta name="twitter:description" content="@yield('meta_description', $defaultDescription)">
    <meta name="twitter:image" content="{{ $shareImage }}">
    <meta name="twitter:image:alt" content="{{ $siteName }} — Glad You Were Born">

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
