<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl tracking-tight">
                Alat PDF
            </h2>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Pilih alat untuk mengelola file PDF Anda. Gratis tanpa batas.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach ($tools as $key => $tool)
                    <a href="{{ route('pdf-tools.show', $key) }}" class="group bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
                        <span class="flex items-center justify-center w-12 h-12 rounded-xl bg-[#f53003]/10 dark:bg-[#FF4433]/10 text-[#f53003] dark:text-[#FF4433] group-hover:bg-[#1b1b18] group-hover:text-white dark:group-hover:bg-[#EDEDEC] dark:group-hover:text-[#1b1b18] transition-colors">
                            @include('pdf-tools.partials.icon', ['key' => $key])
                        </span>
                        <h3 class="mt-4 font-semibold tracking-tight">{{ $tool['label'] }}</h3>
                        <p class="mt-1.5 text-sm text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">{{ $tool['description'] }}</p>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-[#f53003] dark:text-[#FF4433] group-hover:opacity-80 transition-opacity">
                            Gunakan alat ini
                            <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
