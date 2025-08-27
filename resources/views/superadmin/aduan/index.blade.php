@extends('superadmin.layouts.app')

@section('title', 'Kelola Aduan Umum')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-2xl font-semibold text-[#37474F]">Kelola Aduan</h2>

   @if(session('success'))
    <!-- SUCCESS NOTIF -->
    <div id="successMessage" 
        class="fixed top-5 right-5 z-50 flex items-center justify-between gap-4 
               w-[420px] max-w-[90vw] px-6 py-4 rounded-2xl shadow-2xl border border-red-400 
               bg-gradient-to-r from-red-600 to-red-500/90 backdrop-blur-md text-white 
               transition-all duration-500 opacity-100 animate-fade-in">

        <!-- Ikon -->
        <div class="flex-shrink-0">
            <!-- Spinner -->
            <svg id="success-spinner" class="w-6 h-6 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <!-- Check -->
            <svg id="success-check" class="w-6 h-6 text-white hidden scale-75" fill="none" viewBox="0 0 24 24">
                <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
            </svg>
        </div>

        <!-- Pesan -->
        <span class="flex-1 font-medium tracking-wide">{{ session('success') }}</span>

        <!-- Tombol Close -->
        <button onclick="document.getElementById('successMessage').remove()" 
            class="text-white/70 hover:text-white font-bold transition-colors">✕</button>

        <!-- Progress Bar -->
        <div class="absolute bottom-0 left-0 h-[3px] bg-white/70 w-full origin-left scale-x-0 animate-progress rounded-b-xl"></div>
    </div>

@elseif(session('error'))
    <!-- ERROR NOTIF -->
    <div id="errorMessage" 
        class="fixed top-5 right-5 z-50 flex items-center justify-between gap-4 
               w-[420px] max-w-[90vw] px-6 py-4 rounded-2xl shadow-2xl border border-red-400 
               bg-gradient-to-r from-red-600 to-red-500/90 backdrop-blur-md text-white 
               transition-all duration-500 opacity-100 animate-fade-in">

        <!-- Ikon -->
        <div class="flex-shrink-0">
            <!-- Spinner -->
            <svg id="error-spinner" class="w-6 h-6 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <!-- X -->
            <svg id="error-x" class="w-6 h-6 text-white hidden scale-75" fill="none" viewBox="0 0 24 24">
                <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <!-- Pesan -->
        <span class="flex-1 font-medium tracking-wide">{{ session('error') }}</span>

        <!-- Tombol Close -->
        <button onclick="document.getElementById('errorMessage').remove()" 
            class="text-white/70 hover:text-white font-bold transition-colors">✕</button>

        <!-- Progress Bar -->
        <div class="absolute bottom-0 left-0 h-[3px] bg-white/70 w-full origin-left scale-x-0 animate-progress rounded-b-xl"></div>
    </div>
@endif

<style>
    @keyframes fade-in {
        from { opacity: 0; transform: translateY(-12px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }
    @keyframes progress {
        from { transform: scaleX(0); }
        to { transform: scaleX(1); }
    }
    @keyframes pop {
        from { transform: scale(0.6); opacity: 0; }
        to { transform: scale(1); opacity: 1; }
    }

    .animate-fade-in { animation: fade-in 0.4s ease-out; }
    .animate-progress { animation: progress 3s linear forwards; }
    .animate-pop { animation: pop 0.3s ease-out; }
</style>

<script>
    // SUCCESS
    if (document.getElementById('successMessage')) {
        setTimeout(() => {
            document.getElementById('success-spinner').classList.add('hidden');
            const check = document.getElementById('success-check');
            check.classList.remove('hidden');
            check.classList.add('animate-pop');
        }, 800);

        setTimeout(() => {
            const alert = document.getElementById('successMessage');
            if (alert) {
                alert.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => alert.remove(), 500);
            }
        }, 3500);
    }

    // ERROR
    if (document.getElementById('errorMessage')) {
        setTimeout(() => {
            document.getElementById('error-spinner').classList.add('hidden');
            const x = document.getElementById('error-x');
            x.classList.remove('hidden');
            x.classList.add('animate-pop');
        }, 800);

        setTimeout(() => {
            const alert = document.getElementById('errorMessage');
            if (alert) {
                alert.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => alert.remove(), 500);
            }
        }, 3500);
    }
</script>

    <!-- Filter Admin & Kategori -->
<div class="mb-4">
    <form method="GET" action="{{ route('superadmin.kelola-aduan.index') }}" 
          class="flex flex-wrap gap-3 items-center">

        <!-- Filter Admin -->
        <div>
            <label for="admin_id" class="text-sm text-gray-700">Filter Admin:</label>
            <select name="admin_id" id="admin_id" onchange="this.form.submit()" 
                    class="border px-3 py-1 rounded">
                <option value="">-- Semua Admin --</option>
                @foreach($admins as $admin)
                    <option value="{{ $admin->id_user }}" 
                        {{ request('admin_id') == $admin->id_user ? 'selected' : '' }}>
                        {{ $admin->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Filter Status -->
        <div>
            <label for="status" class="text-sm text-gray-700">Filter Status:</label>
            <select name="status" id="status" onchange="this.form.submit()" 
                    class="border px-3 py-1 rounded">
                <option value="">-- Semua Status --</option>
                <option value="Diajukan" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                <option value="Dibaca" {{ request('status') == 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
                <option value="Direspon" {{ request('status') == 'Direspon' ? 'selected' : '' }}>Direspon</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
    </form>
</div>

    @if($reports->isEmpty())
        <div class="alert alert-info">Tidak ada aduan saat ini.</div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered w-100">
                <thead class="bg-gradient-to-r from-red-700 to-rose-500 text-white">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Judul</th>
                        <th class="text-center">Admin OPD</th>
                        <th class="text-center">Kategori</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $index => $report)
                        <tr>
                            <td class="text-center align-middle">
                                {{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}
                            </td>
                            <td>{{ $report->judul }}</td>
                            <td>{{ $report->admin->name ?? '-' }}</td>
                            <td>{{ $report->kategori->nama ?? '-' }}</td>
                            <td>
                                <span class="rounded-full px-2 py-1 text-xs font-semibold
                                    @if($report->status == 'Diajukan') bg-red-200 text-red-800
                                    @elseif($report->status == 'Dibaca') bg-blue-200 text-blue-800
                                    @elseif($report->status == 'Direspon') bg-yellow-200 text-yellow-800
                                    @elseif($report->status == 'Selesai') bg-green-200 text-green-800
                                    @endif">
                                    {{ $report->status }}
                                </span>
                            </td>
                            <td>
                                <div class="flex gap-2 flex-wrap">
                                    <button type="button"
                                        class="px-3 py-1 text-sm bg-yellow-500 hover:bg-yellow-600 rounded text-white"
                                        data-toggle="modal" data-target="#editAduanModal"
                                        data-id="{{ $report->id }}" data-status="{{ $report->status }}">
                                        Edit
                                    </button>
                                     <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteAduanModal"
                                        data-id="{{ $report->id }}" data-judul="{{ $report->judul }}">
                                        Hapus
                                    </button>
                                    <a href="{{ route('superadmin.reports.show', ['id' => $report->id]) }}"
                                        class="px-3 py-1 text-sm bg-blue-500 hover:bg-blue-600 rounded text-white">
                                        Lihat
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 d-flex justify-content-center">
            {{ $reports->appends(request()->query())->links() }}
        </div>
    @endif

    <!-- Modal Edit -->
    <div class="modal fade" id="editAduanModal" tabindex="-1" role="dialog" aria-labelledby="editAduanModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" id="editAduanForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Status Aduan</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editStatus">Status</label>
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
    $('#editAduanModal').on('show.bs.modal', function (event) {
        const button = $(event.relatedTarget);
        const id = button.data('id');
        const status = button.data('status');

        const modal = $(this);
        modal.find('#editStatus').val(status);
        modal.find('#editAduanForm').attr('action', `/superadmin/kelola-aduan/${id}`);
    });

                $('#deleteAduanModal').on('show.bs.modal', function (event) {
                    var button = $(event.relatedTarget);
                    var id = button.data('id');
                    var judul = button.data('judul');

                    var modal = $(this);
                    modal.find('#aduanJudul').text(judul); // Set aduan name in the modal
                    modal.find('#deleteAduanForm').attr('action', '/superadmin/kelola-aduan/' + id); // Set form action
                });

    @if(session('success') || session('error'))
        setTimeout(() => {
            $('#alert-success').fadeOut('slow');
            $('#alert-error').fadeOut('slow');
        }, 3000);
    @endif
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
@endsection