@extends('superadmin.layouts.app')

@section('title', 'Kelola User')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-2xl font-semibold text-[#37474F]">Kelola User</h2>

        <div class="flex flex-wrap items-center gap-2 mb-4">

            {{-- Form Filter Role --}}
            <form method="GET" id="filter-role-form">
                <label for="role" class="text-sm font-medium">Filter Role:</label>
                <select name="role" id="role" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    onchange="document.getElementById('filter-role-form').submit()">
                    <option value="">-- Semua --</option>
                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superadmin" {{ request('role') === 'superadmin' ? 'selected' : '' }}>Superadmin</option>
                </select>
            </form>

            {{-- Form Pencarian --}}
            <form method="GET" class="flex flex-wrap items-center gap-2">
                {{-- Kirimkan juga nilai role supaya tidak hilang --}}
                @if(request('role'))
                    <input type="hidden" name="role" value="{{ request('role') }}">
                @endif

                <input type="text" name="search"
                    class="flex-1 min-w-[200px] sm:min-w-[250px] md:min-w-[300px] lg:min-w-[400px] border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200"
                    placeholder="Cari nama/email/nik/telepon" value="{{ request('search') }}">

                <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-md hover:bg-red-700 transition">
                    Cari
                </button>

                @if(request('search'))
                    <a href="{{ route('superadmin.kelola-user.index', ['role' => request('role')]) }}"
                        class="px-4 py-2 text-white bg-gray-500 rounded-md hover:bg-gray-600 transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

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

        @if($users->isEmpty())
            <div class="alert alert-info">Tidak ada user ditemukan.</div>
        @else
            <!-- Tabel untuk Desktop -->
            <div class="table-responsive d-none d-md-block">
                <table class="table table-striped table-bordered w-100">
                    <thead class="bg-gradient-to-r from-red-700 to-rose-500 text-white">
                      <tr>
    <th class="text-center align-middle">No</th>
    <th class="text-center align-middle">Nama</th>
    <th class="text-center align-middle">Email</th>
    <th class="text-center align-middle">NIK</th>
    <th class="text-center align-middle">No Telepon</th>
    <th class="text-center align-middle">Role</th>
    <th class="text-center align-middle">Aksi</th>
</tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                              <tr class="border-b">
              <td class="px-4 py-3 text-center align-middle">
    {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
</td>
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->nik ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $user->nomor_telepon ?? '-' }}</td>
                            <td class="px-4 py-3 capitalize">{{ $user->role }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-2 flex-wrap">
                                    <button type="button"
                                        class="px-3 py-1 text-sm bg-yellow-500 hover:bg-yellow-600 rounded text-white"
                                        data-toggle="modal" data-target="#editUserModal"
                                        data-id="{{ $user->id_user }}" data-name="{{ $user->name }}"
                                        data-email="{{ $user->email }}" data-nik="{{ $user->nik }}"
                                        data-phone="{{ $user->nomor_telepon }}" data-role="{{ $user->role }}">
                                        Edit
                                    </button>
                                    <button type="button"
                                        class="px-3 py-1 text-sm bg-red-500 hover:bg-red-600 rounded text-white"
                                        data-toggle="modal" data-target="#deleteUserModal"
                                        data-id="{{ $user->id_user }}" data-name="{{ $user->name }}">
                                        Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

            <!-- Card View untuk Mobile -->
            <div class="d-block d-md-none">
                @foreach($users as $user)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}.
                                {{ $user->name }}
                            </h5>
                            <p class="card-text mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                            <p class="card-text mb-1"><strong>NIK:</strong> {{ $user->nik ?? '-' }}</p>
                            <p class="card-text mb-1"><strong>No Telepon:</strong> {{ $user->nomor_telepon ?? '-' }}</p>
                            <p class="card-text mb-3"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                            <div class="d-flex flex-column gap-2">
                                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editUserModal"
                                    data-id="{{ $user->id_user }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                    data-nik="{{ $user->nik }}" data-phone="{{ $user->nomor_telepon }}"
                                    data-role="{{ $user->role }}">
                                    Edit
                                </button>
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteUserModal"
                                    data-id="{{ $user->id_user }}" data-name="{{ $user->name }}">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="mt-6 d-flex justify-content-center">
            {{ $users->links() }}
        </div>

        <!-- Modal Edit -->
        <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
            aria-hidden="true">
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
                                    <option value="superadmin">Superadmin</option>
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
        <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel"
            aria-hidden="true">
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
                modal.find('form').attr('action', `/superadmin/kelola-user/${id}`);
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
                modal.find('form').attr('action', `/superadmin/kelola-user/${id}`);
                modal.find('#deleteUserName').text(name);
            });

            // Auto-hide flash messages (sukses atau error)
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