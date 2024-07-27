<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil | Loïc Baldensperger</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

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
