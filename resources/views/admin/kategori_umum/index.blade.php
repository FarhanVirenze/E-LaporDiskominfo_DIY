@extends('admin.layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 mt-4 font-weight-bold">Kelola Kategori</h1>

        @if(session('success'))
            <div id="alert-success" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Button to trigger Add Category modal -->
        <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#addKategoriModal">Tambah Kategori</button>

        <!-- Table to display categories -->
        @if($kategori->isEmpty())
            <div class="alert alert-info">
                Tidak ada kategori saat ini.
            </div>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategori as $kat)
                        <tr>
                            <td>{{ $kat->nama }}</td>
                            <td>
                                <!-- Edit button, triggers the edit modal -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editKategoriModal"
                                    data-id="{{ $kat->id }}" data-nama="{{ $kat->nama }}">
                                    Edit
                                </button>

                                <!-- Delete button, triggers the delete confirmation modal -->
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
                    <form action="{{ route('admin.kelola-kategori.store') }}" method="POST">
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
                    <form action="{{ route('admin.kelola-kategori.update', 'placeholder') }}" method="POST"
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
        <div class="modal fade" id="deleteKategoriModal" tabindex="-1" role="dialog" aria-labelledby="deleteKategoriModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('admin.kelola-kategori.destroy', 'placeholder') }}" method="POST" id="deleteKategoriForm">
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
