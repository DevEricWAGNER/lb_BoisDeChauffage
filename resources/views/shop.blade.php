<x-home>
    <section class="flex flex-col gap-5 px-10 mb-12">
        <div class="flex items-center gap-5">
            <span class="w-6 h-12 bg-[#966F33] rounded-full"></span>
            <p class="text-3xl">Tous les produits</p>
        </div>
        <div class="flex flex-col gap-5">
            <h1 class="text-[#966F33] text-5xl font-extrabold">Explorer nos Produits</h1>
            <div class="grid grid-cols-5 gap-5 mx-auto">
                @foreach ($products as $product)
                    <article class="flex flex-col gap-5 p-5">
                        <div class="w-60 aspect-square relative bg-gradient-to-br from-[#00000000] via-[#00000050] via-[25%] to-[#000000] backdrop-blur-sm rounded-xl overflow-hidden">
                            <img class="absolute top-0 left-0 h-60" src="{{ asset('storage/' . $product->photo) }}" alt="{{ $product->product_name }}">
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-white">{{ $product->product_name }}</h2>
                            {{--<p>{{ $product->product_description }}</p>--}}
                            <div class="flex items-end justify-between w-full">
                                <p class="text-xl font-bold">{{ number_format($product->price / 100, 2) }} €</p>
                                <p class="text-sm underline">{{$product->sales_count}} {{ __('Ventes') }}</p>
                            </div>
                        </div>
                        <form action="{{ route('add_to_cart') }}" method="POST" class="flex justify-between">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <select name="quantity" id="quantity" class="bg-[#171716] rounded-lg">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                            <button type="submit" class="text-[#FF9B25] px-4 py-2 bg-gradient-to-br from-[#272726] to-[#171716] w-fit rounded-xl border solid border-[#F8F8F8]">Ajouter au panier</button>
                        </form>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-home>
