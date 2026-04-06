@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-prowise-softblue mb-1']) }}>
    {{ $value ?? $slot }}
</label>
