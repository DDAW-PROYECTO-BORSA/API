@props(['value'])

<label {{ $attributes->merge(['class' => 'dark:text-gray-900 block font-medium text-sm text-gray-700 dark:text-gray-300']) }}>
    {{ $value ?? $slot }}
</label>
