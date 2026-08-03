@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-[#1b1b18] dark:text-[#EDEDEC]']) }}>
    {{ $value ?? $slot }}
</label>
