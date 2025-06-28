<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Notulensi</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex flex-col">

    <!-- Navbar -->
    <header class="w-full bg-white dark:bg-gray-900 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                <span class="text-xl font-semibold text-gray-800 dark:text-gray-100">Notulensi</span>
            </div>
            <nav class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}"
                       class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                        Login
                    </a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}"
                           class="text-sm font-medium text-gray-700 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-indigo-400">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        </div>
    </header>

    <!-- Hero / Welcome Section -->
    <main class="flex-grow flex items-center justify-center p-6">
        <div class="max-w-3xl text-center">
            <h1 class="text-4xl font-bold mb-4">Selamat Datang di <span class="text-indigo-600">Notulensi</span></h1>
            <p class="text-lg text-gray-600 dark:text-gray-400 mb-6">
                Notulensi adalah sistem pencatatan hasil rapat modern yang dirancang untuk membantu tim Anda mencatat agenda, isi rapat, dan notulasi dengan lebih efisien dan terstruktur.
            </p>
            @guest
                <div class="space-x-4">
                    <a href="{{ route('login') }}"
                       class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md text-sm font-semibold transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-block border border-indigo-600 text-indigo-600 hover:bg-indigo-50 px-6 py-2 rounded-md text-sm font-semibold transition">
                        Daftar
                    </a>
                </div>
            @endguest
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-gray-900 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
        © {{ date('Y') }} Notulensi. Dibuat dengan ❤️ untuk produktivitas rapat yang lebih baik.
    </footer>
</body>
</html>
