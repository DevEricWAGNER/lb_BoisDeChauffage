@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold mb-1']) }}>
    {{ $value ?? $slot }}
</label>
