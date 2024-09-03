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

        <div>
            <x-input-label for="country" :value="__('Pays')" />
            <select id="country" name="country" class="box-border block w-full text-black border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="" disabled selected>Sélectionnez un pays</option>
                <option value="fr">France</option>
                <option value="de">Allemagne</option>
                <option value="be">Belgique</option>
                <option value="it">Italie</option>
                <option value="es">Espagne</option>
                <option value="gb">Royaume-Uni</option>
                <option value="ch">Suisse</option>
                <option value="nl">Pays-Bas</option>
                <option value="pt">Portugal</option>
            </select>
        </div>

        <div class="test">
            <div class="w-full">
                <x-input-label for="adresse" :value="__('Adresse')" />
                <x-text-input id="adresse" type="text" name="adresse" :value="old('adresse')" required placeholder="Adresse" autocomplete="adresse" disabled />
                <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
            </div>
            <div id="selection" style="display: none;" class="dropdown"></div>
        </div>
        <div class="flex flex-col gap-2 md:flex-row">
            <div class="w-full">
                <x-input-label for="line1" :value="__('Adresse ligne 1')" />
                <x-text-input id="line1" type="text" name="line1" :value="old('line1')" :class="'bg-gray-400 text-white cursor-not-allowed'" required placeholder="Adresse ligne 1" autocomplete="line1" readonly />
                <x-input-error :messages="$errors->get('line1')" class="mt-2" />
            </div>
            <div class="w-full">
                <x-input-label for="line2" :value="__('Adresse ligne 2')" />
                <x-text-input id="line2" type="text" name="line2" :value="old('line2')" placeholder="Adresse ligne 2" autocomplete="line2" />
                <x-input-error :messages="$errors->get('line2')" class="mt-2" />
            </div>
        </div>
        <div class="flex flex-col gap-2 md:flex-row">
            <div class="w-full">
                <x-input-label for="postal_code" :value="__('Code postal')" />
                <x-text-input id="postal_code" type="text" name="postal_code" :value="old('postal_code')" :class="'bg-gray-400 text-white cursor-not-allowed'" required placeholder="Code postal" autocomplete="postal_code" readonly />
                <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
            </div>
            <div class="w-full">
                <x-input-label for="city" :value="__('Ville')" />
                <x-text-input id="city" type="text" name="city" :value="old('city')" :class="'bg-gray-400 text-white cursor-not-allowed'" required placeholder="Ville" autocomplete="city" readonly />
                <x-input-error :messages="$errors->get('city')" class="mt-2" />
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
        var requestURL = 'https://api-adresse.data.gouv.fr/search/?q=';
        var select = document.getElementById("selection");
        var lat = "";
        var lon = "";
        var country_code = "";

        window.onload = function() {
            document.getElementById("adresse").addEventListener("input", autocompleteAdresse, false);
        };

        function displaySelection(response) {
            if (response && response.length > 0) {
                select.style.display = "block";
                select.innerHTML = ''; // Clear the dropdown before adding content
                var ul = document.createElement('ul');
                select.appendChild(ul);

                response.forEach(function (element) {
                    var li = document.createElement('li');
                    var ligneAdresse = document.createElement('span');
                    var infosAdresse = document.createTextNode('');
                    if (element.address.town != undefined) {
                        infosAdresse = document.createTextNode(' ' + element.address.postcode + ' ' + element.address.town);
                    } else if (element.address.city != undefined) {
                        infosAdresse = document.createTextNode(' ' + element.address.postcode + ' ' + element.address.city);
                    } else if (element.address.village != undefined) {
                        infosAdresse = document.createTextNode(' ' + element.address.postcode + ' ' + element.address.village);
                    }
                    ligneAdresse.innerHTML = element.address.house_number + " " + element.address.road;
                    li.onclick = function () { selectAdresse(element); };
                    li.appendChild(ligneAdresse);
                    li.appendChild(infosAdresse);
                    ul.appendChild(li);
                });
            } else {
                select.style.display = "none";
            }
        }

        function combineResults(osmData, gouvData) {
            var combined = [];

            // Fonction pour vérifier si un élément est valide
            function isValidAddress(element) {
                return (
                    element.address.house_number !== undefined &&
                    element.address.road !== undefined &&
                    element.address.postcode !== undefined &&
                    (element.address.city !== undefined || element.address.town !== undefined || element.address.village !== undefined)
                );
            }

            // Process OpenStreetMap data
            osmData.forEach(element => {
                if (isValidAddress(element)) {
                    combined.push({
                        address: element.address,
                        lat: element.lat,
                        lon: element.lon
                    });
                }
            });

            // Process data.gouv.fr data
            gouvData.features.forEach(element => {
                var address = {
                    house_number: element.properties.housenumber,
                    road: element.properties.street,
                    postcode: element.properties.postcode,
                    city: element.properties.city
                };

                if (isValidAddress({ address })) {
                    combined.push({
                        address: address,
                        lat: element.geometry.coordinates[1],  // latitude
                        lon: element.geometry.coordinates[0]   // longitude
                    });
                }
            });

            return combined;
        }

        function autocompleteAdresse() {
            var inputValue = document.getElementById("adresse").value;
            if (inputValue) {
                var inputValueOsm = inputValue.replace(/ /g, '+');
                var inputValueGouv = inputValue.replace(/ /g, '%20');
                var osmApiUrl = `https://nominatim.openstreetmap.org/search?format=json&q=${inputValueOsm}&addressdetails=1&countrycodes=fr,de,gb,us&viewbox=-5.317382,51.124213,9.84375,41.705728&bounded=1`;
                var dataGouvApiUrl = `https://api-adresse.data.gouv.fr/search/?q=${inputValueGouv}&autocomplete=0`;

                // Fetch from both APIs
                Promise.all([
                    fetch(osmApiUrl).then(response => response.json()),
                    fetch(dataGouvApiUrl).then(response => response.json())
                ])
                .then(([osmData, gouvData]) => {
                    var combinedResults = combineResults(osmData, gouvData);
                    displaySelection(combinedResults);
                });
            } else {
                select.style.display = "none";
            }
        }

        function selectAdresse(element) {
            document.getElementById("adresse").value = element.address.house_number + " " + element.address.road + ", " + element.address.postcode + " " + element.address.city;
            select.style.display = "none";
            document.getElementById("line1").value = element.address.house_number + " " + element.address.road;
            document.getElementById("postal_code").value = element.address.postcode;
            if (element.address.town != undefined) {
                document.getElementById("city").value = element.address.town;
            } else if (element.address.city != undefined) {
                document.getElementById("city").value = element.address.city;
            } else if (element.address.village != undefined) {
                document.getElementById("city").value = element.address.village;
            }
            lat = element.lat;
            lon = element.lon;
            getCountryCode(lat, lon);
        }

        function getCountryCode(latitude, longitude) {
            var apiUrlCountry = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&addressdetails=1&viewbox=-5.317382,51.124213,9.84375,41.705728&bounded=1`;
            fetch(apiUrlCountry)
                .then(response => response.json())
                .then(data => {
                    if (data && data.address && data.address.country_code) {
                        country_code = data.address.country_code;
                    }
                })
                .catch(error => {
                    showError("Erreur lors de la vérification du numéro de téléphone.");
                    console.error("Error:", error);
                });
        }

        document.addEventListener("DOMContentLoaded", function() {
            var phoneInput = document.getElementById("phone");
            var adresseInput = document.getElementById("adresse");
            var countrySelect = document.getElementById("country");

            // Activer les champs d'adresse et de téléphone lorsque le pays est sélectionné
            countrySelect.addEventListener("change", function() {
                if (countrySelect.value) {
                    adresseInput.disabled = false;
                    phoneInput.disabled = false;
                } else {
                    adresseInput.disabled = true;
                    phoneInput.disabled = true;
                }
            });

            phoneInput.addEventListener("blur", function() {
                var phoneNumber = phoneInput.value.trim();
                var countryCode = countrySelect.value;

                if (phoneNumber) {
                    switch (countryCode) {
                        case "fr":
                            if (phoneNumber.startsWith("0")) {
                                phoneNumber = phoneNumber.replace(/^0/, "+33");
                            }
                            break;
                        case "de":
                            if (phoneNumber.startsWith("0")) {
                                phoneNumber = phoneNumber.replace(/^0/, "+49");
                            }
                            break;
                        case "be":
                            if (phoneNumber.startsWith("0")) {
                                phoneNumber = phoneNumber.replace(/^0/, "+32");
                            }
                            break;
                        case "it":
                            if (phoneNumber.startsWith("0")) {
                                phoneNumber = phoneNumber.replace(/^0/, "+39");
                            }
                            break;
                        case "es":
                            if (phoneNumber.startsWith("0")) {
                                phoneNumber = phoneNumber.replace(/^0/, "+34");
                            }
                            break;
                        case "gb":
                            if (phoneNumber.startsWith("0")) {
                                phoneNumber = phoneNumber.replace(/^0/, "+44");
                            }
                            break;
                        case "ch":
                            if (phoneNumber.startsWith("0")) {
                                phoneNumber = phoneNumber.replace(/^0/, "+41");
                            }
                            break;
                        case "nl":
                            if (phoneNumber.startsWith("0")) {
                                phoneNumber = phoneNumber.replace(/^0/, "+31");
                            }
                            break;
                        case "pt":
                            if (phoneNumber.startsWith("0")) {
                                phoneNumber = phoneNumber.replace(/^0/, "+351");
                            }
                            break;
                        default:
                            showError("Code pays non pris en charge pour la validation du numéro de téléphone.");
                            return; // Arrêter l'exécution si le pays n'est pas pris en charge
                    }

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
