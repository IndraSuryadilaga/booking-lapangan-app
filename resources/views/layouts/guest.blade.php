<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Arena Digital') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-neutral-700 bg-white dark:bg-neutral-700 dark:text-neutral-100">        <div class="fixed top-8 right-8 z-50">
        <a href="/" class="flex items-center gap-2 h-8">
            <x-atoms.application-logo color="text-primary-500" class="block h-8 w-8" />
        </a>
        </div>

        <div class="min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">
            <div class="w-full max-w-6xl grid grid-cols-1 lg:grid-cols-2 gap-6">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
