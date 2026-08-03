<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-[#161615] border border-[#19140035] dark:border-[#3E3E3A] rounded-lg font-semibold text-xs text-[#1b1b18] dark:text-[#EDEDEC] uppercase tracking-widest shadow-sm hover:border-[#1915014a] dark:hover:border-[#62605b] focus:outline-none focus:ring-2 focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
