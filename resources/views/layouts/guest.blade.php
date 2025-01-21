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
            @if (\Session::has('error'))
                <div id="alert-additional-content-2" class="fixed z-50 flex items-center gap-10 p-4 text-red-800 transform -translate-x-1/2 border border-red-300 rounded-lg bg-red-50 dark:bg-[#171716] dark:text-red-400 dark:border-red-800 bottom-5 left-1/2" role="alert">
                    <div class="flex items-center gap-3">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-lg font-medium text-center">{!! \Session::get('error') !!}</h3>
                    </div>
                    <div class="flex items-center">
                        <button type="button" class="text-red-800 bg-transparent border border-red-800 hover:bg-red-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-red-600 dark:border-red-600 dark:text-red-500 dark:hover:text-white dark:focus:ring-red-800" onclick="document.getElementById('alert-additional-content-2').remove()" aria-label="Close">
                            D'accord
                        </button>
                    </div>
                </div>
            @endif
            @if (\Session::has('status'))
                <div id="alert-additional-content-2" class="fixed z-50 flex items-center gap-10 p-4 text-green-800 transform -translate-x-1/2 border border-green-300 rounded-lg bg-green-50 dark:bg-[#171716] dark:text-green-400 dark:border-green-800 bottom-5 left-1/2" role="alert">
                    <div class="flex items-center gap-3">
                        <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <h3 class="text-lg font-medium text-center">{!! \Session::get('status') !!}</h3>
                    </div>
                    <div class="flex items-center">
                        <button type="button" class="text-green-800 bg-transparent border border-green-800 hover:bg-green-900 hover:text-white focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-xs px-3 py-1.5 text-center dark:hover:bg-green-600 dark:border-green-600 dark:text-green-500 dark:hover:text-white dark:focus:ring-green-800" onclick="document.getElementById('alert-additional-content-2').remove()" aria-label="Close">
                            D'accord
                        </button>
                    </div>
                </div>
            @endif
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
