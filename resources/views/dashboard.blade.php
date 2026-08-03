<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-xl font-semibold tracking-tight">
                    Halo, {{ Auth::user()->name }}!
                </h2>
                <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    Berikut ringkasan QR Code Anda.
                </p>
            </div>
            <a href="{{ route('qrcode.create') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-4 py-2 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                Buat QR Code
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                @php
                    $stats = [
                        ['label' => 'Total QR Codes', 'value' => $totalQrCodes, 'icon' => '<path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 0h6v6h-6v-6z" fill="currentColor"/><path d="M10.5 3.5h3v3h-3v-3zm0 14h3v3h-3v-3zM3.5 10.5h3v3h-3v-3zm14 0h3v3h-3v-3z" fill="currentColor"/>', 'accent' => 'bg-[#f53003]/10 dark:bg-[#FF4433]/10 text-[#f53003] dark:text-[#FF4433]'],
                        ['label' => 'Total Scan', 'value' => $totalScans, 'icon' => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>', 'accent' => 'bg-[#FF750F]/10 text-[#FF750F]'],
                        ['label' => 'Dibuat Minggu Ini', 'value' => $recentQrCodes, 'icon' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/>', 'accent' => 'bg-green-500/10 text-green-600 dark:text-green-400'],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-6 flex items-center gap-5">
                        <span class="flex items-center justify-center w-12 h-12 rounded-xl shrink-0 {{ $stat['accent'] }}">
                            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $stat['icon'] !!}</svg>
                        </span>
                        <div>
                            <div class="text-3xl font-semibold tracking-tight">{{ number_format($stat['value']) }}</div>
                            <div class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-0.5">{{ $stat['label'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-5">
                <div class="lg:col-span-2 bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-6">
                    <h3 class="text-lg font-semibold tracking-tight">Aksi Cepat</h3>
                    <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        Buat dan kelola QR Code untuk tautan, teks, email, dan lainnya.
                    </p>
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('qrcode.create') }}" class="group rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-5 hover:border-[#f53003]/40 dark:hover:border-[#FF4433]/40 hover:bg-[#f53003]/5 dark:hover:bg-[#FF4433]/5 transition-colors">
                            <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] group-hover:bg-[#f53003] dark:group-hover:bg-[#FF4433] transition-colors">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                            </span>
                            <span class="block mt-3 font-semibold text-sm">Buat QR Code Baru</span>
                            <span class="block mt-0.5 text-xs text-[#706f6c] dark:text-[#A1A09A]">Ubah data apa pun menjadi QR Code</span>
                        </a>
                        <a href="{{ route('qrcode.index') }}" class="group rounded-xl border border-[#19140035] dark:border-[#3E3E3A] p-5 hover:border-[#f53003]/40 dark:hover:border-[#FF4433]/40 hover:bg-[#f53003]/5 dark:hover:bg-[#FF4433]/5 transition-colors">
                            <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18] group-hover:bg-[#f53003] dark:group-hover:bg-[#FF4433] transition-colors">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h7v7H3V3z"/><path d="M14 3h7v7h-7V3z"/><path d="M3 14h7v7H3v-7z"/><path d="M14 14h7v7h-7v-7z"/></svg>
                            </span>
                            <span class="block mt-3 font-semibold text-sm">Kelola QR Code</span>
                            <span class="block mt-0.5 text-xs text-[#706f6c] dark:text-[#A1A09A]">Lihat, edit, dan pantau semua QR Code</span>
                        </a>
                    </div>
                </div>

                <div class="bg-[#1b1b18] dark:bg-[#161615] text-white dark:text-[#EDEDEC] rounded-2xl p-6 shadow-[inset_0px_0px_0px_1px_rgba(255,250,237,0.1)] relative overflow-hidden">
                    <div class="absolute -top-16 -right-16 w-48 h-48 rounded-full bg-[#FF4433]/20 blur-2xl pointer-events-none"></div>
                    <div class="relative">
                        <span class="inline-flex items-center gap-2 rounded-full bg-[#EDEDEC]/10 px-3 py-1 text-xs font-medium">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#FF4433]"></span>
                            Pro Tip
                        </span>
                        <h3 class="mt-4 text-lg font-semibold tracking-tight">Gunakan QR dinamis</h3>
                        <p class="mt-2 text-sm text-[#A1A09A] leading-relaxed">
                            Pantau performa setiap QR Code Anda dan lihat berapa kali dipindai pengunjung.
                        </p>
                        <a href="{{ route('qrcode.index') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-[#FF4433] hover:opacity-80 transition-opacity">
                            Lihat Semua QR Code
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
