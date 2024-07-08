<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full bg-[#FF9B25] hover:bg-[#d89800] text-white font-bold py-2 px-4 rounded-lg focus:outline-none focus:shadow-outline']) }}>
    {{ $slot }}
</button>
