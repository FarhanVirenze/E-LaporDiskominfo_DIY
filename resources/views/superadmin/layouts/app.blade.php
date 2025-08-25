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
    <!-- Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
      crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Menambahkan jQuery sebelum Bootstrap JS -->
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- NProgress CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tambahan CSS Materially --}}
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F5F7FB;
        }

        .material-card {
            border-radius: 1rem;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .material-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
        }

        .material-title {
            font-weight: 600;
            font-size: 1.2rem;
            color: #37474F;
        }

        .material-subtitle {
            font-size: 0.9rem;
            color: #607D8B;
        }

        .material-icon {
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
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

    {{-- Tambahan CSS dari halaman --}}
    @yield('include-css')
</head>

<body class="font-sans antialiased bg-white text-gray-800">
    <div class="min-h-screen flex flex-col main-wrapper">
        {{-- Navbar --}}
        @include('superadmin.layouts.navbar')

        {{-- Page Header (opsional) --}}
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset
    </div>

    {{-- Tambahan JS dari halaman --}}
    @yield('include-js')

    {{-- Scripts tambahan di bagian bawah halaman --}}
    @stack('scripts') {{-- Jika ada push stack script di halaman --}}
</body>

</html>