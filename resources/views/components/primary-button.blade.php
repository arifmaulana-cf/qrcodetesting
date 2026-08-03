<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-[#1b1b18] dark:bg-[#EDEDEC] border border-transparent rounded-lg font-semibold text-xs text-white dark:text-[#1b1b18] uppercase tracking-widest hover:bg-black dark:hover:bg-white active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-[#1b1b18]/30 dark:focus:ring-[#EDEDEC]/40 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
