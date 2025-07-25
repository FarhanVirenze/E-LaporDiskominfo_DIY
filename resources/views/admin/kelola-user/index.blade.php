@extends('admin.layouts.app')

@section('title', 'Kelola User')

@section('content')
    <div class="container mt-4">
        <h1 class="mb-4 font-weight-bold">Kelola User</h1>

        <form method="GET" class="form-inline mb-3">
    <label for="role" class="mr-2">Filter Role:</label>
    <select name="role" id="role" class="form-control mr-2" onchange="this.form.submit()">
        <option value="">-- Semua --</option>
        <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
    </select>
</form>

        @if(session('success'))
            <div id="alert-success" class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div id="alert-error" class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($users->isEmpty())
            <div class="alert alert-info">Tidak ada user ditemukan.</div>
        @else
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td class="text-capitalize">{{ $user->role }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <!-- Tombol Edit -->
                                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal"
                                        data-id="{{ $user->id_user }}" data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}" data-nik="{{ $user->nik }}"
                                        data-phone="{{ $user->nomor_telepon }}" data-role="{{ $user->role }}">
                                        Edit
                                    </button>

                                    <!-- Tombol Hapus -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal"
                                        data-id="{{ $user->id_user }}" data-name="{{ $user->name }}">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <!-- Modal Edit -->
    <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" id="editUserForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editName">Nama</label>
                            <input type="text" class="form-control" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editEmail">Email</label>
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="form-group">
                            <label for="editNik">NIK</label>
                            <input type="text" class="form-control" id="editNik" name="nik" required>
                        </div>
                        <div class="form-group">
                            <label for="editPhone">Nomor Telepon</label>
                            <input type="text" class="form-control" id="editPhone" name="nomor_telepon" required>
                        </div>
                        <div class="form-group">
                            <label for="editRole">Role</label>
                            <select class="form-control" id="editRole" name="role" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                                <option value="pimpinan">Superadmin</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Delete -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" id="deleteUserForm">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUserModalLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus user <strong id="deleteUserName"></strong>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Modal Edit User
    $('#editUserModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data('id') || '';
        const name = button.data('name') || '';
        const email = button.data('email') || '';
        const nik = button.data('nik') || '';
        const phone = button.data('phone') || '';
        const role = button.data('role') || '';

        const modal = $(this);
        modal.find('form').attr('action', `/admin/kelola-user/${id}`);
        modal.find('#editName').val(name);
        modal.find('#editEmail').val(email);
        modal.find('#editNik').val(nik);
        modal.find('#editPhone').val(phone);
        modal.find('#editRole').val(role);
    });

    // Modal Hapus User
    $('#deleteUserModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data('id') || '';
        const name = button.data('name') || '';

        const modal = $(this);
        modal.find('form').attr('action', `/admin/kelola-user/${id}`);
        modal.find('#deleteUserName').text(name);
    });

    // Auto-hide flash messages (sukses atau error)
    setTimeout(() => {
        $('#alert-success').fadeOut('slow');
        $('#alert-error').fadeOut('slow');
    }, 3000);
</script>
@endpush
