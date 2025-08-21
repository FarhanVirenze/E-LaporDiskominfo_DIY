@extends('superadmin.layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-2xl font-semibold text-[#37474F]">Kelola Kategori</h2>

       @if(session('success'))
    <div id="successMessage" class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif(session('error'))
    <div id="errorMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-4">
            <!-- Tombol Tambah Kategori -->
            <button type="button" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition"
                data-toggle="modal" data-target="#addKategoriModal">
                Tambah Kategori
            </button>

            <!-- Form Search -->
            <form action="{{ route('superadmin.kelola-kategori.index') }}" method="GET" class="w-full sm:w-auto">
                <div class="flex items-center gap-2">
                    <input type="text" name="search"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                        placeholder="Cari kategori..." value="{{ request('search') }}">

                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-blue-700 transition">
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('superadmin.kelola-kategori.index') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        @if($kategori->isEmpty())
            <div class="alert alert-info">Tidak ada kategori saat ini.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered w-full">
                    <thead class="bg-gradient-to-r from-red-700 to-red-500 text-white">
                        <tr>
                            <th class="text-center w-12">No</th>
                            <th class="text-center">Nama Kategori</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $index => $kat)
                            <tr>
                                <td class="text-center">
                                    {{ ($kategori->currentPage() - 1) * $kategori->perPage() + $loop->iteration }}
                                </td>
                                <td>{{ $kat->nama }}</td>
                                <td class="text-center">
                                    <div class="flex gap-2 justify-center flex-wrap">
                                        <button type="button"
                                            class="px-3 py-1 text-sm bg-yellow-500 hover:bg-yellow-600 rounded text-white"
                                            data-toggle="modal" data-target="#editKategoriModal"
                                            data-id="{{ $kat->id }}" data-nama="{{ $kat->nama }}">
                                            Edit
                                        </button>
                                        <button type="button"
                                            class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 rounded text-white"
                                            data-toggle="modal" data-target="#deleteKategoriModal"
                                            data-id="{{ $kat->id }}" data-nama="{{ $kat->nama }}">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 d-flex justify-content-center">
                {{ $kategori->links() }}
            </div>
        @endif

        <!-- Modal Tambah -->
        <div class="modal fade" id="addKategoriModal" tabindex="-1" role="dialog" aria-labelledby="addKategoriModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('superadmin.kelola-kategori.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">Tambah Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama Kategori</label>
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
        <div class="modal fade" id="editKategoriModal" tabindex="-1" role="dialog" aria-labelledby="editKategoriModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" id="editKategoriForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="editNama">Nama Kategori</label>
                                <input type="text" name="nama" id="editNama" class="form-control" required>
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
        <div class="modal fade" id="deleteKategoriModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteKategoriModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" id="deleteKategoriForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Hapus Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                        </div>
                        <div class="modal-body">
                            <p>Apakah Anda yakin ingin menghapus kategori <strong id="kategoriNama"></strong>?</p>
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
        $('#editKategoriModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nama = button.data('nama');

            const modal = $(this);
            modal.find('#editKategoriForm').attr('action', `/superadmin/kelola-kategori/${id}`);
            modal.find('#editNama').val(nama);
        });

        // Modal Hapus
        $('#deleteKategoriModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            const id = button.data('id');
            const nama = button.data('nama');

            const modal = $(this);
            modal.find('#deleteKategoriForm').attr('action', `/superadmin/kelola-kategori/${id}`);
            modal.find('#kategoriNama').text(nama);
        });

        // Auto-hide alert
        setTimeout(() => {
            $('#alert-success').fadeOut('slow');
            $('#alert-error').fadeOut('slow');
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
