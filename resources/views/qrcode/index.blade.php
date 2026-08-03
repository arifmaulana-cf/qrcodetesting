<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="font-semibold text-xl tracking-tight">
                    QR Code Saya
                </h2>
                <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    Kelola dan pantau semua QR Code Anda.
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
            @if (session('success'))
                <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 text-green-600 dark:text-green-400 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if ($qrCodes->isEmpty())
                <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-16 text-center">
                    <span class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-[#f53003]/10 dark:bg-[#FF4433]/10 text-[#f53003] dark:text-[#FF4433]">
                        <svg class="w-8 h-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 0h6v6h-6v-6z"/></svg>
                    </span>
                    <h3 class="mt-4 text-lg font-semibold tracking-tight">Belum ada QR Code</h3>
                    <p class="mt-1.5 text-sm text-[#706f6c] dark:text-[#A1A09A] max-w-sm mx-auto">
                        Buat QR Code pertama Anda sekarang &mdash; gratis dan hanya butuh beberapa detik.
                    </p>
                    <a href="{{ route('qrcode.create') }}"
                        class="mt-6 inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-5 py-2.5 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                        Buat QR Code Pertama
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($qrCodes as $qr)
                        <div class="group bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
                            <div class="flex justify-center mb-5">
                                @if ($qr->filename)
                                    <a href="{{ route('qrcode.show', $qr) }}" class="block p-3 rounded-xl bg-[#FDFDFC] dark:bg-[#0a0a0a] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.08)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                                        <img src="{{ Storage::url($qr->filename) }}" alt="{{ $qr->title }}" class="max-w-full h-auto" style="max-height: 160px;">
                                    </a>
                                @endif
                            </div>

                            <h3 class="text-lg font-semibold text-center tracking-tight truncate">{{ $qr->title }}</h3>
                            <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-1 truncate text-center">{{ $qr->content }}</p>

                            <div class="mt-4 flex items-center justify-center gap-2">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#f53003]/10 dark:bg-[#FF4433]/10 text-xs font-medium text-[#f53003] dark:text-[#FF4433] uppercase">
                                    {{ $qr->type }}
                                </span>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-[#19140014] dark:bg-[#3E3E3A]/30 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    {{ number_format($qr->scan_count) }} scan
                                </span>
                            </div>

                            <div class="mt-5 pt-4 border-t border-[#19140014] dark:border-[#3E3E3A]/40 flex items-center justify-center gap-1">
                                <a href="{{ route('qrcode.show', $qr) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:bg-[#19140014] dark:hover:bg-[#3E3E3A]/30 transition-colors">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    Lihat
                                </a>
                                <a href="{{ route('qrcode.download', $qr) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:bg-[#19140014] dark:hover:bg-[#3E3E3A]/30 transition-colors">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>
                                    Unduh
                                </a>
                                <a href="{{ route('qrcode.edit', $qr) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] hover:bg-[#19140014] dark:hover:bg-[#3E3E3A]/30 transition-colors">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('qrcode.destroy', $qr) }}" onsubmit="return confirm('Hapus QR Code ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] hover:text-red-600 dark:hover:text-red-400 hover:bg-red-500/10 transition-colors">
                                        <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $qrCodes->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
