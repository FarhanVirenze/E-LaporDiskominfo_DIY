@extends('portal.layouts.appnofooter')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')

    <div class="w-full max-w-screen-xl mx-auto py-16 px-3 sm:px-6 text-gray-800">
        <h1 class="text-2xl font-bold text-center mt-12 text-gray-900">
            Riwayat Aduan
        </h1>

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div id="alert-success"
                class="fixed top-5 right-5 z-50 flex items-center justify-between gap-4 
                                                                                                                                                                                                               w-[420px] max-w-[90vw] px-6 py-4 rounded-2xl shadow-2xl border border-red-400 
                                                                                                                                                                                                               bg-gradient-to-r from-red-600 to-red-500/90 backdrop-blur-md text-white 
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
                        <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M5 13l4 4L19 7" />
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
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        <div class="py-12" x-data="{ view: 'table' }"> {{-- ✅ Alpine toggle view --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                @component('components.riwayat-tabs')
                <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
                    {{-- ✅ Total Aduan (hanya desktop) --}}
                    <p class="text-sm text-gray-600 hidden md:block">Total: {{ $aduan->total() }} Aduan</p>

                    {{-- ✅ Toggle View Desktop --}}
                    <div class="hidden md:flex items-center rounded-full border border-red-300 overflow-hidden">
                        {{-- Table View --}}
                        <button @click="view = 'table'" :class="view === 'table' 
                                                            ? 'bg-red-600 text-white' 
                                                            : 'bg-white text-gray-700 hover:bg-gray-50'"
                            class="px-4 py-2 flex items-center gap-1 transition">
                            <template x-if="view === 'table'">
                                <i class="fas fa-check mr-1"></i>
                            </template>
                            <i class="fas fa-list"></i>
                        </button>

                        {{-- Card View --}}
                        <button @click="view = 'card'" :class="view === 'card' 
                                                            ? 'bg-red-600 text-white' 
                                                            : 'bg-white text-gray-700 hover:bg-gray-50'"
                            class="px-4 py-2 flex items-center gap-1 transition border-l border-red-300">
                            <template x-if="view === 'card'">
                                <i class="fas fa-check mr-1"></i>
                            </template>
                            <i class="fas fa-border-all"></i>
                        </button>
                    </div>
                </div>

                {{-- ✅ Desktop: Tabel --}}
                <div x-show="view === 'table'" style="display:none"
                    class="overflow-x-auto bg-white/80 backdrop-blur-sm shadow-xl rounded-2xl border border-red-100 hidden md:block">
                    <table class="min-w-full text-sm">
                        <thead class="bg-gradient-to-r from-red-700 to-red-500 text-white">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold">No</th>
                                <th class="px-4 py-3 text-left font-semibold">No Aduan</th>
                                <th class="px-4 py-3 text-left font-semibold">Judul</th>
                                <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                                <th class="px-4 py-3 text-left font-semibold">Status</th>
                                <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse ($aduan as $index => $item)
                                <tr class="hover:bg-blue-50 transition-colors duration-200">
                                    <td class="px-4 py-3 font-medium text-gray-700">{{ $aduan->firstItem() + $index }}</td>
                                    <td class="px-4 py-3 font-semibold text-gray-700">{{ $item->tracking_id }}</td>
                                    <td class="px-4 py-3">{{ $item->judul }}</td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <span
                                            class="text-xs font-semibold px-3 py-1 rounded-full shadow-sm
                                                                                                                                                            @if($item->status == 'Diajukan') bg-red-100 text-red-700
                                                                                                                                                            @elseif($item->status == 'Dibaca') bg-blue-100 text-blue-700
                                                                                                                                                            @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                                                                                                            @elseif($item->status == 'Selesai') bg-green-100 text-green-700
                                                                                                                                                            @elseif($item->status == 'Arsip') bg-stone-700 text-white
                                                                                                                                                            @else bg-gray-200 text-gray-800 @endif">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('reports.show', $item->id) }}"
                                            class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 transition-colors">
                                            <i class="fas fa-search"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">Tidak ada aduan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- ✅ Desktop: Card/Grid --}}
                <div x-show="view === 'card'" style="display:none" class="hidden md:grid grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse ($aduan as $index => $item)
                        @php
                            $defaultImage = asset('images/image.jpg');
                            $thumbnail = $defaultImage;

                            if (!empty($item->file)) {
                                $files = is_array($item->file) ? $item->file : json_decode($item->file, true);
                                if (is_array($files)) {
                                    foreach ($files as $f) {
                                        $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                            $thumbnail = asset($f);
                                            break;
                                        }
                                    }
                                }
                            }
                        @endphp

                        <div
                            class="rounded-2xl overflow-hidden shadow-md border border-gray-100 bg-white hover:shadow-xl transition-all">
                            {{-- Foto Thumbnail --}}
                            <div class="relative group cursor-pointer overflow-hidden rounded-t-2xl"
                                onclick="openImageModal('{{ $thumbnail }}')">
                                <img src="{{ $thumbnail }}" alt="Foto Aduan"
                                    class="w-full h-48 md:h-56 object-cover transition duration-300 group-hover:brightness-75">
                            </div>

                            {{-- Header Info --}}
                            <div
                                class="bg-gradient-to-r from-red-700 to-red-500 p-3 px-4 text-white text-xs flex justify-between items-center">
                                <div>
                                    <span class="font-semibold">{{ $aduan->firstItem() + $index }}.
                                        {{ $item->tracking_id }}</span><br>
                                    <span>{{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                </div>
                                <span class="text-[11px] font-semibold px-3 py-1 rounded-full shadow-sm
                                                                                    @if($item->status == 'Diajukan') bg-red-100 text-red-700
                                                                                    @elseif($item->status == 'Dibaca') bg-blue-100 text-blue-700
                                                                                    @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                                    @elseif($item->status == 'Selesai') bg-green-100 text-green-700
                                                                                      @elseif($item->status == 'Arsip') bg-stone-700 text-white
                                                                                    @else bg-gray-200 text-gray-800 @endif">
                                    {{ $item->status }}
                                </span>
                            </div>

                            {{-- Body Info --}}
                            <div class="bg-white text-gray-800 p-4 flex justify-between items-center">
                                <div class="font-semibold text-base text-gray-700">
                                    {{ \Illuminate\Support\Str::limit($item->judul, 40, '...') }}
                                </div>
                                <a href="{{ route('reports.show', $item->id) }}"
                                    class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-800 transition-colors">
                                    <i class="fas fa-search mr-1"></i> Lihat
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500 col-span-3">Tidak ada aduan.</div>
                    @endforelse
                </div>

                {{-- ✅ Mobile: List & Card dengan Toggle --}}
                <div class="md:hidden" x-data="{ view: 'list' }">
                    {{-- ✅ Header: Toggle View Mobile --}}
                    <div class="flex items-center justify-between mb-3 px-2">
                        <p class="text-sm text-gray-600">Total: {{ $aduan->total() }} Aduan</p>
                        <div class="flex items-center rounded-full border border-red-300 overflow-hidden">
                            {{-- List View --}}
                            <button @click="view = 'list'" :class="view === 'list' 
                                        ? 'bg-red-600 text-white' 
                                        : 'bg-white text-gray-700 hover:bg-gray-50'"
                                class="px-3 py-1.5 flex items-center gap-1 text-sm transition">
                                <template x-if="view === 'list'">
                                    <i class="fas fa-check mr-1"></i>
                                </template>
                                <i class="fas fa-list"></i>
                            </button>

                            {{-- Card View --}}
                            <button @click="view = 'card'" :class="view === 'card' 
                                        ? 'bg-red-600 text-white' 
                                        : 'bg-white text-gray-700 hover:bg-gray-50'"
                                class="px-3 py-1.5 flex items-center gap-1 text-sm transition border-l border-red-300">
                                <template x-if="view === 'card'">
                                    <i class="fas fa-check mr-1"></i>
                                </template>
                                <i class="fas fa-border-all"></i>
                            </button>
                        </div>
                    </div>

                    {{-- ✅ Mobile: List --}}
                    <div x-show="view === 'list'" style="display: none" class="space-y-4 p-2">
                        @forelse ($aduan as $index => $item)
                            <div
                                class="rounded-2xl overflow-hidden shadow-md border border-gray-100 bg-white hover:shadow-xl transition-all">
                                <div
                                    class="bg-gradient-to-r from-red-700 to-red-500 p-3 px-4 text-white text-xs flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold">{{ $aduan->firstItem() + $index }}.
                                            {{ $item->tracking_id }}</span><br>
                                        <span>{{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                    </div>
                                    <span class="text-[11px] font-semibold px-3 py-1 rounded-full shadow-sm
                                                                                @if($item->status == 'Diajukan') bg-red-100 text-red-700
                                                                                @elseif($item->status == 'Dibaca') bg-blue-100 text-blue-700
                                                                                @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                                @elseif($item->status == 'Selesai') bg-green-100 text-green-700
                                                                                  @elseif($item->status == 'Arsip') bg-stone-700 text-white
                                                                                @else bg-gray-200 text-gray-800 @endif">
                                        {{ $item->status }}
                                    </span>
                                </div>
                                <div class="bg-white text-gray-800 p-4 flex justify-between items-center">
                                    <div class="font-semibold text-base text-gray-700">
                                        {{ $item->judul }}
                                    </div>
                                    <a href="{{ route('reports.show', $item->id) }}"
                                        class="inline-flex items-center text-sm font-semibold text-red-600 hover:text-red-800 transition-colors">
                                        <i class="fas fa-search mr-1"></i> Lihat
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500">Tidak ada aduan.</div>
                        @endforelse
                    </div>

                    {{-- ✅ Mobile: Card/Grid --}}
                    <div x-show="view === 'card'" style="display: none" class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-2">
                        @forelse ($aduan as $index => $item)
                            @php
                                $defaultImage = asset('images/image.jpg');
                                $thumbnail = $defaultImage;

                                if (!empty($item->file)) {
                                    $files = is_array($item->file) ? $item->file : json_decode($item->file, true);
                                    if (is_array($files)) {
                                        foreach ($files as $f) {
                                            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                $thumbnail = asset($f);
                                                break;
                                            }
                                        }
                                    }
                                }
                            @endphp

                            <div
                                class="rounded-2xl overflow-hidden shadow-md border border-gray-100 bg-white hover:shadow-xl transition-all">
                                {{-- Foto Thumbnail --}}
                                <div class="relative group cursor-pointer overflow-hidden rounded-t-2xl"
                                    onclick="openImageModal('{{ $thumbnail }}')">
                                    <img src="{{ $thumbnail }}" alt="Foto Aduan"
                                        class="w-full h-40 object-cover transition duration-300 group-hover:brightness-75">
                                </div>

                                {{-- Info --}}
                                <div
                                    class="bg-gradient-to-r from-red-700 to-red-500 p-2 px-3 text-white text-xs flex justify-between items-center">
                                    <div>
                                        <span class="font-semibold">{{ $aduan->firstItem() + $index }}.
                                            {{ $item->tracking_id }}</span><br>
                                        <span>{{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMM YYYY') }}</span>
                                    </div>
                                    <span class="text-[11px] font-semibold px-2 py-1 rounded-full shadow-sm
                                                                                @if($item->status == 'Diajukan') bg-red-100 text-red-700
                                                                                @elseif($item->status == 'Dibaca') bg-blue-100 text-blue-700
                                                                                @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                                @elseif($item->status == 'Selesai') bg-green-100 text-green-700
                                                                                  @elseif($item->status == 'Arsip') bg-stone-700 text-white
                                                                                @else bg-gray-200 text-gray-800 @endif">
                                        {{ $item->status }}
                                    </span>
                                </div>

                                <div class="bg-white text-gray-800 p-3 flex justify-between items-center">
                                    <div class="font-semibold text-sm text-gray-700 truncate">
                                        {{ $item->judul }}
                                    </div>
                                    <a href="{{ route('reports.show', $item->id) }}"
                                        class="inline-flex items-center text-xs font-semibold text-red-600 hover:text-red-800 transition-colors">
                                        <i class="fas fa-search mr-1"></i> Lihat
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="p-4 text-center text-gray-500 col-span-2">Tidak ada aduan.</div>
                        @endforelse
                    </div>
                </div>
                {{-- ✅ Pagination --}}
                <div class="mt-10 mb-16 lg:mt-4 lg:mb-6 px-2">
                    {{ $aduan->links() }}
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