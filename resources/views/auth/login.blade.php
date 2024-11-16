<x-guest-layout>
    <x-slot name="title">
        {{$title}}
    </x-slot>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="mb-4 text-3xl font-bold text-center">Se connecter</h2>
    <p class="mb-4 text-xl font-bold text-center">Pas encore de compte? <a href="{{ route('register') }}" class="text-[#FF9B25] hover:text-[#d89800]">Inscrivez-vous</a></p>
    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-8 text-xl">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Adresse mail')" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus placeholder="Adresse mail" autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>
        <div>
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" type="password" name="password" required placeholder="Mot de passe" autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <x-primary-button>
            {{ __('Log in') }}
        </x-primary-button>
    </form>
</x-guest-layout>
