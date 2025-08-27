<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page_title ?? config('app.name', 'E-Lapor DIY') }}</title>

    {{-- SEO --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Fonts --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- NProgress CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tambahan CSS dari halaman --}}
    @yield('include-css')

    <style>
        html,
        body {
            font-family: 'Open Sans', 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        #nprogress .bar {
            background: linear-gradient(to right,
                    #ff1744,
                    /* vivid red */
                    #f50057
                    /* pinkish red */
                );
            height: 3px;
        }

        #nprogress .peg {
            box-shadow:
                0 0 15px #ff1744,
                0 0 10px #f50057,
                0 0 6px #ff4081;
        }

        #nprogress .spinner-icon {
            border-top-color: #ff1744;
            border-left-color: #f50057;
        }
    </style>
</head>

<body class="font-sans antialiased bg-white text-gray-800 h-full flex flex-col">

    {{-- Navbar --}}
    @include('portal.layouts.navbar')

    {{-- Page Header (opsional) --}}
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    {{-- Main Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('portal.layouts.footer')

    {{-- Statistik Kunjungan Floating Button --}}
    <div x-data="{ open: false, hover: false }" class="fixed bottom-5 left-5 z-50">

        <!-- Tombol -->
        <button @click="open = true" @mouseenter="hover = true" @mouseleave="hover = false"
            class="relative flex items-center bg-red-700 text-white rounded-full shadow-lg hover:bg-red-800 transition-all duration-300 overflow-hidden"
            :class="hover ? 'w-52 pl-12 pr-4' : 'w-14 pl-0 pr-0'" style="height: 3.5rem;">

            <!-- Icon (selalu tampil, posisi fix di kiri tengah) -->
            <div class="absolute left-0 top-1/2 -translate-y-1/2 flex justify-center items-center w-14">
                <i class="bi bi-bar-chart-fill text-2xl"></i>
            </div>

            <!-- Text muncul saat hover -->
            <span x-cloak class="font-semibold text-sm whitespace-nowrap transform transition-all duration-300 ml-2"
                :class="hover ? 'opacity-100 translate-x-0' : 'opacity-0 translate-x-4'">
                Statistik Kunjungan
            </span>
        </button>

        <!-- Panel Slide -->
        <div x-show="open" x-cloak x-transition:enter="transform transition ease-out duration-300"
            x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="transform transition ease-in duration-300"
            x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="-translate-x-full opacity-0"
            class="fixed top-1/2 left-0 -translate-y-1/2 bg-white rounded-r-xl 
           drop-shadow-[6px_-4px_12px_rgba(0,0,0,0.35)] w-72 max-w-full z-50">

            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-4 rounded-tr-xl bg-white shadow-none">
                <div class="flex items-center gap-2 text-gray-800">
                    <!-- Icon lebih besar -->
                    <i class="bi bi-info-circle-fill text-red-600 text-xl"></i>
                    <span class="font-semibold text-lg">Informasi Pengunjung</span>
                </div>

                <!-- Tombol Close -->
                <button @click="open = false"
                    class="w-8 h-8 flex items-center justify-center rounded-md text-xl font-bold text-gray-800 hover:bg-gray-300 transition">
                    ✕
                </button>
            </div>

            <!-- Konten -->
            <div class="p-4 bg-red-700 rounded-br-xl">
                <p class="text-sm text-gray-200">Gagal memuat statistik pengunjung</p>
            </div>
        </div>

        <!-- Tambahkan CSS untuk x-cloak -->
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>

        {{-- Tambahan JS dari halaman --}}
        @yield('include-js')
        @stack('scripts')

</body>

</html>