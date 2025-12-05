<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'KMG Environmental Solutions | Environmental Consultancy South Africa' }}</title>
    <meta name="description" content="{{ $description ?? 'Leading environmental consultancy providing expert solutions across South Africa. Accredited specialists in environmental compliance, training, and equipment rental.' }}">

    @if(isset($keywords))
        <meta name="keywords" content="{{ $keywords }}">
    @endif

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $title ?? 'KMG Environmental Solutions' }}">
    <meta property="og:description" content="{{ $description ?? 'Leading environmental consultancy providing expert solutions across South Africa.' }}">
    <meta property="og:image" content="{{ $ogImage ?? asset('images/og-homepage.jpg') }}">
    <meta property="og:site_name" content="KMG Environmental Solutions">
    <meta property="og:locale" content="en_ZA">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title ?? 'KMG Environmental Solutions' }}">
    <meta property="twitter:description" content="{{ $description ?? 'Leading environmental consultancy providing expert solutions across South Africa.' }}">
    <meta property="twitter:image" content="{{ $ogImage ?? asset('images/og-homepage.jpg') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#22c55e">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Head Content -->
    {{ $head ?? '' }}
</head>
<body class="min-h-screen font-sans antialiased bg-white text-zinc-950">
    <x-public.header />

    <main>
        {{ $slot }}
    </main>

    <x-public.gallery-strip />

    <x-public.footer />

    <x-public.floating-buttons />

    @fluxScripts
    @stack('scripts')
</body>
</html>
