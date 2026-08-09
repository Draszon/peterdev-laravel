<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Péter full-stack webfejlesztő, modern Laravel, Livewire és Tailwind alapú weboldalak, portfolio és egyedi digitális megoldások.">
        <meta name="keywords" content="full-stack webfejlesztő, Laravel fejlesztés, webalkalmazás, webalkalamzás fejlesztés Livewire, Tailwind CSS, weboldal készítés, portfolio oldal, egyedi weboldal">
        <meta name="author" content="Péter">
        <meta name="robots" content="index, follow">

        <link rel="canonical" href="{{ url('/') }}">
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
        <link rel="apple-touch-icon" href="{{ asset('apple-touch-icon.png') }}">
        <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;700&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

        <title>{{ $title ?? config('app.name') }}</title>

        <meta property="og:title" content="{{ $title ?? 'PeterDev | Full-stack webfejlesztő' }}">
        <meta property="og:description" content="Modern, gyors és reszponzív weboldalak, webalkalmazások Laravel és Livewire segítségével.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url('/') }}">
        <meta property="og:image" content="{{ asset('apple-touch-icon.png') }}">
        <meta property="og:site_name" content="{{ config('app.name') }}">
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $title ?? 'PeterDev | Full-stack webfejlesztő' }}">
        <meta name="twitter:description" content="Modern, gyors és reszponzív weboldalak, webalkalmazások Laravel és Livewire segítségével.">
        <meta name="twitter:image" content="{{ asset('apple-touch-icon.png') }}">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @livewireStyles
    </head>
    <body class="font-family-body bg-bg-main text-text-primary selection:bg-accent-base selection:text-bg-main antialiased overflow-x-hidden">
        <!-- HEADER -->
        <x-sections.header />

        {{ $slot }}

        <!-- FOOTER -->
        <x-sections.footer />

        @livewireScripts
    </body>
</html>