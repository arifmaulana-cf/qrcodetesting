@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-1.5 rounded-lg bg-[#f53003]/10 dark:bg-[#FF4433]/10 text-sm font-semibold text-[#f53003] dark:text-[#FF4433] focus:outline-none transition duration-150 ease-in-out'
            : 'inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:bg-[#19140014] dark:hover:bg-[#3E3E3A]/30 focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
