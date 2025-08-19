@extends('superadmin.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('content')

    @if (session('success'))
        <div id="alert-success"
            class="alert alert-success bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative animate__animated animate__fadeInDown"
            role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div id="alert-error"
            class="alert alert-error bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative animate__animated animate__fadeInDown"
            role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Slot: Konten Profil -->
            @component('components.riwayatsuperadmin-tabs')
            <div class="space-y-6">
                <!-- Profile Information Section -->
                <div
                    class="p-6 sm:p-8 bg-white shadow-lg rounded-xl border border-gray-200 hover:shadow-xl transition w-full max-w-3xl mx-auto">
                    @include('portal.profile.partials.update-profile-information-form')
                </div>

                <!-- Password Update Section -->
                <div
                    class="p-6 sm:p-8 bg-white shadow-lg rounded-xl border border-gray-200 hover:shadow-xl transition w-full max-w-3xl mx-auto">
                    @include('portal.profile.partials.update-password-form')
                </div>

                <!-- Delete Account Section -->
                <div
                    class="p-6 sm:p-8 bg-white shadow-lg rounded-xl border border-gray-200 hover:shadow-xl transition w-full max-w-3xl mx-auto">
                    @include('portal.profile.partials.delete-user-form')
                </div>

            </div>
            @endcomponent
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <script>
        // ⚙️ Konfigurasi default NProgress
        NProgress.configure({
            showSpinner: false,   // Matikan spinner (biar lebih clean)
            trickleSpeed: 200,    // Kecepatan progress otomatis
            minimum: 0.08         // Start dari 8% biar gak langsung loncat
        });

        // 🔹 1. Tangkap klik semua link internal
        document.addEventListener("click", function (e) {
            const link = e.target.closest("a");
            if (link && link.href && link.origin === window.location.origin) {
                NProgress.start();
                // Biar keliatan dulu baru pindah halaman
                setTimeout(() => NProgress.set(0.9), 150);
            }
        });

        // 🔹 2. Patch untuk XMLHttpRequest
        (function (open) {
            XMLHttpRequest.prototype.open = function () {
                NProgress.start();
                this.addEventListener("loadend", function () {
                    NProgress.set(1.0); // Langsung ke ujung
                    setTimeout(() => NProgress.done(), 200);
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
                setTimeout(() => NProgress.done(), 200);
            });
        };

        // 🔹 4. Saat halaman selesai load (termasuk back/forward cache)
        window.addEventListener("pageshow", () => {
            NProgress.set(1.0);
            setTimeout(() => NProgress.done(), 200);
        });
    </script>

@endsection