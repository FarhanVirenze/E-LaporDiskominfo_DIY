@extends('portal.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')

    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div id="alert-success" class="fixed top-5 right-5 z-50 flex items-center justify-between gap-4 
                                       w-[420px] max-w-[90vw] px-6 py-4 rounded-2xl shadow-2xl border border-blue-400 
                                       bg-gradient-to-r from-blue-600 to-blue-500/90 backdrop-blur-md text-white 
                                       transition-all duration-500 opacity-100 animate-fade-in">

            <!-- Ikon -->
            <div id="success-icon-wrapper" class="flex-shrink-0">
                <!-- Spinner -->
                <svg id="success-spinner" class="w-6 h-6 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>

                <!-- Check -->
                <svg id="success-check" class="w-6 h-6 text-white hidden scale-75" fill="none" viewBox="0 0 24 24">
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <!-- Pesan -->
            <span class="flex-1 font-medium tracking-wide">{{ session('success') }}</span>

            <!-- Tombol Close -->
            <button onclick="document.getElementById('alert-success').remove()"
                class="text-white/70 hover:text-white font-bold transition-colors">
                ✕
            </button>

            <!-- Progress Bar -->
            <div
                class="absolute bottom-0 left-0 h-[3px] bg-white/70 w-full origin-left scale-x-0 animate-progress rounded-b-xl">
            </div>
        </div>

        <style>
            @keyframes fade-in {
                from {
                    opacity: 0;
                    transform: translateY(-12px) scale(0.98);
                }

                to {
                    opacity: 1;
                    transform: translateY(0) scale(1);
                }
            }

            @keyframes progress {
                from {
                    transform: scaleX(0);
                }

                to {
                    transform: scaleX(1);
                }
            }

            @keyframes pop {
                from {
                    transform: scale(0.6);
                    opacity: 0;
                }

                to {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            .animate-fade-in {
                animation: fade-in 0.4s ease-out;
            }

            .animate-progress {
                animation: progress 3s linear forwards;
            }

            .animate-pop {
                animation: pop 0.3s ease-out;
            }
        </style>

        <script>
            // Ganti spinner jadi centang dengan animasi pop
            setTimeout(() => {
                document.getElementById('success-spinner').classList.add('hidden');
                const check = document.getElementById('success-check');
                check.classList.remove('hidden');
                check.classList.add('animate-pop');
            }, 800);

            // Auto hide notif setelah 3.5 detik
            setTimeout(() => {
                const alert = document.getElementById('alert-success');
                if (alert) {
                    alert.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => alert.remove(), 500);
                }
            }, 3500);
        </script>
    @endif

    @if (session('error'))
        <div id="alert-error"
            class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 opacity-100 animate-fade-in">
            <!-- Icon -->
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 text-center">DAFTAR ADUAN</h2>

            @component('components.riwayat-tabs')
            <div class="mb-4 mt-2 text-left">
                <a href="{{ route('beranda') }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Buat Aduan Baru
                </a>
            </div>

            <p class="text-sm text-gray-600 mb-3">Total: {{ $aduan->count() }} Aduan</p>

            <!-- RESPONSIVE TABLE -->
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full text-sm hidden md:table">
                    <thead class="bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">No. Tiket</th>
                            <th class="px-4 py-3 text-left">Judul</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($aduan as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $item->tracking_id }}</td>
                                <td class="px-4 py-2">{{ $item->judul }}</td>
                                <td class="px-4 py-2">
                                    {{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td class="px-4 py-2">
                                    <span
                                        class="text-xs font-semibold px-2 py-1 rounded-full
                                                                                                        @if($item->status == 'Diajukan') bg-red-100 text-red-700
                                                                                                        @elseif($item->status == 'Dibaca') bg-blue-100 text-blue-700
                                                                                                        @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                                                        @elseif($item->status == 'Selesai') bg-green-100 text-green-700
                                                                                                        @else bg-gray-200 text-gray-800 @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('reports.show', $item->id) }}" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                    Tidak ada aduan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- TABEL MOBILE RESPONSIF -->
                <div class="md:hidden space-y-4">
                    @forelse ($aduan as $index => $item)
                        <div class="rounded-xl shadow-lg overflow-hidden">
                            <!-- Header dengan gradasi -->
                            <div
                                class="bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] p-2 px-4 text-white text-xs flex justify-between">
                                <span>{{ $index + 1 }}. {{ $item->tracking_id }}</span>
                                <span>{{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            </div>

                            <!-- Konten card -->
                            <div class="bg-white text-gray-800 p-4">
                                <div class="font-bold text-base mb-2">
                                    {{ $item->judul }}
                                </div>

                                <div>
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full
                                                                                @if($item->status == 'Diajukan') bg-blue-100 text-blue-800
                                                                                @elseif($item->status == 'Dibaca') bg-teal-100 text-teal-800
                                                                                @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                                @elseif($item->status == 'Selesai') bg-green-100 text-green-800
                                                                                @else bg-gray-200 text-gray-800 @endif">
                                        {{ $item->status }}
                                    </span>
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('reports.show', $item->id) }}"
                                        class="inline-flex items-center text-sm text-red-700 font-semibold hover:text-[#8B1E1E] transition-colors duration-200">
                                        <i class="fas fa-search mr-1"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500">
                            Tidak ada aduan.
                        </div>
                    @endforelse
                </div>
            </div>
            @endcomponent
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const spinner = document.getElementById('success-spinner');
                const check = document.getElementById('success-check');

                setTimeout(() => {
                    if (spinner && check) {
                        spinner.classList.add('hidden');
                        check.classList.remove('hidden');
                        check.classList.add('scale-100');
                    }
                }, 1000);

                const fadeOutAndRemove = el => {
                    if (!el) return;
                    el.classList.remove('opacity-100');
                    el.classList.add('opacity-0');
                    setTimeout(() => el.style.display = 'none', 500);
                };

                setTimeout(() => {
                    fadeOutAndRemove(document.getElementById('alert-success'));
                    fadeOutAndRemove(document.getElementById('alert-error'));
                }, 3000);
            });
        </script>

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

    @endpush
@endsection