@extends('admin.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('content')
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-2 md:mt-2 lg:mt-2">
            <!-- Panggil Komponen Riwayat Tabs Admin -->
            @component('components.riwayatadmin-tabs')

            <!-- Tabs Navigation -->
            <div class="w-full max-w-3xl mx-auto">
                <div class="border-b border-gray-200 mb-6">
                    <div class="flex justify-center border-b" id="profileTabs">
                        <!-- Step 1 (Profil) -->
                        <button data-tab="info"
                            class="tab-link group flex-1 flex flex-col items-center justify-center px-3 py-1 sm:px-4 sm:py-2 border-b-2 border-red-600 text-red-600 text-center active-tab space-y-1 hover:border-red-600 hover:text-red-600">
                            <span
                                class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-red-600 text-white text-xs sm:text-sm font-bold group-hover:bg-red-600 group-hover:text-white">
                                1
                            </span>
                            <span class="text-xs sm:text-sm">Profil</span>
                        </button>

                        <!-- Step 2 (Password) -->
                        <button data-tab="password"
                            class="tab-link group flex-1 flex flex-col items-center justify-center px-3 py-1 sm:px-4 sm:py-2 border-b-2 border-transparent text-gray-500 hover:text-red-600 hover:border-red-600 text-center space-y-1">
                            <span
                                class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-gray-200 group-hover:bg-red-600 group-hover:text-white text-xs sm:text-sm font-bold">
                                2
                            </span>
                            <span class="text-xs sm:text-sm">Password</span>
                        </button>

                        <!-- Step 3 (Hapus Akun) -->
                        <button data-tab="delete"
                            class="tab-link group flex-1 flex flex-col items-center justify-center px-3 py-1 sm:px-4 sm:py-2 border-b-2 border-transparent text-gray-500 hover:text-red-600 hover:border-red-600 text-center space-y-1">
                            <span
                                class="flex items-center justify-center w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-gray-200 group-hover:bg-red-600 group-hover:text-white text-xs sm:text-sm font-bold">
                                3
                            </span>
                            <span class="text-xs sm:text-sm">Hapus Akun</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="space-y-6">
                <!-- Profile Information Section -->
                <div id="tab-info" class="tab-content block animate__animated animate__fadeIn">
                    <div class="p-6 sm:p-8 bg-white shadow-lg rounded-xl border border-gray-200 hover:shadow-xl transition">
                        @include('admin.profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Password Update Section -->
                <div id="tab-password" class="tab-content hidden animate__animated animate__fadeIn">
                    <div class="p-6 sm:p-8 bg-white shadow-lg rounded-xl border border-gray-200 hover:shadow-xl transition">
                        @include('admin.profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account Section -->
                <div id="tab-delete" class="tab-content hidden animate__animated animate__fadeIn">
                    <div class="p-6 sm:p-8 bg-white shadow-lg rounded-xl border border-gray-200 hover:shadow-xl transition">
                        @include('admin.profile.partials.delete-user-form')
                    </div>
                </div>
            </div>

            @endcomponent
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll("#profileTabs .tab-link");

            function switchTab(tab) {
                const target = tab.dataset.tab;

                tabs.forEach(el => {
                    el.classList.remove("text-red-600", "border-red-600", "active-tab");
                    el.classList.add("text-gray-500", "border-transparent");

                    const circle = el.querySelector("span:first-child");
                    circle.classList.remove("bg-red-600", "text-white");
                    circle.classList.add("bg-gray-300", "text-gray-800");
                });

                document.querySelectorAll(".tab-content").forEach(content => {
                    content.classList.add("hidden");
                });

                tab.classList.add("text-red-600", "border-red-600", "active-tab");
                tab.classList.remove("text-gray-500", "border-transparent");

                const activeCircle = tab.querySelector("span:first-child");
                activeCircle.classList.remove("bg-gray-300", "text-gray-800");
                activeCircle.classList.add("bg-red-600", "text-white");

                const contentEl = document.querySelector(`#tab-${target}`);
                contentEl.classList.remove("hidden");
                contentEl.classList.remove("animate__fadeIn");
                void contentEl.offsetWidth;
                contentEl.classList.add("animate__fadeIn");
            }

            tabs.forEach(tab => {
                tab.addEventListener("click", () => switchTab(tab));
            });

            const activeTab = "{{ session('active_tab', 'info') }}";
            const targetTab = document.querySelector(`#profileTabs .tab-link[data-tab="${activeTab}"]`);
            if (targetTab) switchTab(targetTab);
        });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <script>
        NProgress.configure({ showSpinner: false, trickleSpeed: 200, minimum: 0.08 });

        document.addEventListener("click", function (e) {
            const link = e.target.closest("a");
            if (link && link.href && link.origin === window.location.origin) {
                NProgress.start();
                setTimeout(() => NProgress.set(0.9), 150);
            }
        });

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

        const originalFetch = window.fetch;
        window.fetch = function () {
            NProgress.start();
            return originalFetch.apply(this, arguments).finally(() => {
                NProgress.set(1.0);
                setTimeout(() => NProgress.done(), 300);
            });
        };

        window.addEventListener("pageshow", () => {
            NProgress.set(1.0);
            setTimeout(() => NProgress.done(), 300);
        });

        document.addEventListener("submit", function (e) {
            const form = e.target;
            if (form.tagName === "FORM") {
                NProgress.start();
                setTimeout(() => NProgress.set(0.9), 150);
            }
        }, true);
    </script>
@endsection