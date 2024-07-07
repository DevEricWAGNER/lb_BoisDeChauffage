@props(['active'])

@php
$classes = ($active ?? false)
            ? 'hover:text-[#966F33] hover:underline'
            : 'text-[#966F33] hover:underline hover:text-white';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
