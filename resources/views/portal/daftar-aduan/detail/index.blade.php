@extends('portal.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
    <div class="max-w-xl mx-auto px-5 py-6 mb-5 mt-20">

        @if (session('success'))
            <div id="successMessage" class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tombol Kembali --}}
        <div class="sticky top-0 bg-white z-10 py-2">
            <a href="{{ route('daftar-aduan') }}"
                class="flex items-center text-red-500 hover:text-red-700 transition-colors duration-200 text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        {{-- Card Utama --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mt-4 p-4">

            {{-- Judul + Nomor Aduan --}}
            <div class="bg-white px-2 pt-2 flex items-start justify-between">
                {{-- Kiri: Judul & Nomor Aduan --}}
                <div>
                    <h2 class="text-lg font-extrabold text-black">Detail Aduan Warga</h2>
                    <p class="text-sm mt-1 font-medium text-gray-400">Nomor Aduan</p>
                    <p class="text-sm mt-1 font-bold text-gray-900 tracking-wide">
                        {{ $report->tracking_id }}
                    </p>
                </div>

                {{-- Kanan: Views & Like/Dislike --}}
                <div class="text-right self-end">
                    {{-- Views --}}
                    <p class="text-sm mb-1">
                        <i class="fas fa-eye text-gray-500 mr-1"></i>
                        Dilihat <strong>{{ $report->views }}</strong> kali
                    </p>

                    {{-- Like/Dislike --}}
                    <div class="flex items-center gap-3 justify-end">
                        @auth
                            <form action="{{ route('report.like', $report->id) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center text-sm transition-all duration-200
                                                                                                                                                                                                                                                                                                                                                                                                    {{ session('vote_report_' . $report->id) === 'like' ? 'text-blue-600 font-bold' : 'text-gray-400 hover:text-blue-500' }}">
                                    <i class="fas fa-thumbs-up mr-1"></i> {{ $report->likes }}
                                </button>
                            </form>
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

            {{-- Foto --}}
            @php
                $defaultImage = asset('images/image.jpg');
                $thumbnail = $defaultImage;
                if (!empty($report->file)) {
                    $files = is_array($report->file) ? $report->file : json_decode($report->file, true);
                    if (is_array($files)) {
                        foreach ($files as $f) {
                            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                $thumbnail = asset('storage/' . $f);
                                break;
                            }
                        }
                    }
                }
            @endphp

            <div class="relative group cursor-pointer overflow-hidden rounded-t-xl mt-4"
                onclick="openImageModal('{{ $thumbnail }}')">
                <img src="{{ $thumbnail }}" alt="Foto Aduan"
                    class="w-full h-64 object-cover transition duration-300 group-hover:brightness-75 rounded-t-2xl">

                <!-- Overlay Biru (z-10) -->
                <div
                    class="absolute inset-0 bg-gradient-to-t from-blue-800/20 via-blue-600/10 to-blue-500/10 opacity-0 group-hover:opacity-100 transition duration-300 z-10">
                </div>

                <!-- Overlay Gelap + Icon (z-20) -->
                <div
                    class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 
                                                                                                                        transition duration-300 bg-black/20 z-20">
                    <i class="fas fa-search-plus text-white text-3xl"></i>
                </div>
            </div>

            <!-- Modal Gambar -->
            <div id="imageModal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 hidden">
                <button class="absolute top-5 right-5 text-white text-3xl" onclick="closeImageModal()">
                    <i class="fas fa-times"></i>
                </button>
                <img id="modalImage" src="" class="max-w-[90%] max-h-[90%] rounded-lg shadow-lg">
            </div>

            {{-- Konten --}}
            <div class="p-2 mt-6 text-gray-700 text-sm">

                <!-- Pelapor -->
                <div class="flex items-start gap-3 mb-3">
                    <!-- Icon -->
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-100">
                        <i class="fas fa-user text-gray-500 text-xl"></i>
                    </div>

                    <!-- Content -->
                    <div>
                        <div class="text-gray-600 text-sm font-semibold">Pelapor</div>
                        <div class="flex items-center flex-wrap gap-2">
                            <span class="text-gray-500 text-sm">
                                {{ $report->is_anonim ? 'Anonim' : $report->nama_pengadu }}
                            </span>
                            <!-- Status -->
                            <span
                                class="px-2 py-0.5 rounded-full text-xs font-medium
                                                                                                        @if($report->status === 'Diajukan') border border-red-500 text-red-500
                                                                                                        @elseif($report->status === 'Dibaca') border border-blue-500 text-blue-500
                                                                                                        @elseif($report->status === 'Direspon') border border-yellow-500 text-yellow-600
                                                                                                        @elseif($report->status === 'Selesai') border border-green-500 text-green-500
                                                                                                        @else border border-gray-400 text-gray-600 @endif">
                                {{ $report->status }}
                            </span>
                            <!-- Kategori -->
                            <span class="px-2 py-0.5 border border-red-500 text-red-500 rounded-full text-xs font-medium">
                                {{ $report->kategori->nama }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tanggal -->
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-100">
                        <i class="fas fa-calendar-alt text-gray-500 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-600 text-sm font-semibold">Tanggal</div>
                        <div class="text-gray-500 text-sm">
                            {{ $report->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('DD MMMM YYYY, HH:mm') }}
                            WIB
                        </div>
                    </div>
                </div>

                <!-- Wilayah -->
                <div class="flex items-start gap-3 mb-3">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-100">
                        <i class="fas fa-map text-gray-500 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-600 text-sm font-semibold">Wilayah</div>
                        <div class="text-gray-500 text-sm">{{ $report->wilayah->nama }}</div>
                    </div>
                </div>

                <!-- Disposisi -->
                <div class="flex items-start gap-3 mb-7">
                    <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-100">
                        <i class="fas fa-share-square text-gray-500 text-xl"></i>
                    </div>
                    <div>
                        <div class="text-gray-600 mb-1 text-sm font-semibold">Disposisi</div>
                        <div>
                            @if($report->admin)
                                <span
                                    class="inline-block px-3 py-1 rounded-full text-xs font-semibold 
                                                                                                                                                                                                        border border-transparent bg-gradient-to-r from-blue-500 to-cyan-500 
                                                                                                                                                                                                        text-white shadow-md hover:shadow-lg">
                                    {{ $report->admin->name }}
                                </span>
                            @else
                                <span class="italic text-gray-500 text-sm">Belum didisposisikan</span>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Isi Aduan --}}
                <div>
                    <h3 class="text-xl md:text-2xl font-bold text-gray-900 mt-2">
                        {{ $report->judul }}
                    </h3>
                    <p class="text-gray-800 whitespace-pre-line text-justify leading-relaxed">
                        {{ $report->isi }}
                    </p>
                </div>

                {{-- Timeline Aduan --}}
                <div>
                    <h2 class="text-xl font-bold text-gray-900 mb-5 mt-5">Timeline Aduan</h2>

                    <div class="relative border-l-4 border-blue-400 ml-3">
                        @foreach($timeline as $item)
                                <div class="mb-4 ml-6">
                                    {{-- Bulatan status --}}
                                    <div class="absolute -left-5 flex items-center justify-center w-8 h-8 rounded-full
                            @if($item['type'] === 'created') bg-red-500 text-white
                            @elseif($item['type'] === 'assigned') bg-orange-500 text-white
                            @elseif($item['type'] === 'read') bg-blue-500 text-white
                            @elseif($item['type'] === 'followup') bg-purple-500 text-white
                            @elseif($item['type'] === 'comment') bg-yellow-500 text-white
                            @elseif($item['type'] === 'done') bg-green-500 text-white
                            @else bg-gray-400 text-white @endif">

                                        @if($item['type'] === 'created')
                                            <i class="fas fa-edit"></i>
                                        @elseif($item['type'] === 'assigned')
                                            <i class="fas fa-share-square"></i>
                                        @elseif($item['type'] === 'read')
                                            <i class="fas fa-eye"></i>
                                        @elseif($item['type'] === 'followup')
                                            <i class="fas fa-tasks"></i>
                                        @elseif($item['type'] === 'comment')
                                            <i class="fas fa-comments"></i>
                                        @elseif($item['type'] === 'done')
                                            <i class="fas fa-check-circle"></i>
                                        @else
                                            <i class="fas fa-info-circle"></i>
                                        @endif
                                    </div>

                                    {{-- Konten timeline --}}
                                    <div class="p-4 ml-1 bg-white rounded-xl shadow-md">
                                        <span class="text-sm text-gray-500">
                                            {{ \Carbon\Carbon::parse($item['time'])->format('d M Y H:i') }}
                                        </span>
                                        <h3 class="text-base font-semibold mt-1">{{ $item['title'] }}</h3>
                                        @if(!empty($item['description']))
                                            <p class="text-gray-600 mt-1">{{ $item['description'] }}</p>
                                        @endif
                                    </div>
                                </div>
                        @endforeach
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

                <div class="border-b px-1 pt-5 flex space-x-8 text-sm font-semibold text-gray-600">
                    @foreach ($tabs as $key => $tab)
                        <button onclick="showTab('{{ $key }}')" id="tab-{{ $key }}"
                            class="tab-button py-2 border-b-2 border-transparent text-gray-600 hover:text-blue-600 relative transition duration-300">
                            <i class="fas {{ $tab['icon'] }} mr-1"></i>
                            {{ $tab['label'] }}
                            @if (!empty($badges[$key]))
                                <span
                                    class="absolute -top-1 -right-3 bg-blue-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                                    {{ $badges[$key] }}
                                </span>
                            @endif
                        </button>
                    @endforeach
                </div>

                {{-- Modal Hapus Konfirmasi --}}
                <div id="deleteModal"
                    class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
                    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                        <h3 class="text-xl font-semibold mb-4">Konfirmasi Penghapusan</h3>
                        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus ini?</p>
                        <form id="deleteForm" method="POST" class="space-x-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Hapus</button>
                            <button type="button" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
                                onclick="closeDeleteModal()">Batal</button>
                        </form>
                    </div>
                </div>

                {{-- Tab Konten --}}
                <div class="p-2">
                    {{-- Tindak Lanjut --}}
                    <div class="tab-pane opacity-100 translate-y-0 transition-all duration-300" data-tab="tindak">
                        <div class="max-h-96 overflow-y-auto pr-2">
                            @forelse ($followUps as $item)
                                <div class="mb-6 relative group bg-gray-50 rounded-md p-3 border shadow-sm">
                                    <p class="text-xs text-gray-600">
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
                                    @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                        <button
                                            onclick="openDeleteModal('{{ route('reports.followup.delete', [$report->id, $item->id]) }}')"
                                            class="absolute top-2 right-2 text-red-600 text-xs hover:text-red-800 border border-red-600 rounded-full p-1 z-10">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    @endif
                                </div>
                            @empty
                                <p class="mt-4 text-gray-500">Belum ada tindak lanjut.</p>
                            @endforelse
                        </div>

                        @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                            <form action="{{ route('reports.followup', ['id' => $report->id]) }}" method="POST"
                                enctype="multipart/form-data" class="mt-2 space-y-4">
                                @csrf
                                <textarea name="pesan" class="w-full border rounded p-2" rows="4" placeholder="Tindak lanjut..."
                                    required></textarea>
                                <input type="file" name="file" class="block w-full border rounded p-1">
                                <button type="submit"
                                    class="flex items-center gap-3 px-6 py-3 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition group">
                                    <i class="fas fa-paper-plane text-white"></i>
                                    <span>Kirim Tindak Lanjut</span>
                                </button>
                            </form>
                        @endif
                    </div>

                    {{-- Komentar --}}
                    <div class="tab-pane opacity-0 translate-y-4 transition-all duration-300 hidden" data-tab="komentar">
                        <div class="max-h-96 overflow-y-auto pr-2">
                            @forelse ($comments as $item)
                                <div class="relative group mb-6 bg-gray-50 rounded-md p-3 border shadow-sm">
                                    <p class="text-xs text-gray-600">
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
                                    @if (auth()->check() && (auth()->id() === $item->user_id || in_array(auth()->user()->role, ['admin', 'superadmin'])))
                                        <button onclick="openDeleteModal('{{ route('reports.comment.delete', $item->id) }}')"
                                            class="absolute top-2 right-2 text-red-600 text-xs hover:text-red-800 border border-red-600 rounded-full p-1 z-10">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </button>
                                    @endif
                                </div>
                            @empty
                                <p class="mt-4 text-gray-500">Belum ada komentar.</p>
                            @endforelse
                        </div>

                        @if (auth()->check() && in_array(auth()->user()->role, ['user', 'admin', 'superadmin']))
                            <form action="{{ route('reports.comment', ['id' => $report->id]) }}" method="POST"
                                enctype="multipart/form-data" class="mt-2 space-y-4">
                                @csrf
                                <textarea name="pesan" class="w-full border rounded p-2" rows="4"
                                    placeholder="Tulis komentar..." required></textarea>
                                <input type="file" name="file" class="block w-full border rounded p-1">
                                <button type="submit"
                                    class="flex items-center gap-3 px-6 py-3 rounded-full bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition group">
                                    <i class="fas fa-paper-plane text-white"></i>
                                    <span>Kirim Komentar</span>
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
                        @if (!empty($report->file) && is_array($report->file))
                            <div class="flex flex-wrap gap-4 mt-4">
                                @foreach ($report->file as $file)
                                    @php
                                        $filePath = asset('storage/' . ltrim($file, '/'));
                                        $fileExtension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                    @endphp

                                    @if (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif']))
                                        <!-- Gambar -->
                                        <div>
                                            <img src="{{ $filePath }}"
                                                class="w-32 h-auto rounded shadow cursor-pointer hover:opacity-80 transition-opacity"
                                                onclick="openImageModal('{{ $filePath }}')" alt="Lampiran Gambar">
                                        </div>
                                    @elseif ($fileExtension === 'pdf')
                                        <!-- PDF -->
                                        <div>
                                            <a href="{{ $filePath }}"
                                                class="text-red-600 hover:bg-red-100 hover:text-red-700 p-2 rounded transition-all flex items-center"
                                                target="_blank">
                                                <i class="fas fa-file-pdf mr-2"></i> PDF File
                                            </a>
                                        </div>
                                    @elseif (in_array($fileExtension, ['doc', 'docx']))
                                        <!-- Word -->
                                        <div>
                                            <a href="{{ $filePath }}"
                                                class="text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded transition-all flex items-center"
                                                target="_blank">
                                                <i class="fas fa-file-word mr-2"></i> Word Document
                                            </a>
                                        </div>
                                    @elseif ($fileExtension === 'zip')
                                        <!-- ZIP -->
                                        <div>
                                            <a href="{{ $filePath }}"
                                                class="text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 p-2 rounded transition-all flex items-center"
                                                target="_blank">
                                                <i class="fas fa-file-archive mr-2"></i> ZIP Archive
                                            </a>
                                        </div>
                                    @elseif (in_array($fileExtension, ['xls', 'xlsx']))
                                        <!-- Excel -->
                                        <div>
                                            <a href="{{ $filePath }}"
                                                class="text-green-600 hover:bg-green-100 hover:text-green-700 p-2 rounded transition-all flex items-center"
                                                target="_blank">
                                                <i class="fas fa-file-excel mr-2"></i> Excel File
                                            </a>
                                        </div>
                                    @else
                                        <!-- File lainnya -->
                                        <div>
                                            <a href="{{ $filePath }}"
                                                class="text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded transition-all flex items-center"
                                                target="_blank">
                                                <i class="fas fa-file mr-2"></i> Lihat Lampiran
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <p class="mt-4 text-gray-500">Tidak ada lampiran.</p>
                        @endif
                    </div>

                    {{-- Modal Gambar --}}
                    <div id="imageModal"
                        class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
                        <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer"
                            onclick="closeImageModal()">&times;</span>
                        <img id="modalImage" class="max-w-3xl max-h-[90vh] rounded shadow-xl">
                    </div>

                    {{-- Lokasi --}}
                    <div class="tab-pane opacity-0 translate-y-4 transition-all duration-300 hidden" data-tab="lokasi">
                        @if ($report->lokasi && $report->latitude && $report->longitude)
                            <p class="text-sm text-gray-700 mt-4 mb-2"><strong>Alamat:</strong> {{ $report->lokasi }}</p>
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
        </div>
    </div>
    </div>
@endsection

@section('include-js')
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
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

        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }
        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

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
    </script>
@endsection