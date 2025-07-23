<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF Token --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $page_title ?? config('app.name', 'E-Lapor DIY') }}</title>

    {{-- SEO --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Fonts --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <!-- Menambahkan jQuery sebelum Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tambahan CSS dari halaman --}}
    @yield('include-css')
</head>

<body class="font-sans antialiased bg-white text-gray-800">
    <div class="min-h-screen flex flex-col main-wrapper">
        {{-- Navbar --}}
        @include('admin.layouts.navbar')

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
        @include('admin.layouts.footer')
    </div>

    {{-- Tambahan JS dari halaman --}}
    @yield('include-js')

    {{-- Scripts tambahan di bagian bawah halaman --}}
    @stack('scripts') {{-- Jika ada push stack script di halaman --}}
</body>

</html>