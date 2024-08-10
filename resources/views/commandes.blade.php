<x-home>
    <section class="flex flex-col gap-5 p-5 mb-6 lg:py-0 lg:px-10 lg:mb-12">
        <h1 class="flex items-center gap-5 font-extrabold">
            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 448 512" fill="none">
                <path d="M50.7 58.5L0 160h208V32L93.7 32C75.5 32 58.9 42.3 50.7 58.5zM240 160h208L397.3 58.5C389.1 42.3 372.5 32 354.3 32H240v128zm208 32H0v224c0 35.3 28.7 64 64 64h320c35.3 0 64-28.7 64-64V192z" fill="#966F33"/>
            </svg>
            <span class="text-lg lg:text-3xl">{{ __('Récapitulatif de vos commandes') }}</span>
        </h1>

        <div class="flex flex-col gap-5 lg:px-5">
            @if($groupedCommandes)
                @foreach($groupedCommandes as $payment_id => $data)
                    @php
                        $firstCommande = $data['items']->first();
                    @endphp
                    <article class="flex flex-col justify-between w-full gap-2 px-4 py-6 border-b border-gray-700 lg:flex-row" data-id="{{ $payment_id }}">
                        <h2 class="text-xl font-bold">Commande passée le {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $firstCommande->updated_at)->format('d/m/Y H:i') }}</h2>
                        @if ($firstCommande->payment_status == "complete")
                            <p class="flex items-center gap-5 text-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                                    <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z" fill="#966F33"/>
                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" fill="#966F33"/>
                                </svg>
                                <span>{{ __('Commandé') }}</span>
                            </p>
                        @elseif ($firstCommande->payment_status == "expedie")
                            <p class="flex items-center gap-5 text-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width='40' height='40' viewBox="0 0 640 512">
                                    <path d="M640 0l0 400c0 61.9-50.1 112-112 112c-61 0-110.5-48.7-112-109.3L48.4 502.9c-17.1 4.6-34.6-5.4-39.3-22.5s5.4-34.6 22.5-39.3L352 353.8 352 64c0-35.3 28.7-64 64-64L640 0zM576 400a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM23.1 207.7c-4.6-17.1 5.6-34.6 22.6-39.2l46.4-12.4 20.7 77.3c2.3 8.5 11.1 13.6 19.6 11.3l30.9-8.3c8.5-2.3 13.6-11.1 11.3-19.6l-20.7-77.3 46.4-12.4c17.1-4.6 34.6 5.6 39.2 22.6l41.4 154.5c4.6 17.1-5.6 34.6-22.6 39.2L103.7 384.9c-17.1 4.6-34.6-5.6-39.2-22.6L23.1 207.7z" fill="#966F33"/>
                                </svg>
                                <span>{{ __('Expédié') }}</span>
                            </p>
                        @elseif ($firstCommande->payment_status == "livraison")
                            <p class="flex items-center gap-5 text-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width='40' height='40' viewBox="0 0 640 512">
                                    <path d="M112 0C85.5 0 64 21.5 64 48l0 48L16 96c-8.8 0-16 7.2-16 16s7.2 16 16 16l48 0 208 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L64 160l-16 0c-8.8 0-16 7.2-16 16s7.2 16 16 16l16 0 176 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L64 224l-48 0c-8.8 0-16 7.2-16 16s7.2 16 16 16l48 0 144 0c8.8 0 16 7.2 16 16s-7.2 16-16 16L64 288l0 128c0 53 43 96 96 96s96-43 96-96l128 0c0 53 43 96 96 96s96-43 96-96l32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l0-64 0-32 0-18.7c0-17-6.7-33.3-18.7-45.3L512 114.7c-12-12-28.3-18.7-45.3-18.7L416 96l0-48c0-26.5-21.5-48-48-48L112 0zM544 237.3l0 18.7-128 0 0-96 50.7 0L544 237.3zM160 368a48 48 0 1 1 0 96 48 48 0 1 1 0-96zm272 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0z" fill="#966F33"/>
                                </svg>
                                <span>{{ __('Livraison') }}</span>
                            </p>
                        @elseif ($firstCommande->payment_status == "livre")
                            <p class="flex items-center gap-5 text-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" width='40' height='40' viewBox="0 0 640 512" fill='none'>
                                    <path d="M323.4 85.2l-96.8 78.4c-16.1 13-19.2 36.4-7 53.1c12.9 17.8 38 21.3 55.3 7.8l99.3-77.2c7-5.4 17-4.2 22.5 2.8s4.2 17-2.8 22.5l-20.9 16.2L512 316.8 512 128l-.7 0-3.9-2.5L434.8 79c-15.3-9.8-33.2-15-51.4-15c-21.8 0-43 7.5-60 21.2zm22.8 124.4l-51.7 40.2C263 274.4 217.3 268 193.7 235.6c-22.2-30.5-16.6-73.1 12.7-96.8l83.2-67.3c-11.6-4.9-24.1-7.4-36.8-7.4C234 64 215.7 69.6 200 80l-72 48 0 224 28.2 0 91.4 83.4c19.6 17.9 49.9 16.5 67.8-3.1c5.5-6.1 9.2-13.2 11.1-20.6l17 15.6c19.5 17.9 49.9 16.6 67.8-2.9c4.5-4.9 7.8-10.6 9.9-16.5c19.4 13 45.8 10.3 62.1-7.5c17.9-19.5 16.6-49.9-2.9-67.8l-134.2-123zM16 128c-8.8 0-16 7.2-16 16L0 352c0 17.7 14.3 32 32 32l32 0c17.7 0 32-14.3 32-32l0-224-80 0zM48 320a16 16 0 1 1 0 32 16 16 0 1 1 0-32zM544 128l0 224c0 17.7 14.3 32 32 32l32 0c17.7 0 32-14.3 32-32l0-208c0-8.8-7.2-16-16-16l-80 0zm32 208a16 16 0 1 1 32 0 16 16 0 1 1 -32 0z" fill="#966F33"/>
                                </svg>
                                <span>{{ __('Livré') }}</span>
                            </p>
                        @endif
                        <div class="flex items-center gap-5">
                            <h3 class="text-lg font-bold">Total : {{ number_format($data['totalPrice'], 2) }} €</h3>
                            <button class="px-4 py-2 bg-blue-500 rounded-lg hover:bg-blue-800 show_details">Voir le détail</button>
                        </div>
                    </article>
                @endforeach
            @else
                <article>
                    <h2 class="text-xl font-bold">{{ __('Vous n\'avez passer aucunes commandes.') }}</h2>
                </article>
            @endif
        </div>
    </section>

    <div id="commandeModal" class="text-black modal" style="display: none;">
        <div class="modal-content">
            <div class="bg-[#966F33] px-4 py-2 w-full h-full flex justify-between">
                <span>Détail de la commande</span>
                <span class="cursor-pointer close">&times;</span>
            </div>
            <div id="modal-body">
                <!-- Contenu du modal sera ajouté ici -->
            </div>
        </div>
    </div>
</x-home>
