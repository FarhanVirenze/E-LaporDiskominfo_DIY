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
    <link rel="preload" as="image" href="{{ asset('images/carousel1.jpg') }}">
    <link rel="preload" as="image" href="{{ asset('images/carousel2.jpg') }}">
    <link rel="preload" as="image" href="{{ asset('images/carousel3.jpg') }}">
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
            background: linear-gradient(to right, #2563eb, #60a5fa);
            height: 3px;
        }

        #nprogress .peg {
            box-shadow: 0 0 10px #2563eb, 0 0 5px #60a5fa;
        }

        #nprogress .spinner-icon {
            border-top-color: #2563eb;
            border-left-color: #2563eb;
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

    {{-- Tambahan JS dari halaman --}}
    @yield('include-js')
    @stack('scripts')

</body>

</html>