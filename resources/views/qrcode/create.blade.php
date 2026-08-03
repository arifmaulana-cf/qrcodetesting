<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl tracking-tight">
                Buat QR Code
            </h2>
            <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                Ubah data apa pun menjadi QR Code dalam hitungan detik.
            </p>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-8">
                <form method="POST" action="{{ route('qrcode.store') }}">
                    @csrf

                    <div class="mb-5">
                        <label for="title" class="block text-sm font-medium">Judul</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="Contoh: Menu Restoran"
                            class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">
                        @error('title') <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-5">
                        <label for="type" class="block text-sm font-medium">Tipe Konten</label>
                        <select name="type" id="type" required
                            class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">
                            <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>Teks</option>
                            <option value="url" {{ old('type') === 'url' ? 'selected' : '' }}>URL / Tautan</option>
                            <option value="email" {{ old('type') === 'email' ? 'selected' : '' }}>Email</option>
                            <option value="phone" {{ old('type') === 'phone' ? 'selected' : '' }}>Telepon</option>
                            <option value="sms" {{ old('type') === 'sms' ? 'selected' : '' }}>SMS</option>
                        </select>
                    </div>

                    <div class="mb-5">
                        <label for="content" class="block text-sm font-medium">Isi Konten</label>
                        <textarea name="content" id="content" rows="4" required placeholder="Masukkan data yang akan diubah menjadi QR Code"
                            class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">{{ old('content') }}</textarea>
                        <p id="content-hint" class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1.5">Masukkan data yang akan dikodekan ke dalam QR Code</p>
                        @error('content') <p class="text-red-500 dark:text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        <div>
                            <label for="foreground_color" class="block text-sm font-medium">Warna Depan</label>
                            <input type="color" name="foreground_color" id="foreground_color" value="{{ old('foreground_color', '#000000') }}"
                                class="mt-1.5 block w-full h-11 rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25 cursor-pointer">
                        </div>
                        <div>
                            <label for="background_color" class="block text-sm font-medium">Warna Latar</label>
                            <input type="color" name="background_color" id="background_color" value="{{ old('background_color', '#ffffff') }}"
                                class="mt-1.5 block w-full h-11 rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25 cursor-pointer">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
                        <div>
                            <label for="size" class="block text-sm font-medium">Ukuran (px)</label>
                            <input type="number" name="size" id="size" value="{{ old('size', 300) }}" min="100" max="1000" required
                                class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">
                        </div>
                        <div>
                            <label for="format" class="block text-sm font-medium">Format</label>
                            <select name="format" id="format" required
                                class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">
                                <option value="png" {{ old('format') === 'png' ? 'selected' : '' }}>PNG</option>
                                <option value="svg" {{ old('format') === 'svg' ? 'selected' : '' }}>SVG</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-5 border-t border-[#19140014] dark:border-[#3E3E3A]/40">
                        <button type="submit"
                            class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-5 py-2.5 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                            Buat QR Code
                        </button>
                        <a href="{{ route('qrcode.index') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('type').addEventListener('change', function() {
            const hint = document.getElementById('content-hint');
            switch(this.value) {
                case 'url': hint.textContent = 'Masukkan URL lengkap (contoh: https://contoh.com)'; break;
                case 'email': hint.textContent = 'Masukkan alamat email'; break;
                case 'phone': hint.textContent = 'Masukkan nomor telepon (contoh: +628123456789)'; break;
                case 'sms': hint.textContent = 'Masukkan nomor SMS (contoh: +628123456789)'; break;
                default: hint.textContent = 'Masukkan data yang akan dikodekan ke dalam QR Code';
            }
        });
    </script>
    @endpush
</x-app-layout>
