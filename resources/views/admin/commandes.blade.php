<x-app-layout>
    <x-slot name="title">
        {{$title}}
    </x-slot>
    <section class="flex flex-col gap-5 p-5 mb-6 lg:py-0 lg:px-10 lg:mb-12">
        <h1 class="flex items-center gap-5 font-extrabold">
            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 448 512" fill="none">
                <path d="M50.7 58.5L0 160h208V32L93.7 32C75.5 32 58.9 42.3 50.7 58.5zM240 160h208L397.3 58.5C389.1 42.3 372.5 32 354.3 32H240v128zm208 32H0v224c0 35.3 28.7 64 64 64h320c35.3 0 64-28.7 64-64V192z" fill="#966F33"/>
            </svg>
            <span class="text-lg lg:text-3xl">{{ __('Récapitulatif des commandes') }}</span>
        </h1>

        <div class="flex flex-col gap-5 lg:px-5">
            @if($groupedCommandes)
                @foreach($groupedCommandes as $payment_id => $data)
                    @php
                        $firstCommande = $data['items']->first();
                        $itemCount = $data['items']->count();
                    @endphp
                    <article class="flex flex-col justify-between w-full gap-2 px-4 py-6 border-b border-gray-700 lg:flex-row" data-id="{{ $payment_id }}">
                        <div>
                            <h2 class="text-xl font-bold">Commande passée le {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $firstCommande->updated_at)->format('d/m/Y H:i') }}</h2>
                            <p>Par {{ $firstCommande->user->firstname }} {{ $firstCommande->user->lastname }}</p>
                        </div>
                        <div class="status-selector">
                            @php
                                $statusOptions = [
                                    'complete' => __('Commandé'),
                                    'expedie' => __('Expédié'),
                                    'livraison' => __('Livraison'),
                                    'livre' => __('Livré')
                                ];

                                $currentStatus = $firstCommande->payment_status;
                            @endphp
                            <form action="{{route('admin.changeStatus')}}" method="POST">
                                @csrf
                                @method("POST")
                                <input type="hidden" name="payment_id" value="{{ $payment_id }}">
                                <select id="status-select" class="status-select bg-[#171716]" name="status" onchange="">
                                    @php
                                        foreach ($statusOptions as $status => $label) {
                                            $selected = ($status == $currentStatus) ? 'selected' : '';
                                            echo "<option value=\"$status\" $selected>$label</option>";
                                        }
                                    @endphp
                                </select>
                            </form>
                        </div>
                        <div class="flex items-center gap-5">
                            <h3 class="text-lg font-bold">Nombre d'articles : {{ $itemCount }}</h3>
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

    <script type="text/javascript">
        $(".status-select").change(function () {
            $(this).closest("form").submit();
        });

    </script>
</x-app-layout>
