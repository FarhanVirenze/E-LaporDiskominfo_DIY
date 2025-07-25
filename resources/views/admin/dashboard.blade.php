@extends('admin.layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
    <div class="container">
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

        <h1>Welcome to the Admin Dashboard</h1>
        <p>Admin content goes here...</p>

        <div class="row">
            <!-- Chart for Report Counts -->
            <div class="col-md-6">
                <h3>Report Status</h3>
                <canvas id="reportStatusChart"></canvas>
            </div>

            <!-- Chart for User Counts -->
            <div class="col-md-6">
                <h3>User Roles</h3>
                <canvas id="userRoleChart"></canvas>
            </div>
        </div>
    </div>

    @section('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var reportStatusData = {
                    labels: ['Pending', 'In Progress', 'Completed'],
                    datasets: [{
                        label: 'Laporan Status',
                        data: [{{ $pendingCount }}, {{ $inProgressCount }}, {{ $completedCount }}],
                        backgroundColor: ['#ff9999', '#66b3ff', '#99ff99'],
                        borderColor: ['#ff6666', '#3399ff', '#66cc66'],
                        borderWidth: 1
                    }]
                };

                var reportStatusConfig = {
                    type: 'pie',
                    data: reportStatusData,
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' reports';
                                    }
                                }
                            }
                        }
                    }
                };

                var reportStatusChart = new Chart(
                    document.getElementById('reportStatusChart'),
                    reportStatusConfig
                );

                var userRoleData = {
                    labels: ['Admins', 'Users'],
                    datasets: [{
                        label: 'Users by Role',
                        data: [{{ $adminCount }}, {{ $userCount }}],
                        backgroundColor: ['#ffcc99', '#66ff66'],
                        borderColor: ['#ff9933', '#33cc33'],
                        borderWidth: 1
                    }]
                };

                var userRoleConfig = {
                    type: 'bar',
                    data: userRoleData,
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw + ' users';
                                    }
                                }
                            }
                        }
                    }
                };

                var userRoleChart = new Chart(
                    document.getElementById('userRoleChart'),
                    userRoleConfig
                );
            });
        </script>
    @endsection
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Transisi Spinner ke Centang
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

        check.classList.remove('hidden');
        check.classList.add('scale-100'); // Smooth zoom-in
    </script>
@endpush