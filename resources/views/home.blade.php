<x-home>
    <section class="relative px-6 overflow-hidden py-52">
        <div class="absolute top-0 left-0 z-0 w-full h-full overflow-hidden opacity-40">
            <div
                class="absolute top-0 left-0 w-full h-full bg-gradient-to-b from-[#171716] via-transparent to-[#171716]">
            </div>
            <img src="{{ asset('storage/img/IMG-20240429-WA0005.jpg') }}" alt="" class="w-full">
        </div>
        <div class="relative z-10 flex flex-col gap-10">
            <h1 class="flex flex-col gap-2 text-6xl font-bold">
                <span>Chauffez vous ou cuisinez avec notre</span>
                <span class="text-9xl text-[#966F33]">
                    Bois de qualité
                </span>
            </h1>
            <a href=""
                class="ml-16 text-[#FF9B25] text-2xl px-20 py-4 bg-gradient-to-br from-[#272726] to-[#171716] w-fit rounded-xl border solid border-[#F8F8F8]">
                Tout voir
            </a>
        </div>
    </section>
    <section class="relative w-full mt-24 py-60 px-44">
        <div class="absolute top-0 left-0 z-0 flex flex-col items-center justify-center w-full h-full overflow-hidden opacity-40">
            <img src="{{ asset('storage/img/IMG-20240429-WA0007.jpg') }}" alt="" class="w-full">
        </div>
        <div class="relative z-10 p-10 text-2xl font-semibold text-center bg-white border border-white rounded-xl backdrop-filter backdrop-blur-lg bg-opacity-10">
            <p class="leading-[4rem]">Découvrez notre sélection premium de bois de chauffage français, soigneusement coupé par nos soins pour des dimensions idéales de 25 à 50 cm. Faites confiance à notre savoir-faire pour une chaleur authentique et une livraison rapide dans toute l'Alsace!</p>
        </div>

    </section>
    <section class="flex flex-col items-center justify-center w-full gap-16 mt-24">
        <h1 class="text-[5rem] text-[#966F33] font-bold">Pourquoi acheter chez nous ?</h1>
        <div class="grid grid-cols-3 gap-16">
            <article class="flex flex-col items-center justify-center gap-4">
                <div class="relative flex flex-col items-center justify-center rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#272726] to-[#171716] w-48 aspect-square">
                    <img src="{{ asset('storage/icons/infos/bois.png') }}" alt="" class="w-32">
                    <p class="text-[#966F33] text-2xl font-bold">Prêt à brûler</p>
                </div>
                <p class="font-bold">Bois seché</p>
            </article>
            <article class="flex flex-col items-center justify-center gap-4">
                <div class="relative flex flex-col items-center justify-center rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#272726] to-[#171716] w-48 aspect-square">
                    <img src="{{ asset('storage/icons/infos/argent.png') }}" alt="" class="w-32">
                    <p class="text-[#966F33] text-2xl font-bold">Facile</p>
                </div>
                <p class="font-bold">Paiement facile</p>
            </article>
            <article class="flex flex-col items-center justify-center gap-4">
                <div class="relative flex flex-col items-center justify-center rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#272726] to-[#171716] w-48 aspect-square">
                    <img src="{{ asset('storage/icons/infos/hanshake.png') }}" alt="" class="w-32">
                    <p class="text-[#966F33] text-2xl font-bold">50+</p>
                </div>
                <p class="font-bold">Clients satisfaits</p>
            </article>
        </div>
    </section>
    <section class="relative w-full h-full mt-[12rem]">
        <div class="absolute top-0 left-0 z-0 w-full h-full overflow-hidden opacity-40">
            <div
                class="absolute object-bottom top-0 left-0 w-full h-full bg-gradient-to-b from-[#171716] via-[#17171600] to-[#171716]">
            </div>
            <img class="w-full object-cover object-[center_bottom]" src="./assets/img/IMG-20240429-WA0006.jpg"
                alt="" class="w-full">
        </div>
        <div id="selloffer" class="h-[42rem] relative flex flex-col justify-evenly items-center gap-10">
            <h1 class="text-7xl font-bold text-[#966F33] drop-shadow-lg">Nos Produits</h1>
            <div class="flex w-[30rem] justify-between">
                <a href="#">
                    <article
                        class="w-[13.125rem] h-[13.125rem] rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#00000000] via-[#00000050] via-[25%] to-[#000000] backdrop-blur-sm">
                        <img class="w-[13.125rem] h-[13.125rem]" src="./assets/img/product/object.png" alt="">

                    </article>
                </a>
                <a href="#">
                    <article
                        class="w-[13.125rem] h-[13.125rem] rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#00000000] via-[#00000050] via-[25%] to-[#000000] backdrop-blur-sm">
                        <img class="w-[13.125rem] h-[13.125rem]" src="./assets/img/product/object2.png" alt="">
                    </article>
                </a>
            </div>
            <a class="text-[#FF9B25] w-[23.813rem] h-[4.5rem] text-3xl text-center flex items-center justify-center rounded-xl border solid border-[#F8F8F8] bg-gradient-to-br from-[#00000000] via-[#00000050] via-[25%] to-[#000000] backdrop-blur-sm"
                href="#">Voir plus d'articles</a>
        </div>
    </section>
</x-home>
