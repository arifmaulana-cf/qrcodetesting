@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#f53003] dark:border-[#FF4433] text-start text-base font-medium text-[#f53003] dark:text-[#FF4433] bg-[#f53003]/5 dark:bg-[#FF4433]/5 focus:outline-none focus:border-[#f53003] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:bg-[#19140014] dark:hover:bg-[#3E3E3A]/30 hover:border-[#19140035] dark:hover:border-[#3E3E3A] focus:outline-none transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
