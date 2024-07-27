<x-home>
    <section class="flex flex-col gap-5 px-10 mb-12">
        <h1 class="flex items-center gap-5 font-extrabold">
            <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M27.2 27.2C28.1017 27.2 28.9665 27.5582 29.6042 28.1958C30.2418 28.8335 30.6 29.6983 30.6 30.6C30.6 31.5017 30.2418 32.3665 29.6042 33.0042C28.9665 33.6418 28.1017 34 27.2 34C26.2983 34 25.4335 33.6418 24.7958 33.0042C24.1582 32.3665 23.8 31.5017 23.8 30.6C23.8 28.713 25.313 27.2 27.2 27.2ZM0 0H5.559L7.157 3.4H32.3C32.7509 3.4 33.1833 3.57911 33.5021 3.89792C33.8209 4.21673 34 4.64913 34 5.1C34 5.389 33.915 5.678 33.796 5.95L27.71 16.949C27.132 17.986 26.01 18.7 24.735 18.7H12.07L10.54 21.471L10.489 21.675C10.489 21.7877 10.5338 21.8958 10.6135 21.9755C10.6932 22.0552 10.8013 22.1 10.914 22.1H30.6V25.5H10.2C9.29826 25.5 8.43346 25.1418 7.79584 24.5042C7.15821 23.8665 6.8 23.0017 6.8 22.1C6.8 21.505 6.953 20.944 7.208 20.468L9.52 16.303L3.4 3.4H0V0ZM10.2 27.2C11.1017 27.2 11.9665 27.5582 12.6042 28.1958C13.2418 28.8335 13.6 29.6983 13.6 30.6C13.6 31.5017 13.2418 32.3665 12.6042 33.0042C11.9665 33.6418 11.1017 34 10.2 34C9.29826 34 8.43346 33.6418 7.79584 33.0042C7.15821 32.3665 6.8 31.5017 6.8 30.6C6.8 28.713 8.313 27.2 10.2 27.2ZM25.5 15.3L30.226 6.8H8.738L12.75 15.3H25.5Z" fill="#966F33"/>
            </svg>
            <span class="text-3xl">{{ __('Récapitulatif du panier') }}</span>
        </h1>

        <div class="flex flex-col gap-5 px-5">
            @php $total = 0 @endphp
            @if(session('cart'))
                @foreach(session('cart') as $id => $details)
                    @if(isset($products[$id]))
                        @php $total += $details['price'] * $details['quantity'] @endphp
                        <article class="flex justify-between w-full px-4 py-6 border-b border-gray-700" data-id="{{ $id }}">
                            <div>
                                <h2 class="text-xl font-bold">{{ $products[$id]->product_name }}</h2>
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
                    @endif
                @endforeach
                <div class="flex flex-col items-end gap-5">
                    <div class="space-y-2 text-right">
                        <h4 class="text-2xl">{{ __('Sous total:') }} <span class="font-bold">{{ number_format($total / 100 , 2 ) }} €</span></h4>
                        <p class="text-xs">{{ __('En procédant au paiement, j\'accepte les') }} <a href="" class="text-indigo-500">{{ __('Termes') }}</a> {{ __('et la') }} <a href="" class="text-indigo-500">{{ __('Politique de confidentialité') }}</a></p>
                    </div>
                    <form action="{{route('session')}}" method="POST">
                        @csrf
                        <button class="bg-[#966F33] text-3xl font-extrabold px-5 py-3 rounded-2xl" type="submit" id="checkout-live-button">{{ __('Passer au paiement') }}</button>
                    </form>
                </div>
            @else
                <article>
                    <h2 class="text-xl font-bold">{{ __('Vous n\'avez aucuns articles dans le panier') }}</h2>
                </article>
            @endif
        </div>
    </section>





{{--
<table id="cart" class="table table-hover table-condensed">
    <thead>
        <tr>
            <th style="width:50%">Product</th>
            <th style="width:10%">Price</th>
            <th style="width:8%">Quantity</th>
            <th style="width:22%" class="text-center">Subtotal</th>
            <th style="width:10%"></th>
        </tr>
    </thead>
    <tbody>
        @php $total = 0 @endphp
        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                @php $total += $details['price'] * $details['quantity'] @endphp
                <tr data-id="{{ $id }}">
                    <td data-th="Product">
                        <div class="row">
                            <div class="col-sm-3 hidden-xs">
                                <img src="{{ asset('storage') }}/{{ $details['photo'] }}" width="100" height="100" class="img-responsive" />
                            </div>
                            <div class="col-sm-9">
                                <h4 class="nomargin"></h4>
                            </div>
                        </div>
                    </td>
                    <td data-th="Price">{{ $details['price'] }} €</td>
                    <td data-th="Quantity">
                        <input type="number" value="{{ $details['quantity'] }}" class="form-control quantity cart_update" min="1" />
                    </td>
                    <td data-th="Subtotal" class="text-center">
                        ${{ $details['price'] * $details['quantity'] }}
                    </td>
                    <td class="actions" data-th="">
                        <button class="btn btn-danger btn-sm cart_remove"><i class="fa fa-trash-o"></i> Delete</button>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="5" style="text-align:right;">
                <h3><strong>Total ${{ $total }}</strong></h3>
            </td>
        </tr>
        <tr>
            <td colspan="5" style="text-align:right;">
                <form action="/session" method="POST">
                    @csrf
                    <a href="{{ url('/') }}" class="btn btn-danger"> <i class="fa fa-arrow-left"></i> Continue Shopping</a>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="btn btn-success" type="submit" id="checkout-live-button"><i class="fa fa-money"></i> Checkout</button>
                </form>
            </td>
        </tr>
    </tfoot>
</table>

--}}
    <script type="text/javascript">
        $(".cart_update").change(function () {
            $(this).closest("form").submit();
        });

    </script>
</x-home>
