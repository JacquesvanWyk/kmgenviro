<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    @if(isset($ogImage))
        <meta property="og:image" content="{{ $ogImage }}">
    @endif

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $title ?? 'KMG Environmental Solutions' }}">
    <meta property="twitter:description" content="{{ $description ?? 'Leading environmental consultancy providing expert solutions across South Africa.' }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Head Content -->
    {{ $head ?? '' }}
</head>
<body class="font-sans antialiased bg-white text-gray-900">
    <x-public.header />

    <main>
        {{ $slot }}
    </main>

    <x-public.footer />
</body>
</html>
