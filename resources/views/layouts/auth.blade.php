<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

        <link rel="icon" type="image/png" href="{{ asset('images/logo-surabaya.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @stack('head')
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="flex min-h-svh flex-col bg-slate-100 lg:grid lg:min-h-screen lg:grid-cols-2">
            <!-- Identity panel -->
            <aside class="relative isolate flex items-center gap-3 overflow-hidden bg-gradient-to-br from-brand-900 via-brand-700 to-brand-500 px-5 py-4 text-white sm:flex-col sm:items-center sm:justify-center sm:gap-6 sm:px-10 sm:py-12 sm:text-center lg:gap-8 lg:px-12 lg:py-16">
                <div class="pointer-events-none absolute -left-24 -top-24 h-72 w-72 rounded-full bg-white/10 blur-3xl"></div>
                <div class="pointer-events-none absolute -bottom-28 -right-16 h-80 w-80 rounded-full bg-accent-500/20 blur-3xl"></div>

                <img src="{{ asset('images/logo-surabaya.png') }}" alt="Lambang Pemerintah Kota Surabaya"
                    class="relative h-16 w-16 shrink-0 drop-shadow-lg sm:h-24 sm:w-24 lg:h-28 lg:w-28" />

                <div class="relative min-w-0 sm:max-w-md">
                    <h1 class="text-base font-extrabold leading-tight tracking-tight sm:text-2xl lg:text-3xl">
                        UPTB 3 Bapenda Pemerintah Kota Surabaya
                    </h1>
                    <p class="mt-1 text-[11px] leading-snug text-white/80 sm:mt-3 sm:text-sm lg:text-base">
                        Sistem Informasi Manajemen Berita Acara Wajib Pajak Elektronik
                    </p>
                </div>

                <p class="relative hidden text-xs text-white/60 lg:block">
                    &copy; {{ date('Y') }} Pemerintah Kota Surabaya
                </p>
            </aside>

            <!-- Form panel -->
            <main class="flex flex-1 items-center justify-center px-2 py-5 sm:px-8 sm:py-10 lg:py-16">
                <div class="w-full max-w-md">
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-xl shadow-slate-900/5 sm:p-8">
                        {{ $slot }}
                    </div>

                    <p class="mt-3 text-center text-[11px] text-slate-500 sm:mt-6 sm:text-xs lg:hidden">
                        &copy; {{ date('Y') }} Pemerintah Kota Surabaya
                    </p>
                </div>
            </main>
        </div>

        @stack('scripts')
    </body>
</html>
