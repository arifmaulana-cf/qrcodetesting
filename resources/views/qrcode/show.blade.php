<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl tracking-tight">
                {{ $qrcode->title }}
            </h2>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Detail dan statistik QR Code Anda.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 px-4 py-3 bg-green-500/10 border border-green-500/30 text-green-600 dark:text-green-400 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl overflow-hidden">
                <div class="p-8">
                    <div class="flex justify-center mb-6">
                        @if ($qrcode->filename)
                            <div class="p-4 rounded-2xl bg-[#FDFDFC] dark:bg-[#0a0a0a] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.08)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                                <img src="{{ Storage::url($qrcode->filename) }}" alt="{{ $qrcode->title }}" class="max-w-full h-auto" style="max-height: 260px;">
                            </div>
                        @endif
                    </div>
                </div>

                <div class="px-8 pb-8">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @php
                            $details = [
                                ['label' => 'Judul', 'value' => $qrcode->title, 'full' => false],
                                ['label' => 'Tipe', 'value' => ucfirst($qrcode->type), 'full' => false],
                                ['label' => 'Isi Konten', 'value' => $qrcode->content, 'full' => true],
                                ['label' => 'Ukuran', 'value' => $qrcode->size . 'px', 'full' => false],
                                ['label' => 'Format', 'value' => strtoupper($qrcode->format), 'full' => false],
                                ['label' => 'Total Scan', 'value' => number_format($qrcode->scan_count), 'full' => false],
                                ['label' => 'Dibuat', 'value' => $qrcode->created_at->format('d M Y, H:i'), 'full' => false],
                            ];
                        @endphp

                        @foreach ($details as $detail)
                            <div class="{{ $detail['full'] ? 'md:col-span-2' : '' }} rounded-xl bg-[#FDFDFC] dark:bg-[#0a0a0a] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.08)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] px-4 py-3">
                                <dt class="text-xs font-medium uppercase tracking-wider text-[#706f6c] dark:text-[#A1A09A]">{{ $detail['label'] }}</dt>
                                <dd class="mt-1 text-sm break-all">{{ $detail['value'] }}</dd>
                            </div>
                        @endforeach
                    </dl>
                </div>

                <div class="px-8 pb-8">
                    <div class="flex flex-wrap gap-3 pt-6 border-t border-[#19140014] dark:border-[#3E3E3A]/40">
                        <a href="{{ route('qrcode.download', $qrcode) }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-5 py-2.5 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/></svg>
                            Unduh
                        </a>
                        <a href="{{ route('qrcode.edit', $qrcode) }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-[#f53003]/10 dark:bg-[#FF4433]/10 px-5 py-2.5 text-sm font-semibold text-[#f53003] dark:text-[#FF4433] hover:bg-[#f53003]/20 dark:hover:bg-[#FF4433]/20 transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            Edit
                        </a>
                        <a href="{{ route('qrcode.index') }}"
                            class="inline-flex items-center gap-2 rounded-lg border border-[#19140035] dark:border-[#3E3E3A] px-5 py-2.5 text-sm font-medium hover:border-[#1915014a] dark:hover:border-[#62605b] transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                            Kembali
                        </a>
                        <form method="POST" action="{{ route('qrcode.destroy', $qrcode) }}" onsubmit="return confirm('Hapus QR Code ini?')" class="ms-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-red-500 transition-colors">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
