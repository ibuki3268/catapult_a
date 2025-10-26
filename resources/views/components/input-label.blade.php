@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-sm font-semibold mb-2 text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>