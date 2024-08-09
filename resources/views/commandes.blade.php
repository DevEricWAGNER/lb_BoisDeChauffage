<x-home>
    <section class="flex flex-col gap-5 p-5 mb-6 lg:py-0 lg:px-10 lg:mb-12">
        <h1 class="flex items-center gap-5 font-extrabold">
            <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 448 512" fill="none">
                <path d="M50.7 58.5L0 160h208V32L93.7 32C75.5 32 58.9 42.3 50.7 58.5zM240 160h208L397.3 58.5C389.1 42.3 372.5 32 354.3 32H240v128zm208 32H0v224c0 35.3 28.7 64 64 64h320c35.3 0 64-28.7 64-64V192z" fill="#966F33"/>
            </svg>
            <span class="text-lg lg:text-3xl">{{ __('Récapitulatif de vos commandes') }}</span>
        </h1>

        <div class="flex flex-col gap-5 lg:px-5">
            @if($commandes)
                @foreach($commandes as $commande)
                    <article class="flex flex-col justify-between w-full gap-2 px-4 py-6 border-b border-gray-700 lg:flex-row" data-id="{{ $id }}">
                        <div>
                            <h2 class="text-xl font-bold">Commande passée le {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $commande->updated_at)->format('d/m/Y'); }}</h2>
                            <p class="text-sm">{{ $products[$id]->product_description }}</p>
                        </div>
                        <div class="flex gap-5">
                            <div class="flex items-center gap-5">
                                <form action="{{ route('update_cart') }}" method="POST">
                                    @csrf
                                    @method("PATCH")
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="quantity" value="{{ $details['quantity'] }}" class="bg-[#171716] quantity cart_update w-32 border rounded-lg" min="1" />
                                </form>
                                <h3 class="text-lg font-bold">{{ number_format($details['price'] * $details['quantity'] / 100 , 2) }} €</h3>
                            </div>
                            <form action="{{ route('remove_from_cart') }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <input type="hidden" name="id" value="{{ $id }}">
                                <button type="submit" class="px-4 py-2 text-xl bg-red-500 rounded-lg"><i class="fa fa-trash-o"></i></button>
                            </form>
                        </div>
                    </article>
                @endforeach
                <div class="flex flex-col items-end gap-5">
                    <div class="space-y-2 text-right">
                        <p class="text-xs">{{ __('En procédant au paiement, j\'accepte les') }} <a href="" class="text-indigo-500">{{ __('Termes') }}</a> {{ __('et la') }} <a href="" class="text-indigo-500">{{ __('Politique de confidentialité') }}</a></p>
                    </div>
                    <form action="{{route('session')}}" method="POST">
                        @csrf
                        <button class="bg-[#966F33] lg:text-3xl text-lg px-2 py-1 font-extrabold lg:px-5 lg:py-3 rounded-2xl" type="submit" id="checkout-live-button">{{ __('Passer au paiement') }}</button>
                    </form>
                </div>
            @else
                <article>
                    <h2 class="text-xl font-bold">{{ __('Vous n\'avez passer aucunes commandes.') }}</h2>
                </article>
            @endif
        </div>
    </section>
</x-home>
