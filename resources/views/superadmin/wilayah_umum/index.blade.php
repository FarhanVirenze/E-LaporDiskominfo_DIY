@extends('superadmin.layouts.app')

@section('title', 'Kelola Wilayah')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-2xl font-semibold text-[#37474F]">Kelola Wilayah</h2>

        @if(session('success'))
            <div id="alert-success" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tombol Tambah Wilayah -->
        <button class="px-4 py-2 mb-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition"
            data-toggle="modal" data-target="#addWilayahModal">
            Tambah Wilayah
        </button>

        <!-- Tabel Wilayah -->
        @if($wilayah->isEmpty())
            <div class="alert alert-info">
                Tidak ada wilayah saat ini.
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="bg-gradient-to-r from-blue-700 to-blue-500 text-white">
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Wilayah</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($wilayah as $index => $wil)
                            <tr>
                               <td class="text-center align-middle">
    {{ ($wilayah->currentPage() - 1) * $wilayah->perPage() + $loop->iteration }}
</td>
                                <td>{{ $wil->nama }}</td>
                                <td class="text-center">
                                    <div class="flex gap-2 justify-center flex-wrap">
                                        <button class="px-3 py-1 text-sm bg-yellow-400 hover:bg-yellow-500 text-white rounded"
                                            data-toggle="modal" data-target="#editWilayahModal"
                                            data-id="{{ $wil->id }}" data-nama="{{ $wil->nama }}">
                                            Edit
                                        </button>

                                        <button class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 text-white rounded"
                                            data-toggle="modal" data-target="#deleteWilayahModal"
                                            data-id="{{ $wil->id }}" data-nama="{{ $wil->nama }}">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $wilayah->links() }}
            </div>
        @endif

        <!-- Modal Tambah -->
        <div class="modal fade" id="addWilayahModal" tabindex="-1" role="dialog" aria-labelledby="addWilayahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('superadmin.kelola-wilayah.index') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Wilayah</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama Wilayah</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-success">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editWilayahModal" tabindex="-1" role="dialog" aria-labelledby="editWilayahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" id="editWilayahForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Wilayah</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="editWilayahNama">Nama Wilayah</label>
                                <input type="text" name="nama" id="editWilayahNama" class="form-control" required>
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

        <!-- Modal Hapus -->
        <div class="modal fade" id="deleteWilayahModal" tabindex="-1" role="dialog" aria-labelledby="deleteWilayahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" id="deleteWilayahForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Hapus Wilayah</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus wilayah <strong id="wilayahNama"></strong>?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Modal Edit
        $('#editWilayahModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nama = button.data('nama');

            const modal = $(this);
            modal.find('#editWilayahForm').attr('action', `/superadmin/kelola-wilayah/${id}`);
            modal.find('#editWilayahNama').val(nama);
        });

        // Modal Delete
        $('#deleteWilayahModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nama = button.data('nama');

            const modal = $(this);
            modal.find('#deleteWilayahForm').attr('action', `/superadmin/kelola-wilayah/${id}`);
            modal.find('#wilayahNama').text(nama);
        });

        // Auto-hide alert
        setTimeout(() => {
            $('#alert-success').fadeOut('slow');
        }, 3000);
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
<script>
    // ⚙️ Konfigurasi default NProgress
    NProgress.configure({
        showSpinner: false,
        trickleSpeed: 200,
        minimum: 0.08
    });

    // 🔹 1. Tangkap klik semua link internal
    document.addEventListener("click", function (e) {
        const link = e.target.closest("a");
        if (link && link.href && link.origin === window.location.origin) {
            NProgress.start();
            setTimeout(() => NProgress.set(0.9), 150);
        }
    });

    // 🔹 2. Patch untuk XMLHttpRequest
    (function (open) {
        XMLHttpRequest.prototype.open = function () {
            NProgress.start();
            this.addEventListener("loadend", function () {
                NProgress.set(1.0);
                setTimeout(() => NProgress.done(), 300);
            });
            open.apply(this, arguments);
        };
    })(XMLHttpRequest.prototype.open);

    // 🔹 3. Patch untuk Fetch API
    const originalFetch = window.fetch;
    window.fetch = function () {
        NProgress.start();
        return originalFetch.apply(this, arguments).finally(() => {
            NProgress.set(1.0);
            setTimeout(() => NProgress.done(), 300);
        });
    };

    // 🔹 4. Saat halaman selesai load
    window.addEventListener("pageshow", () => {
        NProgress.set(1.0);
        setTimeout(() => NProgress.done(), 300);
    });

    // 🔹 5. Tangkap submit form (SAMAIN dengan klik link)
    document.addEventListener("submit", function (e) {
        const form = e.target;
        if (form.tagName === "FORM") {
            NProgress.start();
            setTimeout(() => NProgress.set(0.9), 150);
        }
    }, true);
</script>

@endpush
