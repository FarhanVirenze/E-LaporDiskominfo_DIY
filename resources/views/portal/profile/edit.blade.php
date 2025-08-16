@extends('portal.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Panggil Komponen Riwayat Tabs -->
            @component('components.riwayat-tabs')
            <!-- Slot: Konten Profil -->
            <div class="space-y-6">
                <!-- Profile Information Section -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-white outline-8 outline-red-500">
                    <div class="max-w-xl">
                        @include('portal.profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Password Update Section -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-white outline-8 outline-red-500">
                    <div class="max-w-xl">
                        @include('portal.profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account Section -->
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg border-2 border-white outline-8 outline-red-500">
                    <div class="max-w-xl">
                        @include('portal.profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
            @endcomponent
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

@endsection