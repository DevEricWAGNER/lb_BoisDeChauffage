<header>
    <div class="absolute top-0 flex items-center h-16 overflow-hidden">
        <img src="{{ asset('storage/img/IMG-20240429-WA0005.jpg') }}" alt="" class="">
    </div>
    <nav class="rounded-t-3xl absolute top-4 z-40 w-full text-2xl flex justify-between items-center px-6 lg:py-4 bg-gradient-to-b from-[#0c0c0c] to-[#171716]">
        <x-nav-link :href="route('home')">
            <img src="" alt="Loïc Baldensperger Logo" class="w-12" id="logo">
        </x-nav-link>
        <div class="lg:hidden">
            <button class="flex items-center p-3 text-[#F8F8F8] navbar-burger">
                <svg class="block w-4 h-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Mobile menu</title>
                    <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"></path>
                </svg>
            </button>
        </div>
        <ul class="absolute hidden transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 lg:mx-auto lg:flex lg:items-center lg:w-auto lg:space-x-6">
            <li>
                <x-nav-link :href="route('home')" :active="request()->routeIs('home')" id="HomePageLink" class="hidden">
                    {{ __('Accueil')}}
                </x-nav-link>
            </li>
            <li>
                <x-nav-link :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                    {{ __('Boutique')}}
                </x-nav-link>
            </li>
        </ul>
        <div class="hidden lg:block">
            @auth
                @php
                    $link = route('cart');
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
    </nav>
</header>
<div class="relative z-50 hidden navbar-menu">
    <nav class="fixed top-0 bottom-0 left-0 flex flex-col w-5/6 h-screen max-w-sm px-6 py-6 overflow-y-auto bg-white border-r">
        <div class="flex items-center justify-between mb-8">
            <x-nav-link :href="route('home')">
                <img src="" alt="Loïc Baldensperger Logo" class="w-12" id="logov1">
            </x-nav-link>
            <button class="navbar-close">
                <svg class="w-6 h-6 text-black cursor-pointer hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <div>
            <ul>
                <x-nav-link-responsive :href="route('home')" :active="request()->routeIs('home')" id="HomePageLink2" class="hidden">
                    {{ __('Accueil')}}
                </x-nav-link-responsive>
                <x-nav-link-responsive :href="route('shop.index')" :active="request()->routeIs('shop.*')">
                    {{ __('Boutique')}}
                </x-nav-link-responsive>
            </ul>
        </div>
        <hr>
        @auth
            @php
                $link = route('cart');
                if(Auth::user()->admin == true) {
                    $link = route('dashboard');
                }
            @endphp
            <x-nav-link-responsive :href="$link">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</x-nav-link-responsive>
        @else
            <x-nav-link-responsive :href="route('login')">
                {{__('Se connecter')}}
            </x-nav-link-responsive>
        @endauth
    </nav>
</div>
