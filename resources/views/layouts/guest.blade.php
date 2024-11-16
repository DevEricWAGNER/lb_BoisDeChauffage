<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{$title}} | Loic Blandensperger</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="shortcut icon" href="{{ asset('storage/img/IMG-20240429-WA0007-removebg-preview.png') }}" type="image/x-icon">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="relative h-screen bg-center bg-cover" style="background-image: url('{{asset('storage/img/IMG-20240429-WA0005.jpg')}}')">
        <div class="absolute w-screen h-screen bg-black/50"></div>
        <a class="absolute justify-center hidden mb-4 md:flex" href="{{route('home')}}">
            <img src="{{ asset('storage/img/IMG-20240429-WA0007-removebg-preview.png') }}" alt="Logo"
                class="w-32 h-32">
        </a>
        <div class="flex items-center justify-center h-full">
            <div class="w-full max-w-2xl p-8 py-12 text-white border shadow-lg bg-white/25 rounded-3xl boder-white backdrop-blur-sm">
                <a class="flex justify-center mb-4 md:hidden" href="{{route('home')}}">
                    <img src="{{ asset('storage/img/IMG-20240429-WA0007-removebg-preview.png') }}" alt="Logo"
                        class="w-24 h-24">
                </a>
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
