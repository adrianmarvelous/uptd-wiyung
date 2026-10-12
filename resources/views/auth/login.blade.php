<x-auth-layout title="Masuk · UPTB 3 Bapenda Pemerintah Kota Surabaya">
    @if (config('services.recaptcha.site_key'))
        @push('head')
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endpush
    @endif

    <div class="mb-5 sm:mb-6">
        <h2 class="text-lg font-semibold text-slate-900 sm:text-xl">Masuk ke Sistem</h2>
        <p class="mt-1 text-sm text-slate-500">Silakan masukkan username dan password Anda.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{ showPassword: false }">
        @csrf

        <!-- Username -->
        <div>
            <label for="username" class="block text-sm font-medium text-slate-700">Username</label>
            <input id="username" name="username" type="text" value="{{ old('username') }}" required autofocus autocomplete="username"
                placeholder="Masukkan username"
                class="mt-1 block w-full rounded-lg border-slate-300 bg-white text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-brand-600 focus:ring-brand-600 sm:mt-1.5" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-3 sm:mt-4">
            <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
            <div class="relative mt-1 sm:mt-1.5">
                <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required autocomplete="current-password"
                    placeholder="Masukkan password"
                    class="block w-full rounded-lg border-slate-300 bg-white pr-11 text-slate-900 shadow-sm placeholder:text-slate-400 focus:border-brand-600 focus:ring-brand-600" />
                <button type="button" @click="showPassword = ! showPassword"
                    class="absolute inset-y-0 right-0 flex w-11 items-center justify-center rounded-r-lg text-slate-400 transition hover:text-brand-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-brand-600"
                    :title="showPassword ? 'Sembunyikan password' : 'Tampilkan password'">
                    <span class="sr-only" x-text="showPassword ? 'Sembunyikan password' : 'Tampilkan password'">Tampilkan password</span>
                    <svg x-show="! showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <svg x-show="showPassword" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.243 4.243L9.88 9.88" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="mt-3 sm:mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" name="remember"
                    class="rounded border-slate-300 text-brand-700 shadow-sm focus:ring-brand-600" />
                <span class="ms-2 text-sm text-slate-600">Ingat saya di perangkat ini</span>
            </label>
        </div>

        <!-- reCAPTCHA v2 (kotak centang) -->
        @if (config('services.recaptcha.site_key'))
            {{-- Widget reCAPTCHA berukuran tetap 304x78px. Di layar yang lebih sempit,
                 kotak ini bisa digeser mendatar agar tata letak halaman tidak rusak.
                 Ukuran asli dipertahankan supaya kotak centang tetap bisa diklik. --}}
            <div class="mt-3 overflow-x-auto sm:mt-4">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}" data-theme="light"></div>
            </div>
            <x-input-error :messages="$errors->get('g-recaptcha-response')" class="mt-2" />
        @endif

        <div class="mt-4 sm:mt-6">
            {{-- Password reset is disabled: this app has no email column, so reset links cannot be delivered. --}}

            <button type="submit"
                class="w-full rounded-lg bg-brand-700 px-4 py-2.5 text-sm font-semibold uppercase tracking-widest text-white shadow-sm transition hover:bg-brand-800 focus:outline-none focus:ring-2 focus:ring-brand-600 focus:ring-offset-2 active:bg-brand-900">
                Masuk
            </button>
        </div>
    </form>
</x-auth-layout>
