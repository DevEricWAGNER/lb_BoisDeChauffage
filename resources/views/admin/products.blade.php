<x-app-layout>
    <x-slot name="title">
        {{ $title }}
    </x-slot>



    <section class="flex flex-col gap-5 p-5 mb-6 lg:py-0 lg:px-10 lg:mb-12">
        <div class="flex items-center justify-between">
            <h1 class="flex items-center gap-5 font-extrabold">
                <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 512 512" fill="none">
                    <path d="M0 96C0 60.7 28.7 32 64 32l384 0c35.3 0 64 28.7 64 64l0 320c0 35.3-28.7 64-64 64L64 480c-35.3 0-64-28.7-64-64L0 96zM323.8 202.5c-4.5-6.6-11.9-10.5-19.8-10.5s-15.4 3.9-19.8 10.5l-87 127.6L170.7 297c-4.6-5.7-11.5-9-18.7-9s-14.2 3.3-18.7 9l-64 80c-5.8 7.2-6.9 17.1-2.9 25.4s12.4 13.6 21.6 13.6l96 0 32 0 208 0c8.9 0 17.1-4.9 21.2-12.8s3.6-17.4-1.4-24.7l-120-176zM112 192a48 48 0 1 0 0-96 48 48 0 1 0 0 96z" fill="#966F33"/>
                </svg>
                <span class="text-lg lg:text-3xl">{{ __('Produits') }}</span>
            </h1>
            <button type="button" id="createProductButton" data-modal-target="createProductModal" data-modal-toggle="createProductModal" class="flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-[#966F33] rounded-lg focus:ring-4 focus:ring-[#966F33] focus:outline-none">
                <svg class="h-3.5 w-3.5 mr-1.5 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                Add product
            </button>
        </div>

        @if($products)
            <div class="flex flex-col lg:px-5">
                <div class="flex flex-col items-center justify-between w-full gap-2 px-4 py-1 border-b border-gray-700 lg:flex-row">
                    <div class="flex items-center w-1/4 gap-2">
                        {{ __('Produits') }}
                    </div>
                    <div class="bg-[#171716] w-1/4 text-center">{{ __('Prix') }}</div>
                    <div class="flex items-center w-1/4 gap-5">
                        <div class="flex items-center justify-center">
                            {{ __('Ventes') }}
                        </div>
                    </div>
                    <div class="w-1/4 px-4 py-3 font-medium text-white whitespace-nowrap text-end">
                        {{ __('Actions') }}
                    </div>
                </div>

                @foreach ($products as $product)
                    <article class="flex flex-col items-center justify-between w-full gap-2 px-4 py-3 border-b border-gray-700 lg:flex-row">
                        <div class="flex items-center w-1/4 gap-2">
                            @if (!empty($product["product"]->images) && isset($product["product"]->images[0]))
                                <img loading="lazy" src="{{ $product["product"]->images[0] && strpos($product["product"]->images[0], 'http') === 0 ? $product["product"]->images[0] : asset('storage/' . $product["product"]->images[0]) }}" alt="{{ $product["product"]->name }}" class="w-auto h-8 mr-3">
                            @endif
                            {{ $product["product"]->name }}
                        </div>
                        <div class="bg-[#171716] w-1/4 text-center">
                            <span class="text-xs font-medium px-2 py-0.5 rounded bg-[#966F33] text-white">
                                {{ number_format($product["prices"][0]->unit_amount / 100, 2) }}&nbsp;€
                            </span>
                        </div>
                        <div class="flex items-center w-1/4 gap-5">
                            <div class="flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 24 24" fill="currentColor" class="w-5 h-5 mr-2 text-gray-400" aria-hidden="true">
                                    <path d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z" />
                                </svg>
                                @if ($product['sales_count'] >= 1000000)
                                    {{ number_format($product['sales_count'] / 1000000, 1) }}M
                                @elseif ($product['sales_count'] >= 1000)
                                    {{ number_format($product['sales_count'] / 1000, 1) }}k
                                @else
                                    {{ $product['sales_count'] }}
                                @endif
                            </div>
                        </div>
                        <div class="w-1/4 px-4 py-3 font-medium text-white whitespace-nowrap">
                            <div class="flex items-center justify-end space-x-4">
                                <button type="button" data-drawer-target="drawer-update-product-{{$product['idBdd']}}" data-drawer-show="drawer-update-product-{{$product['idBdd']}}" aria-controls="drawer-update-product-{{$product['idBdd']}}" class="flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-0.5" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                        <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                                    </svg>
                                    Modifier
                                </button>
                                <button type="button" data-modal-target="delete-modal-{{$product['idBdd']}}" data-modal-toggle="delete-modal-{{$product['idBdd']}}" class="flex items-center px-3 py-2 text-sm font-medium text-center text-red-700 border border-red-700 rounded-lg hover:text-white hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 -ml-0.5" viewbox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="flex flex-col gap-5 lg:px-5">
                <div class="flex flex-col items-center justify-between w-full gap-2 px-4 py-3 border-b border-gray-700 lg:flex-row">
                    {{ __('Vous n\'avez pas de commandes pour l\'instant.') }}
                </div>
            </div>
        @endif
    </section>

<div id="createProductModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] md:h-full">
    <div class="relative w-full h-full max-w-3xl p-4 md:h-auto">
        <!-- Modal content -->
        <div class="relative p-4 bg-gray-800 rounded-lg shadow sm:p-5">
            <!-- Modal header -->
            <div class="flex items-center justify-between pb-4 mb-4 border-b rounded-t sm:mb-5 dark:border-gray-600">
                <h3 class="text-lg font-semibold text-white">Ajouter un produit</h3>
                <button type="button" class="bg-transparent rounded-lg text-sm p-1.5 ml-auto inline-flex items-center hover:bg-gray-600 hover:text-white" data-modal-toggle="createProductModal">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form action="{{ route('createProducts') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method("POST")
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-white">Nom du produit</label>
                        <input type="text" name="name" id="name" class="text-white border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500" placeholder="Ecrivez le nom de l'article" required="">
                    </div>
                    <div>
                        <label for="price" class="block mb-2 text-sm font-medium text-white">Prix</label>
                        <input type="text" name="price" id="price" class="text-white border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500" placeholder="29.99 €" required="">
                    </div>
                    <div class="sm:col-span-2"><label for="description" class="block mb-2 text-sm font-medium text-white">Description</label><textarea id="description" name="description" rows="4" class="text-white border text-sm rounded-lg block w-full p-2.5 bg-gray-700 border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500" placeholder="Ecrivez la description de l'article"></textarea></div>
                </div>
                <div class="mb-4 flex items-start gap-4">
                    <!-- Colonne 1 : Zone de téléchargement -->
                    <div class="flex-1">
                        <span class="block mb-2 text-sm font-medium text-white">Image du produit</span>
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 bg-gray-700 border-2 border-gray-600 border-dashed rounded-lg cursor-pointer hover:bg-bray-800 hover:border-gray-500 hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-semibold">Click to upload</span>
                                    or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" accept="image/*" name="image">
                        </label>
                    </div>

                    <!-- Colonne 2 : Aperçu -->
                    <div class="flex-1">
                        <span class="block mb-2 text-sm font-medium text-white">Aperçu de l'image</span>
                        <div id="preview-container" class="w-full h-64 bg-gray-700 border-2 border-gray-600 rounded-lg flex items-center justify-center">
                            <p class="text-sm text-gray-500 dark:text-gray-400" id="placeholder-text">Aucune image sélectionnée</p>
                            <img id="image-preview" src="#" alt="Aperçu de l'image" class="hidden w-full h-full object-contain rounded-lg">
                        </div>
                    </div>
                </div>
                <div class="items-center space-y-4 sm:flex sm:space-y-0 sm:space-x-4">
                    <button type="submit" class="w-full sm:w-auto justify-center text-white inline-flex bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Créer</button>
                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="createProductModal">
                        <svg class="w-5 h-5 mr-1 -ml-1" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                        Annuler
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- drawer component -->
@foreach ($products as $product)
    <form action="{{route('admin.products.edit', $product['idBdd'])}}" method="post" id="drawer-update-product-{{$product['idBdd']}}" class="fixed top-0 left-0 z-40 w-full h-screen max-w-3xl p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-update-product-label" aria-hidden="true">
        @csrf
        @method("POST")
        <h5 id="drawer-label" class="inline-flex items-center mb-6 text-sm font-semibold text-gray-500 uppercase dark:text-gray-400">Modifier le produit</h5>
        <button type="button" data-drawer-dismiss="drawer-update-product-{{$product['idBdd']}}" aria-controls="drawer-update-product-{{$product['idBdd']}}" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        <div class="grid gap-4 sm:grid-cols-3 sm:gap-6 mb-4">
            <div class="space-y-4 sm:col-span-2 sm:space-y-6">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nom du produit</label>
                    <input type="text" name="product_name" id="updateName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Type product name" required="" value="{{ $product["product"]->name }}">
                </div>
            </div>
            <div class="space-y-4 sm:space-y-6">
                <div>
                    <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Prix</label>
                    <input type="text" name="price" id="updatePrice" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Prix" required="" value="{{ number_format($product["prices"][0]->unit_amount / 100, 2) }}">
                </div>
            </div>
        </div>
        <div class="mb-4">
            <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
            <div class="w-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                <textarea id="updateDescription" name="product_description" rows="8" class="block w-full p-2 text-sm text-gray-800 bg-white rounded-md border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400" placeholder="Write product description here" required="">{{ $product["product"]->description }}</textarea>
            </div>
        </div>
        <div class="mb-4">
            <span class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Product Image</span>
            <div class="relative p-2 bg-gray-100 rounded-lg dark:bg-gray-700 aspect-square">
                @if (!empty($product["product"]->images) && isset($product["product"]->images[0]))
                    <img loading="lazy" src="{{ $product["product"]->images[0] && strpos($product["product"]->images[0], 'http') === 0 ? $product["product"]->images[0] : asset('storage/' . $product["product"]->images[0]) }}" alt="{{ $product["product"]->name }}" class="w-full h-full object-cover rounded-lg">
                @endif
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4 mt-6 sm:w-1/2">
            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update product</button>
        </div>
    </form>
    <!-- Delete Modal -->
    <form action="{{ route('admin.products.delete', $product['idBdd']) }}" method="post" id="delete-modal-{{$product['idBdd']}}" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        @csrf
        @method("DELETE")
        <div class="relative w-full h-auto max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-toggle="delete-modal-{{$product['idBdd']}}">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
                <div class="p-6 text-center">
                    <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewbox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3>
                    <button data-modal-toggle="delete-modal-{{$product['idBdd']}}" type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">Yes, I'm sure</button>
                    <button data-modal-toggle="delete-modal-{{$product['idBdd']}}" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
                </div>
            </div>
        </div>
    </form>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalButton = document.getElementById('createProductButton');
        const modal = document.getElementById('createProductModal');

        if (modalButton && modal) {
            modalButton.addEventListener('click', function() {
                modal.classList.remove('hidden');
                modal.setAttribute('aria-hidden', 'false');
            });

            // Fermer le modal lorsqu'on clique en dehors
            modal.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                }
            });

            // Fermer le modal avec le bouton de fermeture
            const closeButton = modal.querySelector('[data-modal-hide="createProductModal"]');
            if (closeButton) {
                closeButton.addEventListener('click', function() {
                    modal.classList.add('hidden');
                    modal.setAttribute('aria-hidden', 'true');
                });
            }
        }
    });


    const fileInput = document.getElementById('dropzone-file');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');
    const placeholderText = document.getElementById('placeholder-text');

    fileInput.addEventListener('change', (event) => {
        const file = event.target.files[0]; // Récupère le fichier sélectionné
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result; // Définit la source de l'image
                imagePreview.classList.remove('hidden'); // Affiche l'image
                placeholderText.classList.add('hidden'); // Masque le texte de placeholder
            };
            reader.readAsDataURL(file); // Lit le fichier comme URL de données
        }
    });

</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
</x-app-layout>
