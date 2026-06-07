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
    <body class="font-sans antialiased text-neutral-700 bg-white dark:bg-neutral-700 dark:text-neutral-100">
        <x-organisms.navbar />

        @if(request()->is('admin*') || request()->routeIs('sports-categories.*') || request()->routeIs('facilities.*') || request()->routeIs('holidays.*'))
            <x-organisms.navbar-admin />
        @endif

        <main class="flex-grow w-full">
            @isset($header)
                <div class="mb-8">
                    {{ $header }}
                </div>
            @endisset

            @if(request()->is('admin*') || request()->routeIs('sports-categories.*') || request()->routeIs('facilities.*') || request()->routeIs('holidays.*'))
                <div class="pt-44 pb-12">
                    {{ $slot }}
                </div>
            @else
                {{ $slot }}
            @endif
        </main>

        @if(!request()->is('admin*') && !request()->routeIs('sports-categories.*') && !request()->routeIs('facilities.*') && !request()->routeIs('holidays.*'))
            <x-organisms.footer />
        @endif

    </body>
</html>
