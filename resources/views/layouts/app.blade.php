<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#171716] text-[#F8F8F8] min-h-screen flex flex-col justify-between">
        <div id="preloader" class="fixed top-0 z-50 flex items-center justify-center w-full min-h-screen bg-black">
            <img src="{{ asset('storage/img/preloader.gif') }}" class="w-20">
        </div>
        <div>
            @include('layouts.header')
            <main class="mt-16 lg:mt-48">
                {{ $slot }}
            </main>
        </div>
        @include('layouts.footer')
    </body>
</html>
