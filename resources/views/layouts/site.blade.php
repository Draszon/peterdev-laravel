<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500;700&family=Inter:wght@400;600;800&display=swap" rel="stylesheet">

        <title>{{ $title ?? config('app.name') }}</title>

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