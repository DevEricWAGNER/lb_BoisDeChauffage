<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="flex flex-col gap-2 text-xl">
        @csrf

        <h2 class="mb-4 text-3xl font-bold text-center">C'est Parti</h2>
        <p class="mb-4 text-xl font-bold text-center">Vous avez déjà un compte? <a href="{{ route('login') }}" class="text-[#FF9B25] hover:text-[#d89800]">Connectez-vous</a></p>

        <div class="flex flex-col gap-2 md:flex-row">
            <div class="w-full">
                <x-input-label for="firstname" :value="__('Prénom')" />
                <x-text-input id="firstname" type="text" name="firstname" :value="old('firstname')" required autofocus placeholder="Prénom" autocomplete="firstname" />
                <x-input-error :messages="$errors->get('firstname')" class="mt-2" />
            </div>
            <div class="w-full">
                <x-input-label for="lastname" :value="__('Nom de famille')" />
                <x-text-input id="lastname" type="text" name="lastname" :value="old('lastname')" required autofocus placeholder="Nom de famille" autocomplete="lastname" />
                <x-input-error :messages="$errors->get('lastname')" class="mt-2" />
            </div>
            <div class="w-full">
                <x-input-label for="name" :value="__('Nom d\'utilisateur')" />
                <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus placeholder="Nom d'utilisateur" autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>

        <div class="flex flex-col gap-2 md:flex-row">
            <div class="w-full">
                <x-input-label for="phone" :value="__('Num. de téléphone')" />
                <x-text-input id="phone" type="tel" name="phone" :value="old('phone')" required placeholder="Numéro de téléphone" autocomplete="phone" disabled />
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>
            <div class="w-full">
                <x-input-label for="email" :value="__('Adresse mail')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" required placeholder="Adresse mail" autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
        </div>
        <div class="w-full">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input id="password" type="password" name="password" required placeholder="Mot de passe" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>
        <div class="w-full">
            <x-input-label for="password_confirmation" :value="__('Confirmez le mot de passe')" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Confirmer le mot de passe" autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button>
            {{ __('Register') }}
        </x-primary-button>
    </form>

    <script type="text/javascript">

        document.addEventListener("DOMContentLoaded", function() {
            var phoneInput = document.getElementById("phone");
            phoneInput.addEventListener("blur", function() {
                var phoneNumber = phoneInput.value.trim();

                if (phoneNumber) {
                    validatePhoneNumber(phoneNumber);
                }
            });

            function validatePhoneNumber(phoneNumber) {
                console.log(phoneNumber);
                var apiUrl = `https://api.notilify.com/v1/phone-number/look-up?phoneNumber=${phoneNumber}`;

                fetch(apiUrl)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.status && data.data.valid) {
                            clearError();
                            phoneInput.classList.remove("border-red-500");
                            phoneInput.classList.add("border-green-500");
                        } else {
                            showError("Numéro de téléphone invalide. Veuillez vérifier le numéro saisi.");
                            phoneInput.classList.add("border-red-500");
                        }
                    })
                    .catch(error => {
                        showError("Erreur lors de la vérification du numéro de téléphone.");
                        console.error("Error:", error);
                    });
            }

            function showError(message) {
                var errorDiv = document.getElementById("phone-error");

                if (!errorDiv) {
                    errorDiv = document.createElement("div");
                    errorDiv.id = "phone-error";
                    errorDiv.classList.add("text-red-500", "mt-2");
                    phoneInput.insertAdjacentElement("afterend", errorDiv);
                }

                errorDiv.textContent = message;
            }

            function clearError() {
                var errorDiv = document.getElementById("phone-error");
                if (errorDiv) {
                    errorDiv.textContent = "";
                }
            }
        });
    </script>
</x-guest-layout>
