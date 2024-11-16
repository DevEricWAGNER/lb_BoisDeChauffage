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

<body class="bg-[#171716] text-[#F8F8F8] h-screen flex flex-col justify-between">
    <div id="preloader" class="fixed top-0 z-50 flex items-center justify-center w-full min-h-screen bg-black">
        <img src="{{ asset('storage/img/preloader.gif') }}" class="w-20">
    </div>
    <div>
        <div class="flex items-center h-32 overflow-hidden">
            <img src="{{ asset('storage/img/IMG-20240429-WA0005.jpg') }}" alt="" class="">
        </div>
        <main class="flex flex-col items-center justify-center h-full gap-14">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('storage/img/IMG-20240429-WA0007-removebg-preview.png')}}" alt="" class="w-60 aspect-square">
                <h1 class="lg:text-9xl text-3xl font-extrabold text-[#966F33]">{{ __('Annulation') }}</h1>
                <h2 class="text-xl font-bold lg:text-6xl">{{ __('de la commande') }}</h2>
            </div>
            <a href="{{route('home')}}" class="text-[#FF9B25] lg:text-2xl lg:px-20 lg:py-4 px-4 py-2 bg-gradient-to-br from-[#272726] to-[#171716] w-fit rounded-xl border solid border-[#F8F8F8]">{{ __('Retourner à l\'accueil') }}</a>
        </main>
    </div>
</body>

</html>
