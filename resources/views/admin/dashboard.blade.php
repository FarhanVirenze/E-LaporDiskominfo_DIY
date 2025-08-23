@extends('admin.layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
    <div class="container py-4">
        {{-- Flash Message --}}
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

        <h2 class="mb-4 text-2xl font-semibold text-[#37474F]">
            Dashboard Admin - {{ $adminName }}
        </h2>

        {{-- Kartu Statistik --}}
        @php
            $cards = [
                ['title' => 'Total Aduan', 'count' => $totalReports, 'icon' => 'bi-file-earmark-text-fill', 'bg' => 'bg-red-500'],
                ['title' => 'Anonim', 'count' => $anonimCount, 'icon' => 'bi-incognito', 'bg' => 'bg-blue-500'],
                ['title' => 'Terdaftar', 'count' => $registeredCount, 'icon' => 'bi-person-fill', 'bg' => 'bg-yellow-500'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($cards as $card)
                <div
                    class="p-4 text-white text-center rounded-2xl shadow-lg transition-transform duration-300 hover:scale-105 {{ $card['bg'] ?? 'bg-gradient-to-br from-[#2962FF] to-[#0039CB]' }}">
                    <i class="bi {{ $card['icon'] }} text-3xl mb-2"></i>
                    <h6 class="text-sm font-medium opacity-90">{{ $card['title'] }}</h6>
                    <h3 class="text-3xl font-bold">{{ $card['count'] }}</h3>
                </div>
            @endforeach
        </div>

        {{-- Charts --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 mt-6">

            {{-- Status Aduan --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <h5 class="text-center text-[#37474F] mb-3 font-semibold">Distribusi Status Aduan</h5>
                <div class="relative h-[325px]">
                    <canvas id="reportStatusChart"></canvas>
                </div>
            </div>

            {{-- Wilayah --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <h5 class="text-center text-[#37474F] mb-3 font-semibold">Distribusi Wilayah</h5>
                <div class="relative h-[325px]">
                    <canvas id="wilayahChart"></canvas>
                </div>
            </div>

            {{-- Kategori --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <h5 class="text-center text-[#37474F] mb-3 font-semibold">Kategori Aduan</h5>
                <div class="relative h-[325px]">
                    <canvas id="kategoriChart"></canvas>
                </div>
            </div>

            {{-- Grafik Aktivitas --}}
            <div class="bg-white rounded-xl p-5 shadow-md xl:col-span-3">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                    <h5 id="judulAktivitas" class="text-[#37474F] font-semibold">
                        Grafik Aktivitas Aduan
                    </h5>
                    <div class="w-full sm:w-auto">
                        <select id="rangeSelector"
                            class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="7" selected>1 Minggu</option>
                            <option value="30">1 Bulan</option>
                            <option value="60">2 Bulan</option>
                            <option value="90">3 Bulan</option>
                        </select>
                    </div>
                </div>
                <div class="relative h-[350px] w-full">
                    <canvas id="aktivitasChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
@endsection

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const materialPalette = ['#1E88E5', '#D32F2F', '#43A047', '#FB8C00', '#8E24AA', '#FDD835', '#00ACC1', '#6D4C41', '#C2185B', '#7CB342'];

                const chartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: { padding: 20 },
                    plugins: {
                        legend: { position: 'bottom' },
                        tooltip: { usePointStyle: true }
                    }
                };

                // === WILAYAH DOUGHNUT ===
                new Chart(document.getElementById('wilayahChart'), {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($wilayahLabels) !!},
                        datasets: [{
                            data: {!! json_encode($wilayahCounts) !!},
                            backgroundColor: materialPalette,
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        ...chartOptions,
                        cutout: '60%',
                    }
                });

                // === STATUS PIE ===
                new Chart(document.getElementById('reportStatusChart'), {
                    type: 'pie',
                    data: {
                        labels: ['Diajukan', 'Dibaca', 'Direspon', 'Selesai'],
                        datasets: [{
                            data: [{{ $pendingCount }}, {{ $readCount }}, {{ $respondedCount }}, {{ $completedCount }}],
                            backgroundColor: ['#F44336', '#2196F3', '#FFC107', '#4CAF50'],
                            borderColor: '#fff',
                            borderWidth: 2
                        }]
                    },
                    options: chartOptions
                });

                // === KATEGORI BAR ===
                new Chart(document.getElementById('kategoriChart'), {
                    type: 'bar',
                    data: {
                        labels: {!! json_encode($kategoriUmumData['all']['labels']) !!},
                        datasets: [{
                            label: 'Jumlah',
                            data: {!! json_encode($kategoriUmumData['all']['counts']) !!},
                            backgroundColor: materialPalette,
                        }]
                    },
                    options: {
                        ...chartOptions,
                        scales: {
                            x: { ticks: { color: '#37474F' }, grid: { display: false } },
                            y: { beginAtZero: true, ticks: { color: '#37474F' } }
                        }
                    }
                });

                // === AKTIVITAS ===
                const aktivitasData = {!! json_encode($aktivitasSemuaRange) !!};
                const labelRange = { '7': '1 Minggu', '30': '1 Bulan', '60': '2 Bulan', '90': '3 Bulan' };

                const defaultRange = document.getElementById('rangeSelector').value;
                document.getElementById('judulAktivitas').innerText = `Grafik Aktivitas Aduan ${labelRange[defaultRange]}`;

                const ctx = document.getElementById('aktivitasChart').getContext('2d');

                // Buat gradient background
                const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                gradient.addColorStop(0, "rgba(41, 98, 255, 0.3)");
                gradient.addColorStop(1, "rgba(41, 98, 255, 0)");

                let aktivitasChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: aktivitasData[defaultRange].tanggal,
                        datasets: [{
                            label: 'Aktivitas Aduan',
                            data: aktivitasData[defaultRange].jumlah,
                            borderColor: '#2962FF',
                            backgroundColor: gradient,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: '#2962FF',
                            pointBorderColor: '#fff',
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            pointHoverBackgroundColor: '#D32F2F', // titik berubah merah saat hover
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }, // legend disembunyikan
                            tooltip: {
                                backgroundColor: '#37474F',
                                titleColor: '#fff',
                                bodyColor: '#fff',
                                cornerRadius: 8,
                                callbacks: {
                                    label: function (context) {
                                        return ` ${context.parsed.y} laporan`;
                                    }
                                }
                            }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: { color: '#37474F' }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: { color: '#37474F' },
                                grid: { color: '#E0E0E0', borderDash: [5, 5] } // garis putus-putus
                            }
                        },
                        animation: {
                            duration: 1000,
                            easing: 'easeOutQuart'
                        }
                    }
                });

                // Update chart saat ganti range
                document.getElementById('rangeSelector').addEventListener('change', function () {
                    const selectedRange = this.value;
                    document.getElementById('judulAktivitas').innerText = `Grafik Aktivitas Aduan ${labelRange[selectedRange]}`;
                    aktivitasChart.data.labels = aktivitasData[selectedRange].tanggal;
                    aktivitasChart.data.datasets[0].data = aktivitasData[selectedRange].jumlah;
                    aktivitasChart.update();
                });
            });

            // === Flash message ===
            const spinner = document.getElementById('success-spinner');
            const check = document.getElementById('success-check');
            setTimeout(() => {
                if (spinner && check) {
                    spinner.classList.add('hidden');
                    check.classList.remove('hidden');
                    check.classList.add('scale-100', 'transition-transform', 'duration-300');
                }
            }, 1000);

            setTimeout(() => {
                const el = document.getElementById('alert-success');
                if (el) {
                    el.classList.remove('opacity-100');
                    el.classList.add('opacity-0');
                    setTimeout(() => el.style.display = 'none', 500);
                }
            }, 3000);
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