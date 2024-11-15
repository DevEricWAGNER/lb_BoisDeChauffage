<x-home>
    <section class="flex flex-col gap-5 p-5 mb-6 lg:py-0 lg:px-10 lg:mb-12">
        <h1 class="flex items-center gap-5 font-extrabold">
            <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M27.2 27.2C28.1017 27.2 28.9665 27.5582 29.6042 28.1958C30.2418 28.8335 30.6 29.6983 30.6 30.6C30.6 31.5017 30.2418 32.3665 29.6042 33.0042C28.9665 33.6418 28.1017 34 27.2 34C26.2983 34 25.4335 33.6418 24.7958 33.0042C24.1582 32.3665 23.8 31.5017 23.8 30.6C23.8 28.713 25.313 27.2 27.2 27.2ZM0 0H5.559L7.157 3.4H32.3C32.7509 3.4 33.1833 3.57911 33.5021 3.89792C33.8209 4.21673 34 4.64913 34 5.1C34 5.389 33.915 5.678 33.796 5.95L27.71 16.949C27.132 17.986 26.01 18.7 24.735 18.7H12.07L10.54 21.471L10.489 21.675C10.489 21.7877 10.5338 21.8958 10.6135 21.9755C10.6932 22.0552 10.8013 22.1 10.914 22.1H30.6V25.5H10.2C9.29826 25.5 8.43346 25.1418 7.79584 24.5042C7.15821 23.8665 6.8 23.0017 6.8 22.1C6.8 21.505 6.953 20.944 7.208 20.468L9.52 16.303L3.4 3.4H0V0ZM10.2 27.2C11.1017 27.2 11.9665 27.5582 12.6042 28.1958C13.2418 28.8335 13.6 29.6983 13.6 30.6C13.6 31.5017 13.2418 32.3665 12.6042 33.0042C11.9665 33.6418 11.1017 34 10.2 34C9.29826 34 8.43346 33.6418 7.79584 33.0042C7.15821 32.3665 6.8 31.5017 6.8 30.6C6.8 28.713 8.313 27.2 10.2 27.2ZM25.5 15.3L30.226 6.8H8.738L12.75 15.3H25.5Z" fill="#966F33"/>
            </svg>
            <span class="text-lg lg:text-3xl">{{ __('Récapitulatif du panier') }}</span>
        </h1>

        <div class="flex flex-col gap-5 lg:px-5">
            @if($products != [])
                @foreach($products as $product)
                    <article class="flex flex-col justify-between w-full gap-2 px-4 py-6 border-b border-gray-700 lg:flex-row" data-id="{{ $product["product_id"] }}">
                        <div>
                            <h2 class="text-xl font-bold">{{ $product["product_name"] }}</h2>
                            <p class="text-sm">{{ $product["product_description"] }}</p>
                        </div>
                        <div class="flex gap-5">
                            <div class="flex items-center gap-5">
                                <form action="{{ route('update_cart') }}" method="POST">
                                    @csrf
                                    @method("PATCH")
                                    <input type="hidden" name="id" value="{{ $product["product_id"] }}">
                                    <input type="number" name="quantity" value="{{ $product['quantity'] }}" class="bg-[#171716] quantity cart_update w-32 border rounded-lg" min="1" />
                                </form>
                                <h3 class="text-lg font-bold">{{ number_format($product['price'] * $product['quantity'] / 100 , 2) }} €</h3>
                            </div>
                            <form action="{{ route('remove_from_cart') }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <input type="hidden" name="id" value="{{ $product["product_id"] }}">
                                <button type="submit" class="px-4 py-2 text-xl bg-red-500 rounded-lg"><i class="fa fa-trash-o"></i></button>
                            </form>
                        </div>
                    </article>
                @endforeach
                <div class="flex flex-col items-end gap-5">
                    <div class="space-y-2 text-right">
                        <h4 class="text-2xl">{{ __('Sous total:') }} <span class="font-bold">{{ number_format($total / 100 , 2 ) }} €</span></h4>
                        <p class="text-xs">{{ __('En procédant au paiement, j\'accepte les') }} <a href="" class="text-indigo-500">{{ __('Termes') }}</a> {{ __('et la') }} <a href="" class="text-indigo-500">{{ __('Politique de confidentialité') }}</a></p>
                    </div>

                    <button id="adresses" data-modal-target="default-modal" data-modal-toggle="default-modal" class="bg-[#966F33] lg:text-3xl text-lg px-2 py-1 font-extrabold lg:px-5 lg:py-3 rounded-2xl" type="button">
                        {{ __('Passer au paiement') }}
                    </button>
                    <form action="{{route('session')}}" method="POST" id='proceder-au-paiement'>
                        @csrf
                        <input type="hidden" name="adress_id" value="" id="adress_id">
                        <button class="opacity-0" type="submit" id="checkout-live-button">{{ __('Passer au paiement') }}</button>
                    </form>
                </div>
            @else
                <article>
                    <h2 class="text-xl font-bold">{{ __('Vous n\'avez aucuns articles dans le panier') }}</h2>
                </article>
            @endif
        </div>
    </section>


<!-- Modal toggle -->

  <!-- Main modal -->
  <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
      <div class="relative w-full max-w-4xl max-h-full p-4">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <!-- Modal header -->
              <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                  <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    {{ __('Choisissez une adresse de livraison') }}
                  </h3>
                  <button type="button" class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                      <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                          <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                      </svg>
                      <span class="sr-only">Close modal</span>
                  </button>
              </div>
              <!-- Modal body -->
              <div class="p-4 space-y-4 md:p-5" id="modalContent">
                <div id="modalContentAjax"></div>
                <form id="NewAdresse" method="POST" action="{{route('createAdress')}}">
                    @csrf
                    @method('POST')
                    <h4 class="text-lg text-center text-gray-900">Veuillez entrer une nouvelle adresse</h4>
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
                            <x-text-input id="line1" type="text" name="line1" :value="old('line1')" :class="'bg-gray-400 text-white cursor-not-allowed'"  placeholder="Adresse ligne 1" autocomplete="line1" readonly />
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
                            <x-text-input id="postal_code" type="text" name="postal_code" :value="old('postal_code')" :class="'bg-gray-400 text-white cursor-not-allowed'"  placeholder="Code postal" autocomplete="postal_code" readonly />
                            <x-input-error :messages="$errors->get('postal_code')" class="mt-2" />
                        </div>
                        <div class="w-full">
                            <x-input-label for="city" :value="__('Ville')" />
                            <x-text-input id="city" type="text" name="city" :value="old('city')" :class="'bg-gray-400 text-white cursor-not-allowed'"  placeholder="Ville" autocomplete="city" readonly />
                            <x-input-error :messages="$errors->get('city')" class="mt-2" />
                        </div>
                    </div>

                </form>
              </div>
              <!-- Modal footer -->
              <div class="flex items-center p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                  <button data-modal-hide="default-modal" type="button" id='validerPopUp' class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{__('Valider')}}</button>
                  <button data-modal-hide="default-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">{{__('Annuler')}}</button>
              </div>
          </div>
      </div>
  </div>

    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            $(".cart_update").change(function () {
                $(this).closest("form").submit();
            });

            $('#adresses').click(function () {
                $.ajax({
                    url: '/adresses',
                    type: 'GET',
                    success: function(response) {
                        console.log(response)
                        $('#modalContentAjax').empty();
                        $('#modalContentAjax').append(response.html);
                        $('#NewAdresse').hide();
                    }
                })
            })

            $(document).on('click', '#validerPopUp', function() {
                var tableau = $('#tableAdresses');
                var radioChecked = false;

                // Étape 1 : Vérifier si le tableau existe et s'il contient des boutons radio
                if (tableau.length > 0) {
                    tableau.find('input[type="radio"]').each(function() {
                        if ($(this).is(':checked')) {
                            radioChecked = true;
                            return false; // Sortir de la boucle dès qu'un bouton radio est trouvé coché
                        }
                    });
                }

                // Étape 2 : Si aucun bouton radio n'est coché ou s'il n'y a pas de tableau, vérifier les champs de NewAdresse
                if (!radioChecked) {
                    var allFieldsFilled = true;

                    // Vérifiez chaque champ de #NewAdresse pour s'assurer qu'il est rempli, sauf line2 qui peut être vide
                    $('#NewAdresse').find('input[type="text"], select').each(function() {
                        if ($(this).attr('id') !== 'line2' && ($(this).val() === "" || $(this).val() === null)) {
                            allFieldsFilled = false;
                        }
                    });

                    // Si tous les champs requis ne sont pas remplis, afficher un message ou empêcher la soumission
                    if (!allFieldsFilled) {
                        alert('Veuillez sélectionner une adresse ou remplir tous les champs requis de la nouvelle adresse.');
                        return false; // Empêcher la soumission si condition non remplie
                    }

                    $('#NewAdresse').submit();
                } else {
                    $('#adress_id').val($('input[type="radio"]:checked').val());
                    $('#proceder-au-paiement').submit();
                }

            });

            $(document).on('click', '.btnNewAdress', function () {
                if ($('#NewAdresse').is(':visible')) {
                    $(this).text('Ajouter une nouvelle adresse'); // Text when form is hidden
                } else {
                    $(this).text('Annuler'); // Text when form is visible
                }
                $('#NewAdresse').toggle();
            });

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

            var adresseInput = document.getElementById("adresse");
            var countrySelect = document.getElementById("country");

            // Activer les champs d'adresse et de téléphone lorsque le pays est sélectionné
            countrySelect.addEventListener("change", function() {
                if (countrySelect.value) {
                    adresseInput.disabled = false;
                } else {
                    adresseInput.disabled = true;
                }
            });
        });
    </script>



</x-home>
