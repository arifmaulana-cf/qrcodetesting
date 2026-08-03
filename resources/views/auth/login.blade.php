<x-guest-layout>
    {{-- Session Status --}}
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <div class="text-center">
        <h1 class="text-2xl font-semibold tracking-tight">Selamat datang kembali</h1>
        <p class="mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            Masuk untuk mengelola QR Code Anda
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm font-medium">
                Email
            </label>
            <div class="relative mt-1.5">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#706f6c] dark:text-[#A1A09A]">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M22 6l-10 7L2 6"/><path d="M2 6h20v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V6z"/></svg>
                </span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="nama@contoh.com"
                    class="block w-full rounded-lg border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] py-2.5 pl-10 pr-3.5 text-sm text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#A1A09A] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-2 focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25 focus:outline-none transition">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div x-data="{ show: false }">
            <div class="flex items-center justify-between">
                <label for="password" class="block text-sm font-medium">
                    Kata Sandi
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-sm text-[#f53003] dark:text-[#FF4433] hover:opacity-80 transition-opacity">
                        Lupa kata sandi?
                    </a>
                @endif
            </div>
            <div class="relative mt-1.5">
                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[#706f6c] dark:text-[#A1A09A]">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                </span>
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi"
                    class="block w-full rounded-lg border border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] py-2.5 pl-10 pr-11 text-sm text-[#1b1b18] dark:text-[#EDEDEC] placeholder-[#A1A09A] shadow-sm focus:border-[#f53003] dark:focus:border-[#FF4433] focus:ring-2 focus:ring-[#f53003]/25 dark:focus:ring-[#FF4433]/25 focus:outline-none transition">
                <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-[#706f6c] dark:text-[#A1A09A] hover:text-[#1b1b18] dark:hover:text-[#EDEDEC] transition-colors" :aria-label="show ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi'">
                    <svg x-show="!show" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                    <svg x-show="show" x-cloak class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><path d="M1 1l22 22"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center">
            <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-[#19140035] dark:border-[#3E3E3A] bg-white dark:bg-[#161615] text-[#f53003] dark:text-[#FF4433] shadow-sm focus:ring-[#f53003]/40 dark:focus:ring-[#FF4433]/40 focus:ring-2 focus:ring-offset-0 dark:focus:ring-offset-[#161615] transition">
                <span class="ms-2.5 text-sm text-[#706f6c] dark:text-[#A1A09A]">Ingat saya</span>
            </label>
        </div>

        <div>
            <button type="submit"
                class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-[#1b1b18] dark:bg-[#EDEDEC] px-4 py-2.5 text-sm font-semibold text-white dark:text-[#1b1b18] hover:bg-black dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-[#1b1b18]/30 dark:focus:ring-[#EDEDEC]/40 transition-colors">
                Masuk
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </button>
        </div>
    </form>

    @if (Route::has('register'))
        <p class="mt-8 text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-[#f53003] dark:text-[#FF4433] hover:opacity-80 transition-opacity">
                Daftar sekarang
            </a>
        </p>
    @endif
</x-guest-layout>
