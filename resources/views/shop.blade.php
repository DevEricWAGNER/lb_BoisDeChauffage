<x-home>
    <section class="flex flex-col gap-5 lg:px-10 lg:mb-12">
        <div class="flex items-center gap-2 px-5 lg:gap-5 lg:px-0">
            <span class="lg:w-6 lg:h-12 w-3 h-6 bg-[#966F33] rounded-full"></span>
            <p class="text-lg lg:text-3xl">Tous les produits</p>
        </div>
        <div class="flex flex-col gap-5">
            <h1 class="text-[#966F33] lg:text-5xl text-2xl font-extrabold px-5 lg:px-0">Explorer nos Produits</h1>
            <div class="grid grid-cols-2 gap-2 mx-auto lg:gap-5 lg:grid-cols-5">
                @foreach ($products as $product)
                    <article class="flex flex-col gap-5 p-5">
                        <div class="lg:w-60 w-40 aspect-square relative bg-gradient-to-br from-[#00000000] via-[#00000050] via-[25%] to-[#000000] backdrop-blur-sm rounded-xl overflow-hidden">
                            @if (!empty($product["product"]->images) && isset($product["product"]->images[0]))
                                <img class="absolute top-0 left-0 h-40 lg:h-60" src="{{ $product["product"]->images[0] && strpos($product["product"]->images[0], 'http') === 0 ? $product["product"]->images[0] : asset('storage/' . $product["product"]->images[0]) }}" alt="{{ $product["product"]->name }}">
                            @endif
                        </div>
                        <div>
                            <h2 class="text-sm font-bold text-white lg:text-2xl">{{ $product["product"]->name }}</h2>
                            <p>{{ $product["product"]->description }}</p>
                            <div class="flex items-end justify-between w-full">
                                <p class="text-sm font-bold lg:text-xl">{{ number_format($product["prices"][0]->unit_amount / 100, 2) }} €</p>
                                {{--<p class="text-xs underline lg:text-sm">{{$product->sales_count}} {{ __('Ventes') }}</p>--}}
                            </div>
                        </div>
                        <form action="{{ route('add_to_cart') }}" method="POST" class="flex flex-col justify-between gap-2 lg:flex-row">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="product_id" value="{{ $product["product"]->id }}">
                            <input type="hidden" name="id" value="{{ $product["idBdd"] }}">
                            <select name="quantity" id="quantity" class="bg-[#171716] rounded-lg">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                            <button type="submit" class="text-[#FF9B25] lg:px-4 px-2 lg:py-2 py-1 w-full bg-gradient-to-br from-[#272726] to-[#171716] lg:w-fit rounded-xl border solid border-[#F8F8F8]">Ajouter au panier</button>
                        </form>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-home>
