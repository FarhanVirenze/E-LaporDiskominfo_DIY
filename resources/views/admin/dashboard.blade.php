@extends('admin.layouts.app')

@section('page_title', 'Admin Dashboard')

@section('content')
    <div class="container">
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
        document.addEventListener('DOMContentLoaded', function() {
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
                                label: function(tooltipItem) {
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
                                label: function(tooltipItem) {
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
