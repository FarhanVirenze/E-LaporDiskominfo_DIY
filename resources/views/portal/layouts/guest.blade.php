<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

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

<body class="font-sans antialiased bg-white text-gray-900">

    <div class="min-h-screen flex flex-col justify-between main-wrapper">

        {{-- Navbar --}}
        @include('portal.layouts.navbar')

        {{-- Main Auth Container --}}
        <main class="flex items-center justify-center flex-grow bg-gradient-to-br">
            <div class="w-full max-w-md px-6 py-8 rounded-3xl shadow-[0_15px_40px_rgba(0,0,0,0.4)] ring-2 ring-white/30 border border-white/20 backdrop-blur-sm"
                style="
            background: linear-gradient(135deg, rgba(192,57,43,0.95), rgba(121,3,3,0.95));
            box-shadow:
                0 0 30px 10px rgba(224, 217, 217, 0.31),  /* efek cahaya putih lembut */
                inset 0 1px 3px rgba(175, 168, 168, 0.42); /* garis lembut di dalam */
        ">
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