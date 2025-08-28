@extends('wbs_admin.layouts.app')

@section('page_title', 'Dashboard WBS Admin')

@section('content')
    <div class="container py-4">
        {{-- Flash Message --}}
        @if (session('success'))
            <div id="alert-success"
                class="fixed top-5 right-5 z-50 flex items-center justify-between gap-4 
                       w-[420px] max-w-[90vw] px-6 py-4 rounded-2xl shadow-2xl border border-red-400 
                       bg-gradient-to-r from-red-600 to-red-500/90 backdrop-blur-md text-white 
                       transition-all duration-500 opacity-100 animate-fade-in">
                <span class="flex-1 font-medium tracking-wide">{{ session('success') }}</span>
                <button onclick="document.getElementById('alert-success').remove()"
                    class="text-white/70 hover:text-white font-bold transition-colors">✕</button>
                <div
                    class="absolute bottom-0 left-0 h-[3px] bg-white/70 w-full origin-left scale-x-0 animate-progress rounded-b-xl">
                </div>
            </div>
        @endif

        <h2 class="mb-4 text-2xl font-semibold text-[#37474F]">
            Dashboard WBS Admin
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
                    class="p-4 text-white text-center rounded-2xl shadow-lg transition-transform duration-300 hover:scale-105 {{ $card['bg'] }}">
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
                        pointHoverBackgroundColor: '#D32F2F',
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { color: '#37474F' } },
                        y: {
                            beginAtZero: true,
                            ticks: { color: '#37474F' },
                            grid: { color: '#E0E0E0', borderDash: [5, 5] }
                        }
                    },
                    animation: { duration: 1000, easing: 'easeOutQuart' }
                }
            });

            document.getElementById('rangeSelector').addEventListener('change', function () {
                const selectedRange = this.value;
                document.getElementById('judulAktivitas').innerText = `Grafik Aktivitas Aduan ${labelRange[selectedRange]}`;
                aktivitasChart.data.labels = aktivitasData[selectedRange].tanggal;
                aktivitasChart.data.datasets[0].data = aktivitasData[selectedRange].jumlah;
                aktivitasChart.update();
            });
        });
    </script>
@endpush
