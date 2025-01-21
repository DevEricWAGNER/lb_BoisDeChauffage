<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} | Loïc Baldensperger</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="shortcut icon" href="{{ asset('storage/img/IMG-20240429-WA0007-removebg-preview.png') }}" type="image/x-icon">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <script src="https://cdn.jsdelivr.net/gh/mcstudios/glightbox/dist/js/glightbox.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#171716] text-[#F8F8F8] min-h-screen flex flex-col justify-between">
    <div>
        @include('layouts.header')
        <main class="mt-16 lg:mt-48">
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
            {{ $slot }}
        </main>
    </div>
    @include('layouts.footer')
</body>

</html>
