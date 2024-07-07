<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil | Loïc Baldensperger</title>
    <link rel="stylesheet" href="./assets/css/style.css">
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#171716] text-[#F8F8F8]">
    @include('layouts.header')
    <main class="mt-48">
        {{ $slot }}
    </main>
    @include('layouts.footer')
</body>

</html>
