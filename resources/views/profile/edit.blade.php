<x-app-layout>
    <x-slot name="title">
        {{$title}}
    </x-slot>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-100">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto grid xl:grid-cols-3 md:grid-cols-2 xl:space-x-16 md:space-x-8 md:px-18 xl:px-36 px-9">
            @include('profile.partials.update-profile-information-form')
            @include('profile.partials.update-password-form')
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
