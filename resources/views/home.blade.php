<x-home>
    <x-slot name="title">
        {{$title}}
    </x-slot>
    <section class="relative px-3 py-5 overflow-hidden lg:px-6 lg:py-52">
        <div class="absolute top-0 left-0 z-0 w-full h-full overflow-hidden opacity-40">
            <div
                class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-[#171716] via-transparent to-[#171716]">
            </div>
            <img src="{{ asset('storage/img/IMG-20240429-WA0005.jpg') }}" alt="" class="w-full">
        </div>
        <div class="relative z-10 flex flex-col gap-10">
            <h1 class="flex flex-col gap-1 text-sm font-bold lg:gap-2 lg:text-6xl">
                <span>Chauffez vous ou cuisinez avec notre</span>
                <span class="lg:text-9xl text-lg text-[#966F33]">
                    Bois de qualité
                </span>
            </h1>
            <a href="{{ route('shop.index') }}"
                class="lg:ml-16 text-[#FF9B25] lg:text-2xl lg:px-20 lg:py-4 px-4 py-2 bg-gradient-to-br from-[#272726] to-[#171716] w-fit rounded-xl border solid border-[#F8F8F8]">
                Tout voir
            </a>
        </div>
    </section>
    <section class="relative w-full px-4 py-2 mt-4 lg:mt-24 lg:py-60 lg:px-44">
        <div class="absolute top-0 left-0 z-0 flex flex-col items-center justify-center w-full h-full overflow-hidden opacity-40">
            <img src="{{ asset('storage/img/IMG-20240429-WA0007.jpg') }}" alt="" class="w-full">
        </div>
        <div class="relative z-10 p-2 text-sm font-semibold text-center bg-white border border-white lg:p-10 lg:text-2xl rounded-xl backdrop-filter backdrop-blur-lg bg-opacity-10">
            <p class="lg:leading-[4rem]">Découvrez notre sélection premium de bois de chauffage français, soigneusement coupé par nos soins pour des dimensions idéales de 25 à 50 cm. Faites confiance à notre savoir-faire pour une chaleur authentique et une livraison rapide dans toute l'Alsace!</p>
        </div>

    </section>
    <section class="lg:h-[30rem] relative flex flex-col justify-evenly items-center lg:gap-10 gap-5 py-5">
        <h1 class="xl:text-[5rem] lg:text-3xl text-lg text-[#966F33] font-bold">Pourquoi acheter chez nous ?</h1>
        <div class="grid grid-cols-3 gap-5 lg:grid-cols-3 lg:gap-16">
            <article class="flex flex-col items-center justify-center gap-1 lg:gap-4">
                <div class="relative flex flex-col items-center justify-center rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#272726] to-[#171716] lg:w-48 w-24 aspect-square">
                    <img src="{{ asset('storage/icons/infos/bois.png') }}" alt="" class="w-10 lg:w-32">
                    <p class="text-[#966F33] lg:text-2xl text-sm font-bold">Prêt à brûler</p>
                </div>
                <p class="text-xs font-bold lg:text-lg">Bois seché</p>
            </article>
            <article class="flex flex-col items-center justify-center gap-1 lg:gap-4">
                <div class="relative flex flex-col items-center justify-center rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#272726] to-[#171716] lg:w-48 w-24  aspect-square">
                    <img src="{{ asset('storage/icons/infos/argent.png') }}" alt="" class="w-10 lg:w-32">
                    <p class="text-[#966F33] lg:text-2xl text-sm font-bold">Facile</p>
                </div>
                <p class="text-xs font-bold lg:text-lg">Paiement facile</p>
            </article>
            <article class="flex flex-col items-center justify-center gap-1 lg:gap-4">
                <div class="relative flex flex-col items-center justify-center rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#272726] to-[#171716] lg:w-48 w-24  aspect-square">
                    <img src="{{ asset('storage/icons/infos/hanshake.png') }}" alt="" class="w-10 lg:w-32">
                    <p class="text-[#966F33] lg:text-2xl text-sm font-bold">50+</p>
                </div>
                <p class="text-xs font-bold lg:text-lg">Clients satisfaits</p>
            </article>
        </div>
    </section>
    <section class="relative w-full h-full">
        <div class="absolute top-0 left-0 z-0 w-full h-full overflow-hidden opacity-40">
            <div
                class="absolute object-bottom top-0 left-0 w-full h-full bg-gradient-to-b from-[#171716] via-[#17171600] to-[#171716]">
            </div>
            <img class="w-full object-cover object-[center_bottom]" src="{{ asset('storage/img/IMG-20240429-WA0006.jpg') }}"
                alt="">
        </div>
        <div id="selloffer" class="lg:h-[42rem] relative flex flex-col justify-evenly items-center lg:gap-10 gap-5 py-5">
            <h1 class="lg:text-7xl text-lg font-bold text-[#966F33] drop-shadow-lg">Nos Produits</h1>
            <div class="flex justify-between gap-5">
                <a href="">
                    <article
                        class="lg:w-48 w-24 aspect-square rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#00000000] via-[#00000050] via-[25%] to-[#000000] backdrop-blur-sm">
                        <img class="w-24 lg:w-48 aspect-square" src="{{ asset('storage/img/product/object.png') }}" alt="">

                    </article>
                </a>
                <a href="#">
                    <article
                        class="lg:w-48 w-24 aspect-square rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#00000000] via-[#00000050] via-[25%] to-[#000000] backdrop-blur-sm">
                        <img class="w-24 lg:w-48 aspect-square" src="{{ asset('storage/img/product/object2.png') }}" alt="">
                    </article>
                </a>
            </div>
            <a class="lg:ml-16 text-[#FF9B25] lg:text-2xl lg:px-20 lg:py-4 px-4 py-2 bg-gradient-to-br from-[#272726] to-[#171716] w-fit rounded-xl border solid border-[#F8F8F8]"
                href="{{ route('shop.index') }}">Voir plus d'articles</a>
        </div>
    </section>
</x-home>
