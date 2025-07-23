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
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tambahan CSS dari halaman --}}
    @yield('include-css')
</head>

<body class="font-sans antialiased bg-white text-gray-800">

    <div class="min-h-screen flex flex-col justify-between main-wrapper">
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
    </div>

    {{-- Tambahan JS dari halaman --}}
    @yield('include-js')

    @stack('scripts')

</body>

</html>