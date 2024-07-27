@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block p-4 text-sm font-semibold rounded text-black hover:text-[#966F33] hover:underline'
            : 'block p-4 text-sm font-semibold rounded text-[#966F33] hover:underline hover:text-black';
@endphp
<li class="mb-1">
    <a {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
</li>
