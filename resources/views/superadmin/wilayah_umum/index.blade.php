@extends('superadmin.layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 mt-4 font-weight-bold">Kelola Wilayah</h1>

        @if(session('success'))
            <div id="alert-success" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Button to trigger Add Wilayah modal -->
        <button class="btn btn-primary mb-4" data-toggle="modal" data-target="#addWilayahModal">Tambah Wilayah</button>

        <!-- Table to display wilayah -->
        @if($wilayah->isEmpty())
            <div class="alert alert-info">
                Tidak ada wilayah saat ini.
            </div>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama Wilayah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wilayah as $wil)
                        <tr>
                            <td>{{ $wil->nama }}</td>
                            <td>
                                <!-- Edit button, triggers the edit modal -->
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editWilayahModal"
                                    data-id="{{ $wil->id }}" data-nama="{{ $wil->nama }}">
                                    Edit
                                </button>

                                <!-- Delete button, triggers the delete confirmation modal -->
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteWilayahModal"
                                    data-id="{{ $wil->id }}" data-nama="{{ $wil->nama }}">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="d-flex justify-content-center">
                {{ $wilayah->links() }} <!-- Pagination links -->
            </div>
        @endif

        <!-- Add Wilayah Modal -->
        <div class="modal fade" id="addWilayahModal" tabindex="-1" role="dialog" aria-labelledby="addWilayahModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('superadmin.kelola-wilayah.index') }}" method="POST">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="addWilayahModalLabel">Tambah Wilayah</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama Wilayah</label>
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

        <!-- Edit Wilayah Modal -->
        <div class="modal fade" id="editWilayahModal" tabindex="-1" role="dialog" aria-labelledby="editWilayahModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <!-- Action mengarah ke route admin.kelola-wilayah.update dan menggunakan ID dinamis -->
                    <form action="{{ route('superadmin.kelola-wilayah.update', 'placeholder') }}" method="POST"
                        id="editWilayahForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editWilayahModalLabel">Edit Wilayah</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="nama">Nama Wilayah</label>
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

        <!-- Delete Wilayah Modal -->
        <div class="modal fade" id="deleteWilayahModal" tabindex="-1" role="dialog"
            aria-labelledby="deleteWilayahModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form action="{{ route('superadmin.kelola-wilayah.destroy', 'placeholder') }}" method="POST"
                        id="deleteWilayahForm">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteWilayahModalLabel">Konfirmasi Hapus Wilayah</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
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

        @push('scripts')
            <script>
                // Set data for editing
                $('#editWilayahModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Button yang memicu modal
                    var id = button.data('id'); // Ambil ID dari atribut data-id
                    var nama = button.data('nama'); // Ambil nama wilayah dari atribut data-nama

                    var modal = $(this);
                    modal.find('#editWilayahForm').attr('action', '/admin/kelola-wilayah/' + id); // Set form action ke URL yang sesuai
                    modal.find('#editWilayahNama').val(nama); // Isi input nama dengan nama wilayah
                });

                // Set data for delete confirmation
                $('#deleteWilayahModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget); // Button that triggered the modal
                    var id = button.data('id'); // Extract the ID from the data-id attribute
                    var nama = button.data('nama'); // Extract the name from the data-nama attribute

                    var modal = $(this);
                    modal.find('#deleteWilayahForm').attr('action', '/admin/kelola-wilayah/' + id); // Set form action URL dynamically
                    modal.find('#deleteWilayahId').val(id); // Set the ID for deletion
                    modal.find('#wilayahNama').text(nama); // Set category name in the modal
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