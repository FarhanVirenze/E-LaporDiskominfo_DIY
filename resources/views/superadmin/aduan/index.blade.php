@extends('superadmin.layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 mt-4 font-weight-bold">Kelola Aduan Umum</h1>

        @if(session('success'))
            <div id="alert-success" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table to display Aduan -->
        @if($reports->isEmpty())
            <div class="alert alert-info">
                Tidak ada aduan saat ini.
            </div>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td>{{ $report->judul }}</td>
                            <td>
                                <!-- Menampilkan Status dengan warna berbeda -->
                                <span class="status-text
                                                                        @if($report->status == 'Diajukan') bg-blue-200 text-blue-800
                                                                        @elseif($report->status == 'Dibaca') bg-teal-200 text-teal-800
                                                                        @elseif($report->status == 'Direspon') bg-yellow-200 text-yellow-800
                                                                        @elseif($report->status == 'Selesai') bg-green-200 text-green-800
                                                                        @endif
                                                                        rounded-full px-2 py-1 text-xs font-semibold">
                                    {{ $report->status }}
                                </span>
                            </td>
                            <td>
        

                                    <!-- Detail button, redirects to the detail page -->
                                    <a href="{{ route('superadmin.reports.show', ['id' => $report->id]) }}"
                                        class="btn btn-info btn-sm">Lihat</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $reports->links() }} <!-- Pagination links -->
            </div>
        @endif

        @push('scripts')
            <script>
                // Auto-hide success alert after 3 seconds
                @if(session('success'))
                    setTimeout(function () {
                        // Tutup alert setelah 3 detik
                        $('#alert-success').fadeOut('slow');
                    }, 3000);
                @endif
            </script>
        @endpush

@endsection