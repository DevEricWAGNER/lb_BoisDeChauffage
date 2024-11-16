<footer class="relative bottom-0 overflow-hidden text-lg lg:text-2xl">
    <!-- Image with black overlay -->
    <div class="absolute flex items-center w-full">
        <img class="object-cover w-full" src="{{ asset('storage/img/IMG-20240429-WA0005.jpg') }}" alt="">
        <div class="absolute inset-0 bg-black bg-opacity-75"></div>
    </div>

    <!-- Footer content -->
    <div class="relative z-20 flex flex-col items-center gap-5 py-5 lg:py-12 lg:gap-8 justify-evenly">
        <p>Rejoignez nous sur les réseaux</p>
        <div class="flex items-center justify-center gap-4 lg:gap-6">
            <a href="mailto:contact@webwagner.fr" rel="noopener noreferrer">
                <img class="w-6 lg:w-16" src="{{ asset('storage/icons/social/gmail.png') }}" alt="">
            </a>
            <a href="https://www.facebook.com/loic.baldensperger" target="_blank" rel="noopener noreferrer">
                <img class="w-6 lg:w-16" src="{{ asset('storage/icons/social/facebook.png') }}" alt="">
            </a>
        </div>
        <div class="flex items-center justify-center gap-8 text-xs lg:text-xl">
            <a href="{{route('politique')}}" class="">Politique de confidentialité</a>
            <span class="rounded-full bg-[#966F33] w-5 h-5"></span>
            <a href="{{route('terms')}}">Termes & Conditions</a>
        </div>
    </div>
</footer>
