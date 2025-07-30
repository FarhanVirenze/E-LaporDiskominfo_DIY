@extends('superadmin.layouts.app')

@section('page_title', 'Superadmin Dashboard')

@section('content')
    <div class="container py-4">

        <!-- Flash Message -->
        @if (session('success'))
            <div id="alert-success"
                class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 opacity-100 animate-fade-in">
                <svg id="success-spinner" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>
                <svg id="success-check" class="w-6 h-6 text-white hidden" fill="none" viewBox="0 0 24 24">
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <h2 class="mb-4 text-2xl font-semibold text-[#37474F]">Dashboard Superadmin</h2>

        <div class="row g-4">
            <!-- Kartu Dashboard -->
            @php
                $cards = [
                    ['title' => 'Total Pengguna', 'count' => $totalUsers, 'icon' => 'bi-people-fill', 'bg' => 'bg-primary'],
                    ['title' => 'Total User', 'count' => $userCount, 'icon' => 'bi-person-circle', 'bg' => 'bg-info'],
                    ['title' => 'Total Admin', 'count' => $adminCount, 'icon' => 'bi-shield-lock-fill', 'bg' => 'bg-danger'],
                    ['title' => 'Total Aduan', 'count' => $totalReports, 'icon' => 'bi-file-earmark-text-fill', 'bg' => 'bg-success'],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="card material-card text-white text-center p-3 {{ $card['bg'] }}">
                        <i class="bi {{ $card['icon'] }} material-icon"></i>
                        <h6 class="material-subtitle text-white">{{ $card['title'] }}</h6>
                        <h3 class="material-title text-white">{{ $card['count'] }}</h3>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Charts -->
        <div class="row mt-5 g-4">
            <div class="col-12 col-lg-6">
                <div class="card material-card p-4 h-100 bg-white">
                    <h5 class="text-center text-[#37474F] mb-3">Distribusi Role Pengguna</h5>
                    <div style="position: relative; height: 350px;">
                        <canvas id="userRoleChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card material-card p-4 h-100 bg-white">
                    <h5 class="text-center text-[#37474F] mb-3">Distribusi Status Aduan</h5>
                    <div style="position: relative; height: 300px;">
                        <canvas id="reportStatusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Bar Chart Role Pengguna
            new Chart(document.getElementById('userRoleChart'), {
                type: 'bar',
                data: {
                    labels: ['User', 'Admin'],
                    datasets: [{
                        label: 'Jumlah Pengguna',
                        data: [{{ $userCount }}, {{ $adminCount }}],
                        backgroundColor: ['#1976D2', '#D32F2F'], // Material Blue & Red
                        borderRadius: 8,
                        hoverBackgroundColor: ['#1565C0', '#C62828']
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#333',
                            bodyColor: '#444',
                            borderColor: '#ddd',
                            borderWidth: 1,
                            titleFont: { weight: '600' },
                            bodyFont: { weight: '500' },
                            callbacks: {
                                label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y}`
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#37474F',
                                font: { weight: '500' }
                            },
                            grid: { display: false }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#37474F',
                                stepSize: 1,
                                font: { weight: '500' }
                            },
                            grid: {
                                color: '#e0e0e0',
                                borderDash: [4, 4]
                            }
                        }
                    }
                }
            });

            // Pie Chart Status Laporan
            new Chart(document.getElementById('reportStatusChart'), {
                type: 'pie',
                data: {
                    labels: ['Diajukan', 'Dibaca', 'Direspon', 'Selesai'],
                    datasets: [{
                        data: [{{ $pendingCount }}, {{ $readCount }}, {{ $respondedCount }}, {{ $completedCount }}],
                        backgroundColor: ['#F44336', '#2196F3', '#FFC107', '#4CAF50'], // Material Red, Blue, Yellow, Green
                        borderColor: '#fff',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                color: '#37474F',
                                font: { size: 14, weight: '500' },
                                usePointStyle: true,
                                padding: 20
                            }
                        },
                        tooltip: {
                            backgroundColor: '#fff',
                            titleColor: '#333',
                            bodyColor: '#444',
                            borderColor: '#ddd',
                            borderWidth: 1,
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

            const spinner = document.getElementById('success-spinner');
            const check = document.getElementById('success-check');

            setTimeout(() => {
                if (spinner && check) {
                    spinner.classList.add('hidden');
                    check.classList.remove('hidden');
                    check.classList.add('scale-100');
                }
            }, 1000); // ganti spinner ke check setelah 1 detik

            // Fade-out seluruh alert setelah 3 detik
            const fadeOutAndRemove = (el) => {
                if (!el) return;
                el.classList.remove('opacity-100');
                el.classList.add('opacity-0');
                setTimeout(() => {
                    el.style.display = 'none';
                }, 500); // durasi sama dengan transition
            };


            setTimeout(() => {
                fadeOutAndRemove(document.getElementById('alert-success'));
                fadeOutAndRemove(document.getElementById('alert-error'));
            }, 3000);
        });

    </script>
@endpush