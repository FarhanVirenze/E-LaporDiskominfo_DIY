@extends('admin.layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
    <div class="container py-4">

        <!-- Notifikasi Sukses -->
        @if (session('success'))
            <div id="alert-success"
                class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 opacity-100 animate-fade-in">
                <!-- Icon Wrapper -->
                <div id="success-icon-wrapper" class="transition-all duration-300">
                    <!-- Spinner awal -->
                    <svg id="success-spinner" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    <!-- Centang, disembunyikan dulu -->
                    <svg id="success-check" class="w-6 h-6 text-white hidden" fill="none" viewBox="0 0 24 24">
                        <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <!-- Pesan -->
                <span>{{ session('success') }}</span>
            </div>
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
        <h2 class="mb-4 font-weight-bold">Dashboard Admin</h2>

        <div class="row g-4">
            <!-- Total Pengguna -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm rounded bg-primary text-white text-center p-3">
                    <i class="bi bi-people-fill fs-1 mb-2"></i>
                    <h6>Total Pengguna</h6>
                    <h3>{{ $totalUsers }}</h3>
                </div>
            </div>
            <!-- User -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm rounded bg-info text-white text-center p-3">
                    <i class="bi bi-person-circle fs-1 mb-2"></i>
                    <h6>Total User</h6>
                    <h3>{{ $userCount }}</h3>
                </div>
            </div>
            <!-- Admin -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm rounded bg-danger text-white text-center p-3">
                    <i class="bi bi-shield-lock-fill fs-1 mb-2"></i>
                    <h6>Total Admin</h6>
                    <h3>{{ $adminCount }}</h3>
                </div>
            </div>
            <!-- Laporan -->
            <div class="col-12 col-sm-6 col-md-3">
                <div class="card shadow-sm rounded bg-success text-white text-center p-3">
                    <i class="bi bi-file-earmark-text-fill fs-1 mb-2"></i>
                    <h6>Total Aduan</h6>
                    <h3>{{ $totalReports }}</h3>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="row mt-5 g-4">
            <!-- Bar Chart -->
            <div class="col-12 col-lg-6">
                <div class="card shadow rounded p-3 h-100">
                    <h5 class="text-center mb-3">Distribusi Role Pengguna</h5>
                    <div style="position: relative; height: 350px;">
                        <canvas id="userRoleChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Pie Chart -->
            <div class="col-12 col-lg-6">
                <div class="card shadow rounded p-3 h-100">
                    <h5 class="text-center mb-3">Distribusi Status Aduan</h5>
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
                        backgroundColor: ['#36A2EB', '#FF6384'],
                        borderRadius: 5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => `${ctx.dataset.label}: ${ctx.parsed.y}`
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
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
                        backgroundColor: ['#3B82F6', '#14B8A6', '#EAB308', '#22C55E'],
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
                            labels: { color: '#333' }
                        },
                        tooltip: {
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