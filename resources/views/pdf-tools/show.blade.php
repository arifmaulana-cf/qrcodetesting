<x-app-layout>
    <x-slot name="header">
        <div>
            <div class="flex items-center gap-3">
                <span class="flex items-center justify-center w-10 h-10 rounded-xl bg-[#f53003]/10 dark:bg-[#FF4433]/10 text-[#f53003] dark:text-[#FF4433]">
                    @include('pdf-tools.partials.icon', ['key' => $key])
                </span>
                <div>
                    <h2 class="font-semibold text-xl tracking-tight">
                        {{ $tool['label'] }}
                    </h2>
                    <p class="mt-0.5 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        {{ $tool['description'] }}
                    </p>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="mb-6 px-4 py-3 bg-red-500/10 border border-red-500/30 text-red-600 dark:text-red-400 rounded-xl text-sm">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-8">
                <form method="POST" action="{{ route('pdf-tools.process', $key) }}" enctype="multipart/form-data"
                    x-data="{
                        multiple: {{ $tool['multiple'] ? 'true' : 'false' }},
                        files: [],
                        dragging: false,
                        submitting: false,
                        addFiles(list) {
                            for (const file of list) {
                                if (!this.multiple) { this.files = [file]; continue; }
                                if (!this.files.some(f => f.name === file.name)) this.files.push(file);
                            }
                        },
                        removeFile(i) { this.files.splice(i, 1); },
                        formatSize(bytes) {
                            if (bytes >= 1048576) return (bytes / 1048576).toFixed(1) + ' MB';
                            return Math.round(bytes / 1024) + ' KB';
                        }
                    }"
                    @submit="submitting = true">
                    @csrf

                    {{-- Dropzone --}}
                    <div class="relative"
                        @click="$refs.input.click()"
                        @dragover.prevent="dragging = true"
                        @dragleave.prevent="dragging = false"
                        @drop.prevent="dragging = false; addFiles($event.dataTransfer.files)"
                        :class="dragging ? 'border-[#f53003] dark:border-[#FF4433] bg-[#f53003]/5 dark:bg-[#FF4433]/5' : 'border-dashed border-[#19140035] dark:border-[#3E3E3A]'"
                        class="cursor-pointer rounded-2xl border-2 transition-colors p-10 text-center">
                        <input type="file" x-ref="input" class="hidden"
                            :name="multiple ? 'files[]' : 'file'"
                            :multiple="multiple"
                            accept="{{ $tool['accept'] }}"
                            @change="addFiles($refs.input.files)">

                        <template x-if="files.length === 0">
                            <div>
                                <span class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-[#f53003]/10 dark:bg-[#FF4433]/10 text-[#f53003] dark:text-[#FF4433]">
                                    <svg class="w-7 h-7" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M17 8l-5-5-5 5"/><path d="M12 3v12"/></svg>
                                </span>
                                <p class="mt-4 font-semibold">Tarik &amp; letakkan file di sini</p>
                                <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                    atau <span class="font-semibold text-[#f53003] dark:text-[#FF4433]">klik untuk memilih</span>
                                </p>
                                <p class="mt-3 text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                    Format: {{ trim($tool['accept'], '.') }} &mdash; maksimal 10MB per file
                                </p>
                            </div>
                        </template>

                        <template x-if="files.length > 0">
                            <div @click.stop>
                                <div class="space-y-2 text-start max-h-56 overflow-y-auto">
                                    <template x-for="(file, i) in files" :key="i">
                                        <div class="flex items-center gap-3 rounded-xl border border-[#19140014] dark:border-[#3E3E3A]/50 bg-[#FDFDFC] dark:bg-[#0a0a0a] px-4 py-2.5">
                                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#f53003]/10 dark:bg-[#FF4433]/10 text-[#f53003] dark:text-[#FF4433] shrink-0">
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                                            </span>
                                            <span class="flex-1 min-w-0">
                                                <span class="block text-sm font-medium truncate" x-text="file.name"></span>
                                                <span class="block text-xs text-[#706f6c] dark:text-[#A1A09A]" x-text="formatSize(file.size)"></span>
                                            </span>
                                            <button type="button" @click="removeFile(i)" class="text-[#706f6c] dark:text-[#A1A09A] hover:text-red-600 dark:hover:text-red-400 transition-colors" aria-label="Hapus file">
                                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6L6 18M6 6l12 12"/></svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <p class="mt-3 text-xs text-[#706f6c] dark:text-[#A1A09A] text-center" x-text="multiple ? 'Klik untuk menambah file lain' : 'Klik untuk mengganti file'"></p>
                            </div>
                        </template>
                    </div>

                    {{-- Per-tool options --}}
                    @if ($key === 'split')
                        <div class="mt-6">
                            <label for="pages" class="block text-sm font-medium">Halaman yang diekstrak</label>
                            <input type="text" name="pages" id="pages" value="{{ old('pages') }}" required placeholder="Contoh: 1-3, 5, 8"
                                class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">
                            <p class="mt-1.5 text-xs text-[#706f6c] dark:text-[#A1A09A]">Gunakan koma untuk memisahkan halaman, tanda hubung untuk rentang.</p>
                        </div>
                    @endif

                    @if ($key === 'compress')
                        <div class="mt-6">
                            <label for="quality" class="block text-sm font-medium">Level Kompresi</label>
                            <select name="quality" id="quality" required
                                class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">
                                <option value="ebook" {{ old('quality') === 'ebook' ? 'selected' : '' }}>Sedang (disarankan)</option>
                                <option value="screen" {{ old('quality') === 'screen' ? 'selected' : '' }}>Ringan (ukuran terkecil)</option>
                                <option value="printer" {{ old('quality') === 'printer' ? 'selected' : '' }}>Optimal (kualitas terbaik)</option>
                            </select>
                        </div>
                    @endif

                    @if ($key === 'pdf-to-images')
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="format" class="block text-sm font-medium">Format Gambar</label>
                                <select name="format" id="format" required
                                    class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">
                                    <option value="jpg" {{ old('format') === 'jpg' ? 'selected' : '' }}>JPG</option>
                                    <option value="png" {{ old('format') === 'png' ? 'selected' : '' }}>PNG</option>
                                </select>
                            </div>
                            <div>
                                <label for="resolution" class="block text-sm font-medium">Resolusi (DPI)</label>
                                <select name="resolution" id="resolution" required
                                    class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">
                                    <option value="96" {{ old('resolution') === '96' ? 'selected' : '' }}>96 DPI (kecil)</option>
                                    <option value="150" {{ old('resolution') === '150' ? 'selected' : '' }}>150 DPI (sedang)</option>
                                    <option value="300" {{ old('resolution') === '300' ? 'selected' : '' }}>300 DPI (tinggi)</option>
                                </select>
                            </div>
                        </div>
                    @endif

                    @if ($key === 'images-to-pdf')
                        <div class="mt-6">
                            <label for="orientation" class="block text-sm font-medium">Orientasi Halaman</label>
                            <select name="orientation" id="orientation" required
                                class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">
                                <option value="auto" {{ old('orientation') === 'auto' ? 'selected' : '' }}>Otomatis (sesuai gambar)</option>
                                <option value="landscape" {{ old('orientation') === 'landscape' ? 'selected' : '' }}>Landscape</option>
                            </select>
                        </div>
                    @endif

                    @if ($key === 'rotate')
                        <div class="mt-6">
                            <label for="angle" class="block text-sm font-medium">Sudut Putar</label>
                            <select name="angle" id="angle" required
                                class="mt-1.5 block w-full rounded-lg border-[#19140035] dark:border-[#3E3E3A] dark:bg-[#161615] dark:text-[#EDEDEC] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25">
                                <option value="90" {{ old('angle') === '90' ? 'selected' : '' }}>90 derajat</option>
                                <option value="180" {{ old('angle') === '180' ? 'selected' : '' }}>180 derajat</option>
                                <option value="270" {{ old('angle') === '270' ? 'selected' : '' }}>270 derajat</option>
                            </select>
                        </div>
                    @endif

                    {{-- Actions --}}
                    <div class="flex items-center gap-4 mt-8 pt-6 border-t border-[#19140014] dark:border-[#3E3E3A]/40">
                        <button type="submit" :disabled="files.length === 0 || submitting"
                            class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-6 py-2.5 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                            <template x-if="!submitting">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                            </template>
                            <template x-if="submitting">
                                <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                            </template>
                            <span x-text="submitting ? 'Memproses file Anda...' : 'Proses Sekarang'"></span>
                        </button>
                        <a href="{{ route('pdf-tools.index') }}" class="text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors">Semua Alat</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
