@extends('admin.layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
    <div class="container py-4">
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
                    <h5 class="text-center mb-3">Distribusi Status Laporan</h5>
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
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
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
        });
    </script>
@endpush