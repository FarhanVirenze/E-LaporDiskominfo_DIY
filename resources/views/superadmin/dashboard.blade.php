@extends('superadmin.layouts.app')

@section('page_title', 'Superadmin Dashboard')

@section('content')
    <div class="container py-4">
        {{-- Flash Message --}}
        @if (session('success'))
            <div id="alert-success"
                class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 opacity-100 animate-fade-in">
                <svg id="success-spinner" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <svg id="success-check" class="w-6 h-6 text-white hidden transform scale-75" fill="none" viewBox="0 0 24 24">
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <h2 class="mb-4 text-2xl font-semibold text-[#37474F]">Dashboard Superadmin</h2>

        {{-- Kartu Statistik --}}
        @php
            $cards = [
                ['title' => 'Total Pengguna', 'count' => $totalUsers, 'icon' => 'bi-people-fill', 'bg' => 'bg-primary'],
                ['title' => 'Total User', 'count' => $userCount, 'icon' => 'bi-person-circle', 'bg' => 'bg-info'],
                ['title' => 'Total Admin', 'count' => $adminCount, 'icon' => 'bi-shield-lock-fill', 'bg' => 'bg-danger'],
                ['title' => 'Total Aduan', 'count' => $totalReports, 'icon' => 'bi-file-earmark-text-fill', 'bg' => 'bg-success'],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
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

            {{-- Distribusi Role & Jenis Pelapor --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <h5 class="text-center text-[#37474F] mb-3 font-semibold">Distribusi Role & Jenis Pelapor</h5>
                <div class="relative h-[325px]">
                    <canvas id="gabunganUserPelaporChart"></canvas>
                </div>
            </div>

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

            {{-- Top Kategori --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <h5 class="text-center text-[#37474F] mb-3 font-semibold">Top 10 Kategori Aduan</h5>
                <div class="relative h-[350px]">
                    <canvas id="kategoriChart"></canvas>
                </div>
            </div>

            {{-- Grafik Aktivitas --}}
           <div class="bg-white rounded-xl p-5 shadow-md">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-2">
                    <h5 class="text-[#37474F] font-semibold">
                        Grafik Aktivitas Laporan
                        @if($range == '7') (1 Minggu Terakhir)
                        @elseif($range == '30') (1 Bulan Terakhir)
                        @elseif($range == '60') (2 Bulan Terakhir)
                        @elseif($range == '90') (3 Bulan Terakhir)
                        @endif
                    </h5>
                    <form method="GET" action="{{ route('superadmin.dashboard') }}" class="w-full sm:w-auto">
                        <select name="range" onchange="this.form.submit()"
                            class="w-full sm:w-auto border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                            <option value="7" {{ $range == '7' ? 'selected' : '' }}>1 Minggu</option>
                            <option value="30" {{ $range == '30' ? 'selected' : '' }}>1 Bulan</option>
                            <option value="60" {{ $range == '60' ? 'selected' : '' }}>2 Bulan</option>
                            <option value="90" {{ $range == '90' ? 'selected' : '' }}>3 Bulan</option>
                        </select>
                    </form>
                </div>
                <div class="relative h-[323px]">
                    <canvas id="aktivitasChart"></canvas>
                </div>
            </div>

            {{-- Top Admin Penerima --}}
            <div class="bg-white rounded-xl p-5 shadow-md">
                <h5 class="text-center text-[#37474F] mb-3 font-semibold">Top 10 Admin Penerima Laporan</h5>
                <div class="relative h-[350px]">
                    <canvas id="topAdminChart"></canvas>
                </div>
            </div>

            {{-- Kategori per Admin --}}
            <div class="bg-white rounded-xl p-5 shadow-md sm:col-span-2 xl:col-span-3">
                <h5 class="text-center text-[#37474F] mb-3 font-semibold">Top 10 Kategori Aduan per Admin</h5>
                <div class="relative h-[450px]">
                    <canvas id="kategoriPerAdminChart"></canvas>
                </div>
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
                animation: {
                    duration: 1000,
                    easing: 'easeOutQuart'
                },
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#37474F',
                            font: { family: 'Inter, sans-serif', size: 14, weight: '500' },
                            usePointStyle: true,
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: '#fff',
                        titleColor: '#212121',
                        bodyColor: '#37474F',
                        borderColor: '#ddd',
                        borderWidth: 1,
                        padding: 12,
                        cornerRadius: 8,
                        usePointStyle: true
                    }
                },
                elements: {
                    bar: { borderRadius: 8, borderSkipped: false },
                    point: {
                        radius: 5,
                        hoverRadius: 7,
                        pointStyle: 'circle'
                    }
                }
            };

            // === GABUNGAN USER/PELAPOR ===
            new Chart(document.getElementById('gabunganUserPelaporChart'), {
                type: 'bar',
                data: {
                    labels: ['User (Role)', 'Admin (Role)', 'Anonim (Pelapor)', 'Terdaftar (Pelapor)'],
                    datasets: [{
                        label: 'Jumlah',
                        data: [{{ $userCount }}, {{ $adminCount }}, {{ $anonimCount }}, {{ $registeredCount }}],
                        backgroundColor: materialPalette.slice(0, 4)
                    }]
                },
                options: {
                    ...chartOptions,
                    plugins: {
                        ...chartOptions.plugins,
                        tooltip: {
                            ...chartOptions.plugins.tooltip,
                            callbacks: {
                                label: function (ctx) {
                                    const value = ctx.raw;
                                    return `${ctx.label}: ${value}`;
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: { color: '#37474F', font: { weight: '500' } },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#37474F', stepSize: 1 },
                            grid: { color: '#e0e0e0', borderDash: [4, 4] }
                        }
                    }
                }
            });

            // === KATEGORI PER ADMIN ===
            const kategoriAdminData = @json($kategoriAdminData);
            const adminLabels = kategoriAdminData.map(item => item.admin);
            const adminKategoriLabels = [...new Set(kategoriAdminData.flatMap(item => Object.keys(item.kategori)))];
            const adminDatasets = adminKategoriLabels.map((kategori, i) => ({
                label: kategori,
                data: kategoriAdminData.map(item => item.kategori[kategori] || 0),
                backgroundColor: materialPalette[i % materialPalette.length]
            }));

            new Chart(document.getElementById('kategoriPerAdminChart'), {
                type: 'bar',
                data: { labels: adminLabels, datasets: adminDatasets },
                options: {
                    ...chartOptions,
                    scales: {
                        x: { stacked: true },
                        y: { stacked: true, beginAtZero: true }
                    }
                }
            });

            // === TOP ADMIN ===
            new Chart(document.getElementById('topAdminChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($adminLabels) !!},
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: {!! json_encode($adminCounts) !!},
                        backgroundColor: materialPalette
                    }]
                },
                options: {
                    ...chartOptions,
                    indexAxis: 'y',
                    plugins: {
                        ...chartOptions.plugins,
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            reverse: true
                        }
                    }
                }
            });

            // === KATEGORI UMUM ===
            new Chart(document.getElementById('kategoriChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($kategoriLabels) !!},
                    datasets: [{
                        label: 'Jumlah Aduan',
                        data: {!! json_encode($kategoriCounts) !!},
                        backgroundColor: materialPalette
                    }]
                },
                options: {
                    ...chartOptions,
                    indexAxis: 'y',
                    plugins: {
                        ...chartOptions.plugins,
                        legend: { display: false }
                    }
                }
            });

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
                options: chartOptions
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
                options: {
                    ...chartOptions,
                    plugins: {
                        ...chartOptions.plugins,
                        tooltip: {
                            ...chartOptions.plugins.tooltip,
                            callbacks: {
                                label: function (ctx) {
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    const value = ctx.raw;
                                    const percent = ((value / total) * 100).toFixed(1);
                                    return `${ctx.label}: ${value} (${percent}%)`;
                                }
                            }
                        }
                    }
                }
            });

            // === LINE AKTIVITAS ===
            new Chart(document.getElementById('aktivitasChart'), {
                type: 'line',
                data: {
                    labels: {!! json_encode($tanggalAktivitas) !!},
                    datasets: [{
                        label: 'Jumlah Laporan',
                        data: {!! json_encode($jumlahAktivitas) !!},
                        borderColor: '#2962FF',
                        backgroundColor: 'rgba(41, 98, 255, 0.2)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#2962FF'
                    }]
                },
                options: {
                    ...chartOptions,
                    scales: {
                        x: {
                            ticks: { color: '#37474F' },
                            grid: { color: '#f0f0f0' }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#37474F' },
                            grid: { color: '#e0e0e0', borderDash: [4, 4] }
                        }
                    }
                }
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
        });
    </script>
@endpush