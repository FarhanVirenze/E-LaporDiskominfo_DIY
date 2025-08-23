@extends('admin.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">

        @if (session('success'))
            <div id="successMessage"
                class="fixed top-5 right-5 z-50 flex items-center justify-between gap-4 
                                                                                                                                                               w-[420px] max-w-[90vw] px-6 py-4 rounded-2xl shadow-2xl border border-red-400 
                                                                                                                                                               bg-gradient-to-r from-red-600 to-red-500/90 backdrop-blur-md text-white 
                                                                                                                                                               transition-all duration-500 opacity-100 animate-fade-in">

                <!-- Ikon -->
                <div id="success-icon-wrapper" class="flex-shrink-0">
                    <!-- Spinner -->
                    <svg id="success-spinner" class="w-6 h-6 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    <!-- Check -->
                    <svg id="success-check" class="w-6 h-6 text-white hidden scale-75" fill="none" viewBox="0 0 24 24">
                        <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <!-- Pesan -->
                <span class="flex-1 font-medium tracking-wide">{{ session('success') }}</span>

                <!-- Tombol Close -->
                <button onclick="document.getElementById('successMessage').remove()"
                    class="text-white/70 hover:text-white font-bold transition-colors">
                    ✕
                </button>

                <!-- Progress Bar -->
                <div
                    class="absolute bottom-0 left-0 h-[3px] bg-white/70 w-full origin-left scale-x-0 animate-progress rounded-b-xl">
                </div>
            </div>

            <style>
                @keyframes fade-in {
                    from {
                        opacity: 0;
                        transform: translateY(-12px) scale(0.98);
                    }

                    to {
                        opacity: 1;
                        transform: translateY(0) scale(1);
                    }
                }

                @keyframes progress {
                    from {
                        transform: scaleX(0);
                    }

                    to {
                        transform: scaleX(1);
                    }
                }

                @keyframes pop {
                    from {
                        transform: scale(0.6);
                        opacity: 0;
                    }

                    to {
                        transform: scale(1);
                        opacity: 1;
                    }
                }

                .animate-fade-in {
                    animation: fade-in 0.4s ease-out;
                }

                .animate-progress {
                    animation: progress 3s linear forwards;
                }

                .animate-pop {
                    animation: pop 0.3s ease-out;
                }
            </style>

            <script>
                // Ganti spinner jadi centang
                setTimeout(() => {
                    document.getElementById('success-spinner').classList.add('hidden');
                    const check = document.getElementById('success-check');
                    check.classList.remove('hidden');
                    check.classList.add('animate-pop');
                }, 800);

                // Auto hide notif
                setTimeout(() => {
                    const alert = document.getElementById('successMessage');
                    if (alert) {
                        alert.classList.add('opacity-0', 'translate-y-2');
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 3500);
            </script>
        @endif

        {{-- Judul Utama + Tombol Selesaikan --}}
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-semibold text-[#37474F]">
                Informasi Detail Aduan
            </h1>

            {{-- Tombol Selesaikan / Batalkan --}}
@if($report->status != 'Selesai')
    <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" class="ml-auto">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="Selesai">
        <button type="submit"
            class="group flex items-center gap-2 px-4 py-2.5 rounded-full bg-gradient-to-r from-green-600 to-green-600 text-white font-medium shadow-md hover:shadow-lg hover:from-green-700 hover:to-green-600 transition-all duration-200"
            title="Tandai sebagai selesai">
            <i class="fas fa-check-circle text-lg group-hover:scale-110 transform transition"></i>
            <span class="hidden sm:inline">Selesaikan Aduan</span>
        </button>
    </form>
@else
    <form action="{{ route('admin.reports.update', $report->id) }}" method="POST" class="ml-auto">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="Dibaca">
        <button type="submit"
            class="group flex items-center gap-2 px-4 py-2.5 rounded-full bg-gradient-to-r from-red-600 to-red-600 text-white font-medium shadow-md hover:shadow-lg hover:from-red-700 hover:to-red-600 transition-all duration-200"
            title="Batalkan status selesai">
            <i class="fas fa-times-circle text-lg group-hover:scale-110 transform transition"></i>
            <span class="hidden sm:inline">Batalkan Selesai</span>
        </button>
    </form>
@endif
        </div>

        {{-- Meta --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-[13px] text-gray-700">
            {{-- Kolom Kiri --}}
            <div class="space-y-1">
                <p>
                    <span class="font-medium">Oleh</span>
                    <span class="text-gray-800 font-semibold">
                        {{ $report->is_anonim ? 'Anonim' : $report->nama_pengadu }}
                    </span>
                    <i class="fas fa-random ml-1 text-xs text-gray-500"></i>
                    <span class="ml-1 text-gray-500">Melalui Website Pengaduan</span>
                </p>

                {{-- Status Aduan + Modal --}}
                <div x-data="{ openStatusModal: false }">
                    <p class="flex items-center">
                        <i class="fas fa-info-circle text-gray-500 mr-1"></i>
                        <span class="font-medium">Status Aduan</span>
                        <span
                            class="ml-1 inline-block px-2 py-0.5 rounded-full text-xs font-semibold
                                                                        @if($report->status == 'Diajukan') bg-red-100 text-red-700
                                                                        @elseif($report->status == 'Dibaca') bg-blue-100 text-blue-700
                                                                        @elseif($report->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                        @elseif($report->status == 'Selesai') bg-green-100 text-green-700 @endif">
                            Aduan {{ strtolower($report->status) }}
                        </span>

                        {{-- Icon Edit (ini bisa akses openStatusModal karena dalam scope x-data) --}}
                        <button @click="openStatusModal = true" class="ml-2 text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </button>
                    </p>

                    <!-- Modal Edit Status -->
                    <div x-show="openStatusModal" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                            <h3 class="text-lg font-bold mb-4">Edit Status Aduan</h3>

                            <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <label class="block font-medium mb-1">Pilih Status</label>
                                <select name="status"
                                    class="w-full border rounded-lg px-3 py-2 mb-4 focus:ring focus:ring-blue-300">
                                    <option value="Diajukan" @selected($report->status == 'Diajukan')>Diajukan</option>
                                    <option value="Dibaca" @selected($report->status == 'Dibaca')>Dibaca</option>
                                    <option value="Direspon" @selected($report->status == 'Direspon')>Direspon</option>
                                    <option value="Selesai" @selected($report->status == 'Selesai')>Selesai</option>
                                </select>

                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="openStatusModal = false"
                                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Disposisi --}}
                <div x-data="{ openDisposisiModal: false }">
                    <p class="text-sm text-gray-700 flex items-center">
                        <i class="fas fa-share-square text-gray-500 mr-1"></i>
                        <span class="font-medium">Aduan ini didisposisikan ke</span>
                        @if($report->admin)
                            <span class="ml-1 px-2 py-1 rounded-full bg-gray-600 text-white text-xs font-medium">
                                {{ $report->admin->name }}
                            </span>
                        @else
                            <span class="ml-1 italic text-gray-500">Belum didisposisikan</span>
                        @endif
                    </p>
                </div>

                {{-- Tracking ID --}}
                <div x-data="{ openTrackingModal: false }">
                    <p class="flex items-center">
                        <i class="fas fa-tag text-gray-500 mr-1"></i>
                        <span class="font-medium">Tracking ID:</span>
                        <span class="font-bold">{{ $report->tracking_id }}</span>

                        {{-- Icon Edit --}}
                        <button @click="openTrackingModal = true" class="ml-2 text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </button>
                    </p>

                    <!-- Modal Edit Tracking ID -->
                    <div x-show="openTrackingModal" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                            <h3 class="text-lg font-bold mb-4">Edit Tracking ID</h3>

                            <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <label class="block font-medium mb-1">Tracking ID</label>
                                <input type="text" name="tracking_id" value="{{ $report->tracking_id }}"
                                    class="w-full border rounded-lg px-3 py-2 mb-4 focus:ring focus:ring-blue-300">

                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="openTrackingModal = false"
                                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Kategori Aduan --}}
                <div x-data="{ openKategoriModal: false }">
                    <p class="flex items-center">
                        <i class="fas fa-folder-open text-gray-500 mr-1"></i>
                        <span class="font-medium">Kategori Aduan</span>
                        <span class="font-semibold ml-1">{{ $report->kategori->nama }}</span>
                </div>

                {{-- Wilayah --}}
                <div x-data="{ openWilayahModal: false }">
                    <p class="text-sm text-gray-700 flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-500 mr-1"></i>
                        <span class="ml-1.5 font-medium">Wilayah</span>
                        <span class="font-semibold text-gray-800 ml-1">{{ $report->wilayah->nama }}</span>

                        {{-- Icon Edit --}}
                        <button @click="openWilayahModal = true" class="ml-2 text-blue-600 hover:text-blue-800">
                            <i class="fas fa-edit"></i>
                        </button>
                    </p>

                    <!-- Modal Edit Wilayah -->
                    <div x-show="openWilayahModal" x-cloak
                        class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                            <h3 class="text-lg font-bold mb-4">Edit Wilayah</h3>

                            <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <label class="block font-medium mb-1">Pilih Wilayah</label>
                                <select name="wilayah_id"
                                    class="w-full border rounded-lg px-3 py-2 mb-4 focus:ring focus:ring-blue-300">
                                    @foreach($wilayahList as $wilayah)
                                        <option value="{{ $wilayah->id }}" @selected($report->wilayah_id == $wilayah->id)>
                                            {{ $wilayah->nama }}
                                        </option>
                                    @endforeach
                                </select>

                                <div class="flex justify-end gap-2">
                                    <button type="button" @click="openWilayahModal = false"
                                        class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>
                                    <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan --}}
            <div class=" text-gray-700">
                <p>
                    <span class="text-gray-600">Diadukan pada</span><br>
                    <span class="text-gray-800">
                        {{ $report->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}
                        WIB
                    </span>
                </p>

                <p class="flex items-center">
                    <span>Dilihat <strong>{{ $report->views }}</strong> kali</span>
                </p>

                @php
                    $vote = auth()->check()
                        ? \App\Models\Vote::where('user_id', auth()->user()->id_user)->where('report_id', $report->id)->value('vote_type')
                        : null;
                @endphp

                <div class="flex items-center gap-5 mt-1">
                    @auth
                        {{-- Tombol Like --}}
                        <form action="{{ route('report.like', $report->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center text-sm transition-all duration-200 
                                                                                                                                                                                                    {{ session('vote_report_' . $report->id) === 'like' ? 'text-blue-600 font-bold' : 'text-gray-400 hover:text-blue-500' }}">
                                <i class="fas fa-thumbs-up mr-1"></i> {{ $report->likes }}
                            </button>
                        </form>

                        {{-- Tombol Dislike --}}
                        <form action="{{ route('report.dislike', $report->id) }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center text-sm transition-all duration-200 
                                                                                                                                                                                                    {{ session('vote_report_' . $report->id) === 'dislike' ? 'text-red-600 font-bold' : 'text-gray-400 hover:text-red-500' }}">
                                <i class="fas fa-thumbs-down mr-1"></i> {{ $report->dislikes }}
                            </button>
                        </form>
                    @else
                        <div class="flex items-center gap-5 text-sm" x-data="{ showLike: false, showDislike: false }">
                            {{-- Like (Guest) --}}
                            <div class="relative" @mouseenter="showLike = true" @mouseleave="showLike = false">
                                <button disabled class="flex items-center text-gray-400 cursor-not-allowed">
                                    <i class="fas fa-thumbs-up mr-1"></i> {{ $report->likes }}
                                </button>
                                <div x-cloak x-show="showLike"
                                    class="absolute bottom-full mb-3 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 whitespace-nowrap pointer-events-none opacity-0 transition-opacity duration-200 ease-out"
                                    :class="{ 'opacity-100': showLike }">
                                    Harap login untuk like
                                </div>
                            </div>

                            {{-- Dislike (Guest) --}}
                            <div class="relative" @mouseenter="showDislike = true" @mouseleave="showDislike = false">
                                <button disabled class="flex items-center text-gray-400 cursor-not-allowed">
                                    <i class="fas fa-thumbs-down mr-1"></i> {{ $report->dislikes }}
                                </button>
                                <div x-cloak x-show="showDislike"
                                    class="absolute bottom-full mb-3 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs rounded px-2 py-1 whitespace-nowrap pointer-events-none opacity-0 transition-opacity duration-200 ease-out"
                                    :class="{ 'opacity-100': showDislike }">
                                    Harap login untuk dislike
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Judul & Isi + Modal --}}
        <div x-data="{ openModal: false }" class="mb-6">

            <!-- Judul + Tombol Edit -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-1 gap-2">
                <h2 class="text-xl font-bold text-red-700">{{ $report->judul }}</h2>
                <button @click="openModal = true"
                    class="bg-blue-600 text-white px-3 py-1 rounded-lg text-sm hover:bg-blue-700">
                    Edit
                </button>
            </div>

            <!-- Isi Laporan -->
            <div class="bg-white border rounded-lg shadow-sm p-6 max-h-96 overflow-y-scroll">
                <p class="text-gray-800 whitespace-pre-line">{{ $report->isi }}</p>
            </div>

            <!-- Modal Edit -->
            <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
                x-cloak>
                <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                    <h3 class="text-xl font-bold mb-4">Edit Laporan</h3>

                    <form action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Input Judul -->
                        <div class="mb-4">
                            <label class="block font-medium mb-1">Judul</label>
                            <input type="text" name="judul" value="{{ $report->judul }}"
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">
                        </div>

                        <!-- Input Isi -->
                        <div class="mb-4">
                            <label class="block font-medium mb-1">Isi</label>
                            <textarea name="isi" rows="6"
                                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-300">{{ $report->isi }}</textarea>
                        </div>

                        <!-- Tombol -->
                        <div class="flex justify-end gap-2">
                            <button type="button" @click="openModal = false"
                                class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">
                                Batal
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>


        {{-- Tabs --}}
        @php
            $badges = [
                'tindak' => $followUps->count(),
                'komentar' => $comments->count(),
                'lampiran' => is_array($report->file) ? count($report->file) : 0,
            ];
            $tabs = [
                'tindak' => ['label' => 'Tindak Lanjut', 'icon' => 'fa-clipboard-check'],
                'komentar' => ['label' => 'Komentar', 'icon' => 'fa-comments'],
                'lampiran' => ['label' => 'Lampiran', 'icon' => 'fa-paperclip'],
                'lokasi' => ['label' => 'Lokasi', 'icon' => 'fa-map-marker-alt'],
            ];
        @endphp

        <div class="border-b px-6 pt-2 flex space-x-6 text-sm font-semibold text-gray-600">
            @foreach ($tabs as $key => $tab)
                <button onclick="showTab('{{ $key }}')" id="tab-{{ $key }}"
                    class="tab-button py-2 border-b-2 border-transparent text-gray-600 hover:text-blue-600 relative transition duration-300">
                    <i class="fas {{ $tab['icon'] }} mr-1"></i>
                    {{ $tab['label'] }}
                    @if (!empty($badges[$key]))
                        <span class="absolute -top-1 -right-3 bg-blue-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                            {{ $badges[$key] }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>

        {{-- Modal Hapus Konfirmasi --}}
        <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-xl font-semibold mb-4">Konfirmasi Penghapusan</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus ini?</p>
                <form id="deleteForm" method="POST" class="space-x-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Hapus</button>
                    <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
                        onclick="closeDeleteModal()">Batal</button>
                </form>
            </div>
        </div>

        {{-- Tab Konten --}}
        <div class="p-6">
            {{-- Tindak Lanjut --}}
            <div class="tab-pane opacity-100 translate-y-0 transition-all duration-300" data-tab="tindak">
                <div class="max-h-96 overflow-y-auto pr-2">
                    @forelse ($followUps as $item)
                        <div class="mb-6 relative group bg-gray-50 rounded-md p-3 border shadow-sm">
                            <p class="text-sm text-gray-600">
                                <strong>{{ $item->user->name }}</strong>
                                <span class="text-gray-500">
                                    ({{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }})</span>
                            </p>
                            <p class="text-gray-800 mb-2">{{ $item->pesan }}</p>

                            @if ($item->file)
                                @php
                                    $filePath = asset('storage/' . $item->file);
                                    $fileExtension = pathinfo($item->file, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                    <!-- Tampilkan Gambar -->
                                    <img src="{{ $filePath }}"
                                        class="w-32 h-auto rounded shadow cursor-pointer hover:opacity-80 transition-opacity"
                                        onclick="openModal('{{ $filePath }}')" alt="Lampiran Tindak Lanjut">
                                @elseif ($fileExtension === 'pdf')
                                    <!-- Tampilkan PDF -->
                                    <a href="{{ $filePath }}"
                                        class="text-red-600 hover:bg-red-100 hover:text-red-700 p-2 rounded transition-all flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file-pdf mr-2"></i> PDF File
                                    </a>
                                @elseif (in_array(strtolower($fileExtension), ['doc', 'docx']))
                                    <!-- Tampilkan Word File -->
                                    <a href="{{ $filePath }}"
                                        class="text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded transition-all flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file-word mr-2"></i> Word Document
                                    </a>
                                @elseif ($fileExtension === 'zip')
                                    <!-- Tampilkan ZIP File -->
                                    <a href="{{ $filePath }}"
                                        class="text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 p-2 rounded transition-all flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file-archive mr-2"></i> ZIP Archive
                                    </a>
                                @elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx']))
                                    <!-- Tampilkan Excel File -->
                                    <a href="{{ $filePath }}"
                                        class="text-green-600 hover:bg-green-100 hover:text-green-700 p-2 rounded transition-all flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file-excel mr-2"></i> Excel File
                                    </a>
                                @else
                                    <!-- File Lain yang Tidak Didukung -->
                                    <a href="{{ $filePath }}"
                                        class="text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded transition-all flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file mr-2"></i> Lihat File
                                    </a>
                                @endif
                            @endif

                            {{-- Tombol hapus tindak lanjut --}}
                            @if (auth()->check())
                                @if (auth()->user()->role === 'superadmin')
                                    {{-- Superadmin bisa hapus semua tindak lanjut --}}
                                    <button
                                        onclick="openDeleteModal('{{ route('reports.followup.delete', [$report->id, $item->id]) }}')"
                                        class="absolute top-2 right-2 text-red-600 text-xs hover:text-red-800 border border-red-600 rounded-full p-1 z-10">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                @elseif (auth()->user()->role === 'admin' && $item->user && $item->user->role === 'admin')
                                    {{-- Admin hanya bisa hapus tindak lanjut dari admin --}}
                                    <button
                                        onclick="openDeleteModal('{{ route('reports.followup.delete', [$report->id, $item->id]) }}')"
                                        class="absolute top-2 right-2 text-red-600 text-xs hover:text-red-800 border border-red-600 rounded-full p-1 z-10">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                @endif
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada tindak lanjut.</p>
                    @endforelse
                </div>

                {{-- Form Tindak Lanjut --}}
                @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                    <form action="{{ route('reports.followup', ['id' => $report->id]) }}" method="POST"
                        enctype="multipart/form-data" class="mt-6 space-y-4">
                        @csrf
                        <textarea name="pesan" class="w-full border rounded p-2" rows="4" placeholder="Tindak lanjut..."
                            required></textarea>
                        <input type="file" name="file" class="block w-full border rounded p-1">
                        <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">
                            Kirim Tindak Lanjut
                        </button>
                    </form>
                @endif
            </div>

            {{-- Komentar --}}
            <div class="tab-pane opacity-0 translate-y-4 transition-all duration-300 hidden" data-tab="komentar">
                <div class="max-h-96 overflow-y-auto pr-2">
                    @forelse ($comments as $item)
                        <div class="relative group mb-6 bg-gray-50 rounded-md p-3 border shadow-sm">
                            <p class="text-sm text-gray-600">
                                <strong>{{ $item->user->name }}</strong>
                                <span
                                    class="text-gray-500">({{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }})</span>
                            </p>
                            <p class="text-gray-800 mb-2">{{ $item->pesan }}</p>

                            @if ($item->file)
                                @php
                                    $filePath = asset('storage/' . $item->file);
                                    $fileExtension = pathinfo($item->file, PATHINFO_EXTENSION);
                                @endphp

                                @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                    <!-- Tampilkan Gambar -->
                                    <img src="{{ $filePath }}"
                                        class="w-32 h-auto rounded shadow cursor-pointer hover:opacity-80 transition-opacity"
                                        onclick="openModal('{{ $filePath }}')" alt="Lampiran Komentar">
                                @elseif ($fileExtension === 'pdf')
                                    <!-- Tampilkan PDF -->
                                    <a href="{{ $filePath }}"
                                        class="text-red-600 hover:bg-red-100 hover:text-red-700 p-2 rounded transition-all flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file-pdf mr-2"></i> PDF File
                                    </a>
                                @elseif (in_array(strtolower($fileExtension), ['doc', 'docx']))
                                    <!-- Tampilkan Word File -->
                                    <a href="{{ $filePath }}"
                                        class="text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded transition-all flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file-word mr-2"></i> Word Document
                                    </a>
                                @elseif ($fileExtension === 'zip')
                                    <!-- Tampilkan ZIP File -->
                                    <a href="{{ $filePath }}"
                                        class="text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 p-2 rounded transition-all flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file-archive mr-2"></i> ZIP Archive
                                    </a>
                                @elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx']))
                                    <!-- Tampilkan Excel File -->
                                    <a href="{{ $filePath }}"
                                        class="text-green-600 hover:bg-green-100 hover:text-green-700 p-2 rounded transition-all flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file-excel mr-2"></i> Excel File
                                    </a>
                                @else
                                    <!-- File Lain yang Tidak Didukung -->
                                    <a href="{{ $filePath }}"
                                        class="text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded transition-all flex items-center"
                                        target="_blank">
                                        <i class="fas fa-file mr-2"></i> Lihat File
                                    </a>
                                @endif
                            @endif


                            {{-- Tombol hapus komentar --}}
                            @if (auth()->check())
                                @php
                                    $authUser = auth()->user();
                                @endphp

                                @if ($authUser->role === 'superadmin')
                                    {{-- Superadmin bisa hapus semua komentar --}}
                                    <button onclick="openDeleteModal('{{ route('reports.comment.delete', $item->id) }}')"
                                        class="absolute top-2 right-2 text-red-600 text-xs hover:text-red-800 border border-red-600 rounded-full p-1 z-10">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>

                                @elseif ($authUser->role === 'admin')
                                    {{-- Admin bisa hapus komentarnya sendiri atau komentar selain superadmin --}}
                                    @if ($authUser->id === $item->user_id || ($item->user && $item->user->role !== 'superadmin'))
                                        <button onclick="openDeleteModal('{{ route('reports.comment.delete', $item->id) }}')"
                                            class="absolute top-2 right-2 text-red-600 text-xs hover:text-red-800 border border-red-600 rounded-full p-1 z-10">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    @endif

                                @else
                                    {{-- User biasa hanya bisa hapus komentarnya sendiri --}}
                                    @if ($authUser->id === $item->user_id)
                                        <button onclick="openDeleteModal('{{ route('reports.comment.delete', $item->id) }}')"
                                            class="absolute top-2 right-2 text-red-600 text-xs hover:text-red-800 border border-red-600 rounded-full p-1 z-10">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    @endif
                                @endif
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada komentar.</p>
                    @endforelse
                </div>

                {{-- Form Komentar --}}
                @if (auth()->check() && in_array(auth()->user()->role, ['user', 'admin', 'superadmin']))
                    <form action="{{ route('reports.comment', ['id' => $report->id]) }}" method="POST"
                        enctype="multipart/form-data" class="mt-6 space-y-4">
                        @csrf
                        <textarea name="pesan" class="w-full border rounded p-2" rows="4" placeholder="Tulis komentar..."
                            required></textarea>
                        <input type="file" name="file" class="block w-full border rounded p-1">
                        <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">
                            Kirim Komentar
                        </button>
                    </form>
                @else
                    <div
                        class="mt-2 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded text-sm flex items-start gap-2">
                        <i class="fas fa-info-circle mt-1"></i>
                        <p>
                            Silakan <a href="{{ route('login') }}"
                                class="font-bold hover:underline hover:text-yellow-600">login</a>
                            untuk memberi komentar
                        </p>
                    </div>
                @endif
            </div>

            {{-- Lampiran --}}
            <div class="tab-pane opacity-0 translate-y-4 transition-all duration-300 hidden" data-tab="lampiran">

                {{-- Form Upload Lampiran Baru --}}
                <form action="{{ route('admin.reports.update', $report->id) }}" method="POST"
                    enctype="multipart/form-data" class="mb-4 flex items-center gap-2">
                    @csrf
                    @method('PUT')

                    <input type="file" name="file[]" multiple
                        class="border rounded-lg px-3 py-2 text-sm focus:ring focus:ring-blue-300">

                    <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700">
                        <i class="fas fa-upload mr-1"></i> Upload
                    </button>
                </form>

                {{-- List Lampiran --}}
                @if (!empty($report->file) && is_array($report->file))
                    <div class="flex flex-wrap gap-4 mt-2">
                        @foreach ($report->file as $index => $file)
                            @php
                                $filePath = asset('storage/' . ltrim($file, '/'));
                                $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                            @endphp

                            <div class="relative border rounded-lg p-2 shadow-sm bg-gray-50" x-data="{ openDeleteModal: false }">
                                {{-- Tombol Hapus (Buka Modal) --}}
                                <button type="button" @click="openDeleteModal = true"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-xs flex items-center justify-center">
                                    ✕
                                </button>

                                {{-- Preview File --}}
                                @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                    <!-- Gambar -->
                                    <img src="{{ $filePath }}"
                                        class="w-32 h-auto rounded shadow cursor-pointer hover:opacity-80 transition-opacity"
                                        onclick="openModal('{{ $filePath }}')" alt="Lampiran Gambar">

                                @elseif ($fileExtension === 'pdf')
                                    <!-- PDF -->
                                    <a href="{{ $filePath }}" target="_blank"
                                        class="flex items-center text-red-600 hover:bg-red-100 hover:text-red-700 p-2 rounded transition-all">
                                        <i class="fas fa-file-pdf mr-2"></i> PDF File
                                    </a>

                                @elseif (in_array($fileExtension, ['doc', 'docx']))
                                    <!-- Word -->
                                    <a href="{{ $filePath }}" target="_blank"
                                        class="flex items-center text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded transition-all">
                                        <i class="fas fa-file-word mr-2"></i> Word Document
                                    </a>

                                @elseif ($fileExtension === 'zip')
                                    <!-- ZIP -->
                                    <a href="{{ $filePath }}" target="_blank"
                                        class="flex items-center text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 p-2 rounded transition-all">
                                        <i class="fas fa-file-archive mr-2"></i> ZIP Archive
                                    </a>

                                @elseif (in_array($fileExtension, ['xls', 'xlsx']))
                                    <!-- Excel -->
                                    <a href="{{ $filePath }}" target="_blank"
                                        class="flex items-center text-green-600 hover:bg-green-100 hover:text-green-700 p-2 rounded transition-all">
                                        <i class="fas fa-file-excel mr-2"></i> Excel File
                                    </a>

                                @else
                                    <!-- File lainnya -->
                                    <a href="{{ $filePath }}" target="_blank"
                                        class="flex items-center text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded transition-all">
                                        <i class="fas fa-file mr-2"></i> Lihat Lampiran
                                    </a>
                                @endif

                                {{-- Modal Konfirmasi Hapus --}}
                                <div x-show="openDeleteModal" x-cloak
                                    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                                    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                                        <h3 class="text-lg font-bold mb-4">Konfirmasi Hapus Lampiran</h3>
                                        <p class="text-gray-600 mb-4">Apakah kamu yakin ingin menghapus lampiran ini?</p>

                                        <div class="flex justify-end gap-2">
                                            <button type="button" @click="openDeleteModal = false"
                                                class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Batal</button>

                                            <form action="{{ route('superadmin.reports.file.delete', [$report->id, $index]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">Tidak ada lampiran.</p>
                @endif
            </div>

            {{-- Lokasi --}}
            <div class="tab-pane opacity-0 translate-y-4 transition-all duration-300 hidden" data-tab="lokasi">
                @if ($report->lokasi && $report->latitude && $report->longitude)
                    <p class="text-sm text-gray-700 mb-2"><strong>Alamat:</strong> {{ $report->lokasi }}</p>
                    <p class="text-sm text-gray-700 mb-2">
                        <strong>Lintang:</strong> {{ $report->latitude }}<br>
                        <strong>Bujur:</strong> {{ $report->longitude }}
                    </p>
                    <div id="map" class="w-full h-64 rounded shadow"></div>
                @else
                    <p class="text-gray-500">Lokasi belum tersedia.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal Gambar --}}
    <div id="imgModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
        <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
        <img id="modalImage" class="max-w-3xl max-h-[90vh] rounded shadow-xl">
    </div>
@endsection

@section('include-js')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Tampilkan tab default
            showTab('tindak');

            // Inisialisasi peta jika ada koordinat
            const lat = {{ $report->latitude ?? 0 }};
            const lng = {{ $report->longitude ?? 0 }};
            const mapElement = document.getElementById('map');

            if (lat && lng) {
                // Membuat peta
                const map = L.map(mapElement).setView([lat, lng], 17);

                // Menambahkan tile layer (OpenStreetMap)
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(map);

                // Menambahkan marker
                L.marker([lat, lng]).addTo(map);

                // Fungsi untuk mengatur ulang ukuran peta
                function resizeMap() {
                    map.invalidateSize();
                }

                // Mengatur ulang ukuran peta saat halaman pertama kali dimuat
                window.addEventListener('load', () => {
                    setTimeout(() => {
                        resizeMap();  // Panggil invalidateSize setelah beberapa detik
                    }, 500); // Memberikan waktu bagi elemen lain untuk dimuat
                });

                // Mengatur ulang ukuran peta jika ukuran layar berubah
                window.addEventListener('resize', () => {
                    setTimeout(() => {
                        resizeMap();  // Mengatur ulang ukuran peta
                    }, 200);  // Memberikan waktu sedikit agar perubahan ukuran layar selesai
                });

                // Mengatur ulang ukuran peta jika container peta tampilkan ulang
                const observer = new MutationObserver(() => {
                    resizeMap();
                });

                observer.observe(mapElement, { attributes: true, childList: true, subtree: true });

                // Event listener untuk tab lokasi muncul
                const tabLokasi = document.getElementById('tab-lokasi'); // Pastikan ID tab lokasi sesuai

                if (tabLokasi) {
                    tabLokasi.addEventListener('click', () => {
                        setTimeout(() => {
                            resizeMap();  // Pastikan invalidateSize dipanggil saat tab lokasi diklik
                        }); // Memberikan sedikit waktu agar konten dapat ditampilkan
                    });
                }
            }

            // Auto-hide pesan sukses (flash message)
            const msg = document.getElementById('successMessage');
            if (msg) {
                setTimeout(() => {
                    msg.classList.add('transition-opacity', 'duration-500');
                    msg.style.opacity = '0';
                    setTimeout(() => msg.remove(), 500);
                }, 2000);
            }
        });

        // Menampilkan modal konfirmasi penghapusan
        function openDeleteModal(deleteUrl) {
            document.getElementById('deleteForm').action = deleteUrl;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        // Menutup modal konfirmasi penghapusan
        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        function showTab(tab) {
            const buttons = document.querySelectorAll('.tab-button');
            const panes = document.querySelectorAll('.tab-pane');

            buttons.forEach(btn => {
                btn.classList.remove('border-blue-600', 'text-blue-600');
                btn.classList.add('border-transparent', 'text-gray-600');
            });

            panes.forEach(pane => {
                pane.classList.add('hidden', 'opacity-0', 'translate-y-4');
                pane.classList.remove('opacity-100', 'translate-y-0');
            });

            const activeBtn = document.getElementById(`tab-${tab}`);
            activeBtn.classList.remove('text-gray-600', 'border-transparent');
            activeBtn.classList.add('border-blue-600', 'text-blue-600');

            const activePane = document.querySelector(`.tab-pane[data-tab="${tab}"]`);
            activePane.classList.remove('hidden');
            void activePane.offsetWidth;
            activePane.classList.add('opacity-100', 'translate-y-0');
            activePane.classList.remove('opacity-0', 'translate-y-4');
        }

        function openModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imgModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imgModal').classList.add('hidden');
        }
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

@endsection