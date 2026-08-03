<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-[#1b1b18] dark:text-[#EDEDEC] antialiased">
        <div class="min-h-screen lg:grid lg:grid-cols-2 bg-[#FDFDFC] dark:bg-[#0a0a0a]">
            {{-- Branding Panel --}}
            <div class="relative hidden lg:flex flex-col justify-between overflow-hidden bg-[#161615] text-[#EDEDEC] p-12">
                <div class="absolute -top-32 -right-32 w-[28rem] h-[28rem] rounded-full bg-[#f53003]/20 blur-3xl"></div>
                <div class="absolute -bottom-40 -left-24 w-[26rem] h-[26rem] rounded-full bg-[#FF750F]/10 blur-3xl"></div>

                <div class="relative">
                    <a href="/" class="inline-flex items-center gap-3">
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-[#EDEDEC]">
                            <svg class="w-6 h-6 text-[#1b1b18]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 0h6v6h-6v-6z" fill="currentColor"/>
                                <path d="M10.5 3.5h3v3h-3v-3zm0 14h3v3h-3v-3zM3.5 10.5h3v3h-3v-3zm14 0h3v3h-3v-3z" fill="currentColor"/>
                            </svg>
                        </span>
                        <span class="text-lg font-semibold tracking-tight">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                </div>

                <div class="relative max-w-md">
                    <h1 class="text-4xl font-semibold leading-tight tracking-tight">
                        Buat QR Code Anda
                        <span class="text-[#FF4433]">dalam hitungan detik.</span>
                    </h1>
                    <p class="mt-4 text-[#A1A09A] leading-relaxed">
                        Ubah teks, tautan, dan informasi menjadi QR Code berkualitas tinggi. Pantau jumlah scan dan kelola semuanya dari satu tempat.
                    </p>

                    <ul class="mt-8 space-y-4 text-sm text-[#EDEDEC]">
                        <li class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-[#EDEDEC]/10 text-[#FF4433]">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                            </span>
                            Generasi QR Code instan
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-[#EDEDEC]/10 text-[#FF4433]">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                            </span>
                            Lacak jumlah scan tiap QR Code
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex items-center justify-center w-6 h-6 rounded-full bg-[#EDEDEC]/10 text-[#FF4433]">
                                <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                            </span>
                            Gratis untuk selamanya
                        </li>
                    </ul>
                </div>

                {{-- Decorative QR --}}
                @php
                    $qrCells = ['11','21','31','51','61','71','12','32','52','72','13','23','33','43','53','73','44','74','15','35','45','65','75','16','36','66','76','17','27','37','47','67','77'];
                @endphp
                <div class="relative flex justify-end">
                    <div class="grid grid-cols-7 gap-1.5 p-4 rounded-xl bg-[#0a0a0a]/60 shadow-[inset_0px_0px_0px_1px_rgba(255,250,237,0.1)]">
                        @for ($i = 1; $i <= 7; $i++)
                            @for ($j = 1; $j <= 7; $j++)
                                <span class="w-2.5 h-2.5 rounded-[2px] {{ in_array("$i$j", $qrCells) ? 'bg-[#EDEDEC]/90' : '' }}"></span>
                            @endfor
                        @endfor
                    </div>
                </div>
            </div>

            {{-- Form Panel --}}
            <div class="flex flex-col min-h-screen">
                <header class="flex items-center justify-between px-6 py-6 lg:px-12">
                    <a href="/" class="lg:hidden inline-flex items-center gap-2.5">
                        <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC]">
                            <svg class="w-5 h-5 text-white dark:text-[#1b1b18]" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 3h6v6H3V3zm12 0h6v6h-6V3zM3 15h6v6H3v-6zm12 0h6v6h-6v-6z" fill="currentColor"/>
                                <path d="M10.5 3.5h3v3h-3v-3zm0 14h3v3h-3v-3zM3.5 10.5h3v3h-3v-3zm14 0h3v3h-3v-3z" fill="currentColor"/>
                            </svg>
                        </span>
                        <span class="text-base font-semibold tracking-tight">{{ config('app.name', 'Laravel') }}</span>
                    </a>

                    <a href="/" class="inline-flex items-center gap-1.5 text-sm text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                        Kembali ke Beranda
                    </a>
                </header>

                <main class="flex-1 flex items-center justify-center px-6 pb-16 lg:px-12">
                    <div class="w-full max-w-md bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-2xl p-8 lg:p-10">
                        {{ $slot }}
                    </div>
                </main>

                <footer class="px-6 pb-8 lg:px-12 text-center text-xs text-[#706f6c] dark:text-[#A1A09A]">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }} &mdash; QR Code Generator
                </footer>
            </div>
        </div>
    </body>
</html>
