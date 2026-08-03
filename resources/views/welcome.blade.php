<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }} &mdash; Buat QR Code Gratis</title>
        <meta name="description" content="Buat QR Code berkualitas tinggi untuk teks, tautan, email, telepon, dan SMS secara gratis. Pantau jumlah scan dalam satu tempat.">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles / Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-[#1b1b18] dark:text-[#EDEDEC] antialiased bg-[#FDFDFC] dark:bg-[#0a0a0a]">
        {{-- Header --}}
        <header class="sticky top-0 z-40 bg-[#FDFDFC]/80 dark:bg-[#0a0a0a]/80 backdrop-blur border-b border-[#19140014] dark:border-[#3E3E3A]/40">
            <nav class="max-w-6xl mx-auto flex items-center justify-between px-6 py-4">
                <a href="/" class="inline-flex items-center gap-2.5">
                    <span class="flex items-center justify-center w-9 h-9 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC]">
                        <svg class="w-5 h-5 text-white dark:text-[#1b1b18]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 0h6v6h-6v-6z" fill="currentColor"/>
                            <path d="M10.5 3.5h3v3h-3v-3zm0 14h3v3h-3v-3zM3.5 10.5h3v3h-3v-3zm14 0h3v3h-3v-3z" fill="currentColor"/>
                        </svg>
                    </span>
                    <span class="text-lg font-semibold tracking-tight">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <div class="hidden md:flex items-center gap-8 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    <a href="#fitur" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors">Fitur</a>
                    <a href="#alat-pdf" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors">Alat PDF</a>
                    <a href="#cara-kerja" class="hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors">Cara Kerja</a>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-4 py-2 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors">
                            Dashboard
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                        </a>
                    @else
                        @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center rounded-lg border border-[#19140035] dark:border-[#3E3E3A] px-4 py-2 text-sm font-medium hover:border-[#1915014a] dark:hover:border-[#62605b] transition-colors">
                                Masuk
                            </a>
                        @endif
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-4 py-2 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors">
                                Daftar Gratis
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        @endif
                    @endauth
                </div>
            </nav>
        </header>

        {{-- Hero --}}
        <section class="relative overflow-hidden">
            <div class="absolute -top-40 right-0 w-[36rem] h-[36rem] rounded-full bg-[#f53003]/10 dark:bg-[#FF4433]/10 blur-3xl pointer-events-none"></div>
            <div class="absolute top-40 -left-40 w-[30rem] h-[30rem] rounded-full bg-[#FF750F]/10 blur-3xl pointer-events-none"></div>

            <div class="relative max-w-6xl mx-auto px-6 pt-16 pb-20 lg:pt-24 lg:pb-28 grid lg:grid-cols-2 gap-16 items-center">
                <div>
                    <span class="inline-flex items-center gap-2 rounded-full border border-[#19140035] dark:border-[#3E3E3A] px-3.5 py-1 text-xs font-medium text-[#706f6c] dark:text-[#A1A09A]">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#f53003] dark:bg-[#FF4433]"></span>
                        100% Gratis &mdash; Tanpa batas
                    </span>

                    <h1 class="mt-6 text-4xl lg:text-6xl font-semibold leading-[1.1] tracking-tight">
                        Buat QR Code
                        <span class="text-[#f53003] dark:text-[#FF4433]">berkualitas tinggi</span>
                        dalam hitungan detik
                    </h1>

                    <p class="mt-6 text-lg text-[#706f6c] dark:text-[#A1A09A] leading-relaxed max-w-xl">
                        Ubah teks, tautan, email, telepon, dan SMS menjadi QR Code yang bisa dipindai siapa saja. Kelola semua QR Code Anda dan pantau jumlah scan dari satu dashboard.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
                        @auth
                            <a href="{{ route('qrcode.create') }}"
                                class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-6 py-3 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors">
                                Buat QR Code Baru
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                                class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-6 py-3 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors">
                                Mulai Sekarang &mdash; Gratis
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        @endauth
                        <a href="#cara-kerja" class="inline-flex items-center gap-2 rounded-lg border border-[#19140035] dark:border-[#3E3E3A] px-6 py-3 text-sm font-medium hover:border-[#1915014a] dark:hover:border-[#62605b] transition-colors">
                            Lihat Cara Kerja
                        </a>
                    </div>

                    <div class="mt-10 flex flex-wrap items-center gap-x-8 gap-y-4 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                        <span class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#f53003] dark:text-[#FF4433]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                            Tanpa kartu kredit
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#f53003] dark:text-[#FF4433]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                            Unduh PNG &amp; SVG
                        </span>
                        <span class="inline-flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#f53003] dark:text-[#FF4433]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                            Pantau jumlah scan
                        </span>
                    </div>
                </div>

                {{-- Hero visual --}}
                <div class="relative flex justify-center lg:justify-end">
                    <div class="relative bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-8 lg:p-10 rotate-1">
                        @php
                            $qrCells = ['11','21','31','41','51','61','71','12','42','72','13','23','33','43','53','63','73','14','74','15','25','35','45','55','65','75','16','46','76','17','27','37','47','57','67','77'];
                        @endphp
                        <div class="grid grid-cols-7 gap-1.5 p-5 rounded-xl bg-[#FDFDFC] dark:bg-[#0a0a0a] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.08)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d]">
                            @for ($i = 1; $i <= 7; $i++)
                                @for ($j = 1; $j <= 7; $j++)
                                    <span class="w-3 h-3 rounded-[2px] {{ in_array("$i$j", $qrCells) ? 'bg-[#1b1b18] dark:bg-[#EDEDEC]' : '' }}"></span>
                                @endfor
                            @endfor
                        </div>
                        <p class="mt-4 text-center text-xs text-[#706f6c] dark:text-[#A1A09A]">Scan untuk mengunjungi tautan Anda</p>
                    </div>

                    {{-- Floating card: scans --}}
                    <div class="absolute -top-4 -left-2 lg:-left-8 bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-xl px-4 py-3 -rotate-2">
                        <p class="text-[10px] uppercase tracking-widest text-[#706f6c] dark:text-[#A1A09A]">Total Scan</p>
                        <p class="text-xl font-semibold mt-0.5">1.248 <span class="text-xs font-normal text-[#706f6c] dark:text-[#A1A09A]">scan</span></p>
                    </div>

                    {{-- Floating card: status --}}
                    <div class="absolute -bottom-4 right-0 lg:-right-6 bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-xl px-4 py-3 rotate-2">
                        <div class="flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                            <p class="text-xs font-medium">QR Code Aktif</p>
                        </div>
                        <p class="text-xl font-semibold mt-1">32 <span class="text-xs font-normal text-[#706f6c] dark:text-[#A1A09A]">aktif</span></p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Features --}}
        <section id="fitur" class="border-t border-[#19140014] dark:border-[#3E3E3A]/40">
            <div class="max-w-6xl mx-auto px-6 py-20 lg:py-24">
                <div class="max-w-2xl">
                    <h2 class="text-3xl lg:text-4xl font-semibold tracking-tight">
                        Semua yang Anda butuhkan
                        <span class="text-[#f53003] dark:text-[#FF4433]">untuk QR Code</span>
                    </h2>
                    <p class="mt-4 text-[#706f6c] dark:text-[#A1A09A] text-lg">
                        Fitur lengkap untuk membuat, mengelola, dan memantau QR Code Anda.
                    </p>
                </div>

                <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @php
                        $features = [
                            [
                                'icon' => '<path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 0h6v6h-6v-6z" fill="currentColor"/><path d="M10.5 3.5h3v3h-3v-3zm0 14h3v3h-3v-3zM3.5 10.5h3v3h-3v-3zm14 0h3v3h-3v-3z" fill="currentColor"/>',
                                'title' => '5 Jenis QR Code',
                                'desc' => 'Teks, tautan, email, telepon, dan SMS &mdash; semua didukung.',
                            ],
                            [
                                'icon' => '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>',
                                'title' => 'Pantau Scan',
                                'desc' => 'Lihat berapa kali setiap QR Code Anda dipindai.',
                            ],
                            [
                                'icon' => '<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="M7 10l5 5 5-5"/><path d="M12 15V3"/>',
                                'title' => 'Unduh PNG &amp; SVG',
                                'desc' => 'Simpan QR Code dalam format gambar atau vektor.',
                            ],
                            [
                                'icon' => '<path d="M12 15a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 1 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 1 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 1 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 1 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>',
                                'title' => 'Tingkat Kustomisasi',
                                'desc' => 'Atur warna dan ukuran QR Code sesuai kebutuhan Anda.',
                            ],
                        ];
                    @endphp

                    @foreach ($features as $feature)
                        <div class="bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
                            <span class="flex items-center justify-center w-11 h-11 rounded-xl bg-[#1b1b18] dark:bg-[#EDEDEC] text-white dark:text-[#1b1b18]">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">{!! $feature['icon'] !!}</svg>
                            </span>
                            <h3 class="mt-4 font-semibold">{!! $feature['title'] !!}</h3>
                            <p class="mt-1.5 text-sm text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">{!! $feature['desc'] !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- PDF Tools --}}
        <section id="alat-pdf" class="border-t border-[#19140014] dark:border-[#3E3E3A]/40">
            <div class="max-w-6xl mx-auto px-6 py-20 lg:py-24">
                <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                    <div class="max-w-2xl">
                        <span class="inline-flex items-center gap-2 rounded-full border border-[#19140035] dark:border-[#3E3E3A] px-3.5 py-1 text-xs font-medium text-[#706f6c] dark:text-[#A1A09A]">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#f53003] dark:bg-[#FF4433]"></span>
                            Alat PDF
                        </span>
                        <h2 class="mt-4 text-3xl lg:text-4xl font-semibold tracking-tight">
                            Kelola file PDF dengan <span class="text-[#f53003] dark:text-[#FF4433]">mudah</span>
                        </h2>
                        <p class="mt-4 text-[#706f6c] dark:text-[#A1A09A] text-lg">
                            Konversi, gabungkan, kompres, dan atur PDF Anda &mdash; semua gratis, tanpa watermark.
                        </p>
                    </div>
                    <a href="{{ route('pdf-tools.index') }}"
                        class="inline-flex items-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-6 py-3 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white transition-colors shrink-0">
                        Lihat Semua Alat
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                    </a>
                </div>

                <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    @php
                        $pdfTools = [
                            ['key' => 'word-to-pdf', 'title' => 'Word ke PDF', 'desc' => 'Ubah DOC/DOCX menjadi PDF berkualitas tinggi.'],
                            ['key' => 'merge', 'title' => 'Gabung PDF', 'desc' => 'Gabungkan beberapa PDF menjadi satu file.'],
                            ['key' => 'compress', 'title' => 'Kompres PDF', 'desc' => 'Perkecil ukuran PDF agar mudah dibagikan.'],
                            ['key' => 'rotate', 'title' => 'Putar PDF', 'desc' => 'Rotasi halaman PDF 90, 180, atau 270 derajat.'],
                        ];
                    @endphp

                    @foreach ($pdfTools as $tool)
                        <a href="{{ route('pdf-tools.show', $tool['key']) }}" class="group bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-6 hover:-translate-y-1 transition-transform duration-300">
                            <span class="flex items-center justify-center w-11 h-11 rounded-xl bg-[#f53003]/10 dark:bg-[#FF4433]/10 text-[#f53003] dark:text-[#FF4433] group-hover:bg-[#1b1b18] group-hover:text-white dark:group-hover:bg-[#EDEDEC] dark:group-hover:text-[#1b1b18] transition-colors">
                                @include('pdf-tools.partials.icon', ['key' => $tool['key']])
                            </span>
                            <h3 class="mt-4 font-semibold">{{ $tool['title'] }}</h3>
                            <p class="mt-1.5 text-sm text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">{{ $tool['desc'] }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- How it works --}}
        <section id="cara-kerja" class="border-t border-[#19140014] dark:border-[#3E3E3A]/40 bg-white dark:bg-[#161615]/40">
            <div class="max-w-6xl mx-auto px-6 py-20 lg:py-24">
                <div class="max-w-2xl mx-auto text-center">
                    <h2 class="text-3xl lg:text-4xl font-semibold tracking-tight">
                        Cara kerjanya <span class="text-[#f53003] dark:text-[#FF4433]">sangat mudah</span>
                    </h2>
                    <p class="mt-4 text-[#706f6c] dark:text-[#A1A09A] text-lg">
                        Tiga langkah sederhana untuk membuat QR Code pertama Anda.
                    </p>
                </div>

                <div class="mt-14 grid md:grid-cols-3 gap-10">
                    @php
                        $steps = [
                            ['num' => '01', 'title' => 'Daftar akun', 'desc' => 'Buat akun gratis Anda dalam hitungan detik &mdash; hanya butuh nama dan email.'],
                            ['num' => '02', 'title' => 'Buat QR Code', 'desc' => 'Pilih jenis konten, masukkan data, dan QR Code langsung dibuat otomatis.'],
                            ['num' => '03', 'title' => 'Bagikan &amp; pantau', 'desc' => 'Unduh QR Code Anda lalu pantau jumlah scan dari dashboard.'],
                        ];
                    @endphp

                    @foreach ($steps as $step)
                        <div class="relative text-center md:text-left">
                            @if (!$loop->last)
                                <div class="hidden md:block absolute top-6 left-[calc(50%+3.5rem)] right-[calc(-50%+3.5rem)] h-px bg-[#19140035] dark:bg-[#3E3E3A]"></div>
                            @endif
                            <span class="relative inline-flex items-center justify-center w-12 h-12 rounded-full bg-[#f53003]/10 dark:bg-[#FF4433]/10 text-[#f53003] dark:text-[#FF4433] font-semibold text-lg shadow-[inset_0px_0px_0px_1px_rgba(245,48,3,0.25)] dark:shadow-[inset_0px_0px_0px_1px_rgba(255,68,51,0.25)]">
                                {{ $step['num'] }}
                            </span>
                            <h3 class="mt-4 text-lg font-semibold">{!! $step['title'] !!}</h3>
                            <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A] leading-relaxed">{!! $step['desc'] !!}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- CTA --}}
        <section class="border-t border-[#19140014] dark:border-[#3E3E3A]/40">
            <div class="max-w-6xl mx-auto px-6 py-20 lg:py-24">
                <div class="relative overflow-hidden rounded-2xl bg-[#1b1b18] dark:bg-[#161615] text-white dark:text-[#EDEDEC] px-8 py-14 lg:px-16 lg:py-16 shadow-[inset_0px_0px_0px_1px_rgba(255,250,237,0.1)] text-center">
                    <div class="absolute -top-24 left-1/2 -translate-x-1/2 w-[30rem] h-[30rem] rounded-full bg-[#FF4433]/20 blur-3xl pointer-events-none"></div>
                    <div class="relative">
                        <h2 class="text-3xl lg:text-4xl font-semibold tracking-tight">
                            Siap membuat QR Code pertama Anda?
                        </h2>
                        <p class="mt-4 text-[#A1A09A] max-w-xl mx-auto">
                            Bergabung sekarang, gratis. Tidak perlu kartu kredit, tanpa batas jumlah QR Code.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                            @auth
                                <a href="{{ route('qrcode.create') }}"
                                    class="inline-flex items-center gap-2 rounded-lg bg-[#EDEDEC] px-6 py-3 text-sm font-semibold text-[#1b1b18] hover:bg-white transition-colors">
                                    Buat QR Code Sekarang
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                            @else
                                <a href="{{ route('register') }}"
                                    class="inline-flex items-center gap-2 rounded-lg bg-[#EDEDEC] px-6 py-3 text-sm font-semibold text-[#1b1b18] hover:bg-white transition-colors">
                                    Daftar Gratis Sekarang
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                                </a>
                                <a href="{{ route('login') }}"
                                    class="inline-flex items-center gap-2 rounded-lg border border-white/20 px-6 py-3 text-sm font-medium text-[#EDEDEC] hover:border-white/40 transition-colors">
                                    Masuk
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="border-t border-[#19140014] dark:border-[#3E3E3A]/40">
            <div class="max-w-6xl mx-auto px-6 py-10 flex flex-col sm:flex-row items-center justify-between gap-4">
                <a href="/" class="inline-flex items-center gap-2.5">
                    <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC]">
                        <svg class="w-5 h-5 text-white dark:text-[#1b1b18]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 0h6v6h-6v-6z" fill="currentColor"/>
                            <path d="M10.5 3.5h3v3h-3v-3zm0 14h3v3h-3v-3zM3.5 10.5h3v3h-3v-3zm14 0h3v3h-3v-3z" fill="currentColor"/>
                        </svg>
                    </span>
                    <span class="font-semibold tracking-tight">{{ config('app.name', 'Laravel') }}</span>
                </a>

                <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }} &mdash; QR Code Generator. Semua hak dilindungi.
                </p>
            </div>
        </footer>
    </body>
</html>
