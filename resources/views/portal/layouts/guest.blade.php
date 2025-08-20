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
    <!-- NProgress CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.css" />
    {{-- Styles & Scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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

<body class="font-sans antialiased bg-gray-900 text-gray-900">

    <!-- Full Background -->
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center relative"
        style="background-image: url('/images/carousel1.jpg');">

        <!-- Overlay Hitam -->
        <div class="absolute inset-0 bg-black/60 z-10"></div>

        <!-- Overlay Biru -->
        <div class="absolute inset-0 bg-blue-600/30"></div>

        <!-- Content Wrapper -->
        <div
            class="relative z-20 w-full max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between md:gap-3 gap-6">

            <!-- Kiri: Logo & Deskripsi -->
            <div class="hidden md:block flex-1 text-left text-white md:pr-8">
                <img src="{{ asset('images/logo-diy.png') }}" alt="Logo E-Lapor" class="w-36 h-32 mb-6 drop-shadow-lg">

                <h1 class="text-3xl font-bold mb-2">Selamat Datang di</h1>
                <h2 class="text-2xl font-bold mb-4">E-Lapor DIY</h2>

                <p class="text-gray-200 font-medium leading-relaxed">
                    Platform resmi pengaduan masyarakat Daerah Istimewa Yogyakarta.<br>
                    Wujudkan pelayanan publik yang
                    <span class="font-semibold text-blue-300">cepat, transparan,</span>
                    dan <span class="font-semibold text-blue-300">mudah diakses</span> kapan saja.
                </p>
            </div>

            <!-- Kanan: Form -->
            <div class="flex-1 w-full max-w-md">
                <div class="p-8 rounded-2xl shadow-2xl border border-white/20 bg-white/10">
                    {{ $slot }}
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <script>
        // ⚙️ Konfigurasi default NProgress
        NProgress.configure({
            showSpinner: false,
            trickleSpeed: 200,
            minimum: 0.08
        });

        // 🔹 1. Tangkap klik semua link internal
        document.addEventListener("click", function (e) {
            const link = e.target.closest("a");
            if (link && link.href && link.origin === window.location.origin) {
                NProgress.start();
                setTimeout(() => NProgress.set(0.9), 150);
            }
        });

        // 🔹 2. Patch untuk XMLHttpRequest
        (function (open) {
            XMLHttpRequest.prototype.open = function () {
                NProgress.start();
                this.addEventListener("loadend", function () {
                    NProgress.set(1.0);
                    setTimeout(() => NProgress.done(), 300);
                });
                open.apply(this, arguments);
            };
        })(XMLHttpRequest.prototype.open);

        // 🔹 3. Patch untuk Fetch API
        const originalFetch = window.fetch;
        window.fetch = function () {
            NProgress.start();
            return originalFetch.apply(this, arguments).finally(() => {
                NProgress.set(1.0);
                setTimeout(() => NProgress.done(), 300);
            });
        };

        // 🔹 4. Saat halaman selesai load
        window.addEventListener("pageshow", () => {
            NProgress.set(1.0);
            setTimeout(() => NProgress.done(), 300);
        });

        // 🔹 5. Tangkap submit form (SAMAIN dengan klik link)
        document.addEventListener("submit", function (e) {
            const form = e.target;
            if (form.tagName === "FORM") {
                NProgress.start();
                setTimeout(() => NProgress.set(0.9), 150);
            }
        }, true);
    </script>

</body>

</html>