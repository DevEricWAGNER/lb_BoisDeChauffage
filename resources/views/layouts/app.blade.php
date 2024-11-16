<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title }} | Loïc Baldensperger</title>

        <link rel="shortcut icon" href="{{ asset('storage/img/IMG-20240429-WA0007-removebg-preview.png') }}" type="image/x-icon">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#171716] text-[#F8F8F8] min-h-screen flex flex-col justify-between">
        <div>
            @include('layouts.header')
            <main class="mt-16 lg:mt-48">
                {{ $slot }}
            </main>
        </div>
        @include('layouts.footer')
    </body>
</html>
