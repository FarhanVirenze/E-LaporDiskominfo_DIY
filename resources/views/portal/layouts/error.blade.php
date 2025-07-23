<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Lapor DIY') }}</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-white" style="
    background: linear-gradient(135deg, rgba(192,57,43,0.95), rgba(121,3,3,0.95));
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    min-height: 100vh;
">

    {{-- Main Fullscreen Content --}}
    <main class="flex items-center justify-center min-h-screen px-4">

        {{-- Isi Konten --}}
        <div class="w-full max-w-xl text-center">
            @yield('content')
        </div>

    </main>

    {{-- Extra JS --}}
    @stack('scripts')

</body>
</html>
