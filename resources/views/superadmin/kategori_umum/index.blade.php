@extends('superadmin.layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 mt-4 font-weight-bold">Kelola Kategori</h1>

        @if(session('success'))
            <div id="alert-success" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-4 gap-4">
            <!-- Tombol Tambah Kategori -->
            <button class="btn btn-primary" data-toggle="modal" data-target="#addKategoriModal">
                Tambah Kategori
            </button>

            <!-- Form Search -->
            <form action="{{ route('superadmin.kelola-kategori.index') }}" method="GET" class="w-full sm:w-auto">
                <div class="flex items-center gap-2">
                    <input type="text" name="search"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Cari kategori..." value="{{ request('search') }}">

                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition duration-200">
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('superadmin.kelola-kategori.index') }}"
                            class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition duration-200">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Table to display categories -->
        @if($kategori->isEmpty())
            <div class="alert alert-info">
                Tidak ada kategori saat ini.
            </div>
        @else
            <table class="table table-striped table-bordered w-full">
                <thead>
                    <tr>
                        <th class="w-8 text-center">No</th> {{-- Kolom Nomor --}}
                        <th>Nama Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategori as $index => $kat)
                        <tr>
                            <td class="w-8 text-center">
                                {{ ($kategori->currentPage() - 1) * $kategori->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $kat->nama }}</td>
                            <td class="text-center">
                                {{-- Tombol Edit --}}
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKategoriModal"
                                    data-id="{{ $kat->id }}" data-nama="{{ $kat->nama }}">
                                    Edit
                                </button>

                                {{-- Tombol Hapus --}}
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteKategoriModal"
                                    data-id="{{ $kat->id }}" data-nama="{{ $kat->nama }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $kategori->links() }} <!-- Pagination links -->
            </div>
        @endif

        <!-- Add Category Modal -->
        <div class="modal fade" id="addKategoriModal" tabindex="-1" role="dialog" aria-labelledby="addKategoriModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('superadmin.kelola-kategori.store') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addKategoriModalLabel">Tambah Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama Kategori</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Category Modal -->
        <div class="modal fade" id="editKategoriModal" tabindex="-1" role="dialog" aria-labelledby="editKategoriModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('superadmin.kelola-kategori.update', 'placeholder') }}" method="POST"
                        id="editKategoriForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editKategoriModalLabel">Edit Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama Kategori</label>
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

        <!-- Delete Category Modal -->
        <div class="modal fade" id="deleteKategoriModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteKategoriModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('superadmin.kelola-kategori.destroy', 'placeholder') }}" method="POST"
                        id="deleteKategoriForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteKategoriModalLabel">Konfirmasi Hapus Kategori</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
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

    @push('scripts')
        <script>
            // Set data for editing
            $('#editKategoriModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var nama = button.data('nama');

                var modal = $(this);
                modal.find('#editKategoriForm').attr('action', '/admin/kelola-kategori/' + id); // Set form action URL
                modal.find('#editNama').val(nama); // Set input field value
            });

            // Set data for delete confirmation
            $('#deleteKategoriModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var nama = button.data('nama');

                var modal = $(this);
                modal.find('#deleteKategoriForm').attr('action', '/admin/kelola-kategori/' + id); // Set form action URL
                modal.find('#kategoriNama').text(nama); // Set category name in the modal
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