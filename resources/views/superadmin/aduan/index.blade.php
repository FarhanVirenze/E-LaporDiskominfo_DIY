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
                                <span
                                    class="status-text
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

                                <!-- Button Actions: Edit, Hapus, Detail -->
                                <div class="d-flex gap-2">
                                    <!-- Edit button, triggers the edit modal -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editAduanModal"
                                        data-id="{{ $report->id }}" data-judul="{{ $report->judul }}"
                                        data-status="{{ $report->status }}">
                                        Edit
                                    </button>

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

        <!-- Edit Aduan Modal -->
        <div class="modal fade" id="editAduanModal" tabindex="-1" role="dialog" aria-labelledby="editAduanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" id="editAduanForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select name="status" id="editStatus" class="form-control" required>
                                    <option value="Diajukan">Diajukan</option>
                                    <option value="Dibaca">Dibaca</option>
                                    <option value="Direspon">Direspon</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @push('scripts')
            <script>
                // Set data for editing
                $('#editAduanModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var status = button.data('status');

                    var modal = $(this);
                    modal.find('#editStatus').val(status); // Set status field value
                    modal.find('#editAduanForm').attr('action', '/superadmin/kelola-aduan/' + id); // Set form action
                });
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