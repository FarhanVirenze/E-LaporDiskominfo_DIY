@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 mt-4 font-weight-bold">Kelola Aduan</h1>

        @if(session('success'))
            <div id="alert-success" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-3">
  <form method="GET" action="{{ route('admin.kelola-aduan.index') }}" class="form-inline">
        <label for="status" class="mr-2">Filter Status:</label>
        <select name="status" id="status" class="form-control mr-2" onchange="this.form.submit()">
            <option value="">-- Semua Status --</option>
            <option value="Diajukan" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
            <option value="Dibaca" {{ request('status') == 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
            <option value="Direspon" {{ request('status') == 'Direspon' ? 'selected' : '' }}>Direspon</option>
            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="Arsip" {{ request('status') == 'Arsip' ? 'selected' : '' }}>Arsip</option>
        </select>
    </form>
</div>

        <!-- Table to display Aduan -->
        @if($reports->isEmpty())
            <div class="alert alert-info">
                Tidak ada aduan saat ini.
            </div>
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
                                                @elseif($report->status == 'Arsip') bg-stone-700 text-white
                                                @endif
                                                rounded-full px-2 py-1 text-xs font-semibold">
                                    {{ $report->status }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editAduanModal"
                                        data-id="{{ $report->id }}" data-judul="{{ $report->judul }}"
                                        data-status="{{ $report->status }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteAduanModal"
                                        data-id="{{ $report->id }}" data-judul="{{ $report->judul }}">
                                        Hapus
                                    </button>

                                    <!-- Tombol Lihat -->
                                    <a href="{{ route('admin.reports.show', ['id' => $report->id]) }}"
                                        class="btn btn-info btn-sm">Lihat</a>

                                    <!-- Tombol Disposisi -->
                                    <button class="btn btn-success btn-sm" data-toggle="modal"
                                        data-target="#disposisiModal-{{ $report->id }}">
                                        Disposisi
                                    </button>
                                </div>

                                <!-- Modal Disposisi -->
<div class="modal fade" id="disposisiModal-{{ $report->id }}" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Disposisi Aduan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    {{-- Pilih Admin --}}
                    <div class="form-group">
                        <label>Pilih Admin</label>
                        <select name="admin_id" class="form-control"
                                id="adminSelect-{{ $report->id }}">
                            <option value="">-- Pilih Admin --</option>
                            @foreach(\App\Models\User::where('role','admin')->get() as $admin)
                                <option value="{{ $admin->id_user }}"
                                    {{ $report->admin_id == $admin->id_user ? 'selected' : '' }}>
                                    {{ $admin->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Pilih Kategori --}}
                    <div class="form-group">
                        <label>Pilih Kategori</label>
                        <select name="kategori_id" class="form-control"
                                id="kategoriSelect-{{ $report->id }}">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach(\App\Models\KategoriUmum::all() as $kategori)
                                <option value="{{ $kategori->id }}"
                                    data-admin="{{ $kategori->admin_id }}"
                                    {{ $report->kategori_id == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Modal Disposisi -->


                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
               {{ $reports->appends(request()->query())->links() }}
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
                                     <option value="Arsip">Arsip</option>
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

        <!-- Delete Aduan Modal -->
        <div class="modal fade" id="deleteAduanModal" tabindex="-1" role="dialog" aria-labelledby="deleteAduanModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" id="deleteAduanForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteAduanModalLabel">Konfirmasi Hapus Aduan</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus aduan <strong id="aduanJudul"></strong>?</p>
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
    // ========================
    // Edit
    // ========================
    $('#editAduanModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var status = button.data('status');
        var modal = $(this);
        modal.find('#editStatus').val(status);
        modal.find('#editAduanForm').attr('action', '/admin/kelola-aduan/' + id);
    });

    // ========================
    // Delete
    // ========================
    $('#deleteAduanModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var judul = button.data('judul');
        var modal = $(this);
        modal.find('#aduanJudul').text(judul);
        modal.find('#deleteAduanForm').attr('action', '/admin/kelola-aduan/' + id);
    });

    // ========================
    // Auto-hide success
    // ========================
    @if(session('success'))
        setTimeout(function () {
            $('#alert-success').fadeOut('slow');
        }, 3000);
    @endif

    // ========================
    // Filter kategori sesuai admin (per report)
    // ========================
    @foreach($reports as $report)
        $('#adminSelect-{{ $report->id }}').on('change', function () {
            var selectedAdmin = $(this).val();
            var kategoriSelect = $('#kategoriSelect-{{ $report->id }}');

            // sembunyikan semua kategori dulu
            kategoriSelect.find('option').hide();
            kategoriSelect.find('option[value=""]').show(); // opsi default

            // tampilkan kategori yang sesuai admin
            kategoriSelect.find('option[data-admin="' + selectedAdmin + '"]').show();

            // otomatis pilih kategori pertama yang sesuai admin
            var firstKategori = kategoriSelect.find('option[data-admin="' + selectedAdmin + '"]').first().val();
            if (firstKategori) {
                kategoriSelect.val(firstKategori);
            } else {
                kategoriSelect.val('');
            }
        }).trigger('change'); // langsung jalan saat modal dibuka
    @endforeach
</script>
@endpush


@endsection
