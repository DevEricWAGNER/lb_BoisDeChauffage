<footer class="relative overflow-hidden text-lg lg:text-2xl bottom-0">
    <!-- Image with black overlay -->
    <div class="absolute flex items-center w-full">
        <img class="object-cover w-full" src="{{ asset('storage/img/IMG-20240429-WA0005.jpg') }}" alt="">
        <div class="absolute inset-0 bg-black bg-opacity-75"></div>
    </div>

    <!-- Footer content -->
    <div class="relative z-20 flex flex-col items-center gap-5 py-5 lg:py-12 lg:gap-8 justify-evenly">
        <p>Rejoignez nous sur les réseaux</p>
        <div class="flex items-center justify-center gap-4 lg:gap-6" id="footer_social_links">
        </div>
        <div class="flex items-center justify-center gap-8 text-xs lg:text-xl">
            <a href="#" class="">Politique de confidentialité</a>
            <span class="rounded-full bg-[#966F33] w-5 h-5"></span>
            <a href="#">Termes & Conditions</a>
        </div>
    </div>
</footer>
