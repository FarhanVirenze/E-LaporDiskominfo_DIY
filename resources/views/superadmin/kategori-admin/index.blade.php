@extends('superadmin.layouts.app')

@section('title', 'Kelola Admin Kategori')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4 text-2xl font-semibold text-[#37474F]">Kelola Admin Kategori</h2>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div id="alert-success" class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div id="alert-error" class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($admins->isEmpty())
        <div class="alert alert-info shadow-sm">Tidak ada admin tersedia.</div>
    @else
        {{-- Mobile --}}
        <div class="d-block d-md-none">
            @foreach($admins as $admin)
                <div class="card border-0 mb-3 shadow-sm rounded-4"
                    style="background: linear-gradient(90deg, #e8f0fe 0%, #f0f4ff 100%); border: 1px solid #cddafd;">
                    <div class="card-body p-3">
                        <h5 class="fw-bold text-primary mb-2 d-flex align-items-center">
                            <i class="bi bi-person-circle me-2 fs-5"></i>{{ $admin->name }}
                        </h5>

                        <small class="text-muted">Kategori Saat Ini:</small>
                        @if($admin->kategori->isNotEmpty())
                            <div class="d-flex flex-wrap gap-2 mt-1">
                                @foreach($admin->kategori as $k)
                                    <span class="badge bg-danger text-light rounded-pill px-3 py-2">{{ $k->nama }}</span>
                                @endforeach
                            </div>
                        @else
                            <p class="fst-italic text-muted">Belum ada</p>
                        @endif

                        <button class="btn btn-sm btn-outline-primary mt-3 w-100 toggle-form-btn rounded-pill"
                            data-target="#form-mobile-{{ $admin->id_user }}">
                            <i class="bi bi-pencil me-1"></i> Atur Kategori
                        </button>

                        <div id="form-mobile-{{ $admin->id_user }}" class="kategori-form mt-3 d-none">
                            <form method="POST" action="{{ route('superadmin.kategori-admin.update', $admin->id_user) }}">
                                @csrf
                                @method('PUT')
                                <label class="form-label fw-semibold small text-muted mb-1">Pilih Kategori:</label>
                                <select name="kategori_ids[]" multiple class="form-control kategori-select rounded-3">
                                    @foreach($kategoris as $kategori)
                                        <option value="{{ $kategori->id }}" {{ $admin->kategori->contains('id', $kategori->id) ? 'selected' : '' }}>
                                            {{ $kategori->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-sm btn-success mt-3 w-100 rounded-pill">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Desktop --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table table-bordered table-hover shadow-sm align-middle rounded-2 overflow-hidden">
                <thead class="bg-gradient-to-r from-blue-700 to-blue-500 text-white">
                    <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Admin OPD</th>
                        <th class="text-center">Kategori Saat Ini</th>
                        <th class="text-center">Atur Kategori</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($admins as $index => $admin)
                        <tr>
                            <td class="text-center">{{ $admins->firstItem() + $index }}</td>
                            <td class="text-break" style="max-width: 250px">{{ $admin->name }}</td>
                            <td>
                                @if($admin->kategori->isNotEmpty())
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($admin->kategori as $k)
                                            <span class="badge bg-danger text-light rounded-pill px-3 py-2">{{ $k->nama }}</span>
                                        @endforeach
                                    </div>
                                @else
                                    <em class="text-muted">Belum ada</em>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-primary toggle-form-btn"
                                    data-target="#form-desktop-{{ $admin->id_user }}">
                                    <i class="bi bi-pencil-square me-1"></i> Atur
                                </button>

                                <div id="form-desktop-{{ $admin->id_user }}" class="kategori-form mt-3 d-none">
                                    <form method="POST"
                                        action="{{ route('superadmin.kategori-admin.update', $admin->id_user) }}">
                                        @csrf
                                        @method('PUT')
                                        <label class="form-label fw-semibold small text-muted">Pilih Kategori:</label>
                                        <select name="kategori_ids[]" multiple class="form-control kategori-select">
                                            @foreach($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}" {{ $admin->kategori->contains('id', $kategori->id) ? 'selected' : '' }}>
                                                    {{ $kategori->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-success mt-3">Simpan</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <div class="mt-4">
        {{ $admins->links() }}
    </div>
</div>
@endsection

@push('scripts')
    {{-- Bootstrap Icons & Select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .kategori-form {
            background: #f8f9fa;
            border-left: 4px solid #0d6efd;
            padding: 16px;
            border-radius: 8px;
        }

        .badge {
            font-size: 0.85rem;
            font-weight: 500;
        }

        #alert-success, #alert-error {
            transition: opacity 0.4s ease-in-out;
        }

        .table th, .table td {
            vertical-align: middle !important;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('.kategori-select').select2({
                width: '100%',
                placeholder: 'Pilih kategori',
                allowClear: true
            });

            $('.toggle-form-btn').on('click', function () {
                const target = $(this).data('target');
                $(target).slideToggle(150).toggleClass('d-none');
            });

            setTimeout(() => {
                $('#alert-success, #alert-error').fadeTo(500, 0).slideUp(500, function () {
                    $(this).remove();
                });
            }, 3000);
        });
    </script>
@endpush
