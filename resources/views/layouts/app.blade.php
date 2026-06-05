<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SewaLapangan') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen flex flex-col bg-neutral-50 dark:bg-neutral-900">

    <x-organisms.navbar />

    @if(request()->is('admin*') || request()->routeIs('sports-categories.*') || request()->routeIs('facilities.*') || request()->routeIs('holidays.*'))
        <x-organisms.navbar-admin />

        <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            {{ $slot }}
        </main>

    @else
        <main class="flex-grow">
            {{ $slot }}
        </main>

    @endif

    <x-organisms.footer />

    </body>
</html>
