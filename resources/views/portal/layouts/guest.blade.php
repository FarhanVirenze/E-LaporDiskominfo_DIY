<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'E-Lapor DIY') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-white text-gray-900">

    <div class="min-h-screen flex flex-col justify-between main-wrapper">

        {{-- Navbar --}}
        @include('portal.layouts.navbar') {{-- Navbar selalu tampil di halaman login juga --}}

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div id="alert-success"
                class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 opacity-100 animate-fade-in">
                <!-- Icon Wrapper -->
                <div id="success-icon-wrapper" class="transition-all duration-300">
                    <!-- Spinner awal -->
                    <svg id="success-spinner" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    <!-- Centang, disembunyikan dulu -->
                    <svg id="success-check" class="w-6 h-6 text-white hidden" fill="none" viewBox="0 0 24 24">
                        <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <!-- Pesan -->
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div id="alert-error"
                class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 opacity-100 animate-fade-in">
                <!-- Icon -->
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        {{-- Main Auth Container --}}
        <main class="flex items-center justify-center flex-grow bg-gradient-to-br">
            <div class="w-full max-w-md px-6 py-8 rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.4)] ring-2 ring-white/30 border border-white/20 backdrop-blur-sm"
                style="background: linear-gradient(135deg, rgba(192,57,43,0.95), rgba(121,3,3,0.95));
                box-shadow: 0 0 30px 10px rgba(224, 217, 217, 0.31), inset 0 1px 3px rgba(175, 168, 168, 0.42);">
                {{ $slot }}
            </div>
        </main>

        {{-- Footer --}}
        @include('portal.layouts.footer')

    </div>

    {{-- Extra JS --}}
    @stack('scripts')

</body>

</html>