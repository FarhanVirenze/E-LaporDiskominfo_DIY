@extends('wbs_admin.layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4 mt-4 font-weight-bold">Kelola WBS Aduan</h1>

    {{-- Flash message --}}
    @if(session('success'))
        <div id="alert-success" class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Filter Status --}}
    <div class="mb-3">
        <form method="GET" action="{{ route('wbs_admin.kelola-aduan.index') }}" class="form-inline">
            <label for="status" class="mr-2">Filter Status:</label>
            <select name="status" id="status" class="form-control mr-2" onchange="this.form.submit()">
                <option value="">-- Semua Status --</option>
                <option value="Diajukan" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="Dibaca" {{ request('status') == 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
                <option value="Direspon" {{ request('status') == 'Direspon' ? 'selected' : '' }}>Direspon</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </form>
    </div>

    {{-- Table --}}
    @if($reports->isEmpty())
        <div class="alert alert-info">Tidak ada aduan saat ini.</div>
    @else
        <table class="table table-striped table-bordered">
            <thead class="bg-gradient-to-r from-red-700 to-rose-500 text-white">
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
                            <span class="status-text
                                @if($report->status == 'Diajukan') bg-red-200 text-red-800
                                @elseif($report->status == 'Dibaca') bg-blue-200 text-blue-800
                                @elseif($report->status == 'Direspon') bg-yellow-200 text-yellow-800
                                @elseif($report->status == 'Selesai') bg-green-200 text-green-800
                                @endif
                                rounded-full px-2 py-1 text-xs font-semibold">
                                {{ $report->status }}
                            </span>
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                {{-- Edit --}}
                                <button class="btn btn-warning btn-sm"
                                    data-toggle="modal"
                                    data-target="#editAduanModal"
                                    data-id="{{ $report->id }}"
                                    data-status="{{ $report->status }}">
                                    Edit
                                </button>

                                {{-- Hapus --}}
                                <button class="btn btn-danger btn-sm"
                                    data-toggle="modal"
                                    data-target="#deleteAduanModal"
                                    data-id="{{ $report->id }}"
                                    data-judul="{{ $report->judul }}">
                                    Hapus
                                </button>

                                {{-- Lihat --}}
                                <a href="{{ route('wbs_admin.reports.show', $report->id) }}"
                                   class="btn btn-info btn-sm">Lihat</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center">
            {{ $reports->appends(request()->query())->links() }}
        </div>
    @endif
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editAduanModal" tabindex="-1">
    <div class="modal-dialog">
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

{{-- Delete Modal --}}
<div class="modal fade" id="deleteAduanModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="deleteAduanForm">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus Aduan</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus aduan <strong id="aduanJudul"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Edit
    $('#editAduanModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var status = button.data('status');
        var modal = $(this);
        modal.find('#editStatus').val(status);
        modal.find('#editAduanForm').attr('action', '/wbs_admin/kelola-aduan/' + id);
    });

    // Delete
    $('#deleteAduanModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var judul = button.data('judul');
        var modal = $(this);
        modal.find('#aduanJudul').text(judul);
        modal.find('#deleteAduanForm').attr('action', '/wbs_admin/kelola-aduan/' + id);
    });

    // Auto-hide success
    @if(session('success'))
        setTimeout(function () {
            $('#alert-success').fadeOut('slow');
        }, 3000);
    @endif
</script>
@endpush
@endsection
