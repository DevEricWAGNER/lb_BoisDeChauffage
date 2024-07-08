<header>
    <div class="absolute top-0 flex items-center h-16 overflow-hidden">
        <img src="{{ asset('storage/img/IMG-20240429-WA0005.jpg') }}" alt="" class="">
    </div>
    <div class="bg-gradient-to-b from-[#0c0c0c] to-[#171716] flex justify-between items-center px-6 rounded-t-3xl absolute top-4 z-10 w-full text-2xl">
        <nav class="flex items-center gap-8">
            <x-nav-link :href="route('home')">
                <img src="" alt="Loïc Baldensperger Logo" class="w-28" id="logo">
            </x-nav-link>
            <x-nav-link :href="route('home')" :active="request()->routeIs('home')" id="HomePageLink" class="hidden">
                {{ __('Accueil')}}
            </x-nav-link>
            <x-nav-link :href="route('home')" :active="request()->routeIs('dashboard')">
                {{ __('Boutique')}}
            </x-nav-link>
        </nav>
        @auth
            @php
                $link = route('home');
                if(Auth::user()->admin == true) {
                    $link = route('dashboard');
                }
            @endphp
            <x-nav-link :href="$link">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</x-nav-link>
        @else
            <a class="flex items-center justify-center w-16 group" href="{{ route('login') }}">
                <svg width="43" height="43" viewBox="0 0 43 43" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M21.5 0.166992C24.329 0.166992 27.0421 1.2908 29.0425 3.29119C31.0429 5.29157 32.1667 8.00468 32.1667 10.8337C32.1667 13.6626 31.0429 16.3757 29.0425 18.3761C27.0421 20.3765 24.329 21.5003 21.5 21.5003C18.671 21.5003 15.9579 20.3765 13.9575 18.3761C11.9572 16.3757 10.8334 13.6626 10.8334 10.8337C10.8334 8.00468 11.9572 5.29157 13.9575 3.29119C15.9579 1.2908 18.671 0.166992 21.5 0.166992ZM21.5 26.8337C33.2867 26.8337 42.8334 31.607 42.8334 37.5003V42.8337H0.166687V37.5003C0.166687 31.607 9.71335 26.8337 21.5 26.8337Z"
                        fill="#F8F8F8"  class="text-white fill-current group-hover:text-[#966F33]"/>
                </svg>
            </a>
        @endauth

    </div>
</header>
