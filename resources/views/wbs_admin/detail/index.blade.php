@extends('wbs_admin.layouts.app')

@section('content')
    <div class="w-full max-w-6xl mx-auto py-6 px-3 sm:px-6 lg:px-8" x-data="{ openModal: null }">

        {{-- Tombol Kembali --}}
        <div class="sticky top-0 bg-white z-10 py-2 mb-4">
            <a href="{{ route('wbs_admin.kelola-aduan.index') }}"
                class="flex items-center text-red-500 hover:text-red-700 transition-colors duration-200 text-sm">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
        </div>

        <div x-data="{ show: true, progress: 100 }"
            x-init="
                                                                                                                                                    let interval = setInterval(() => {
                                                                                                                                                        if(progress > 0) progress -= 1;
                                                                                                                                                        else {
                                                                                                                                                            show = false;
                                                                                                                                                            clearInterval(interval);
                                                                                                                                                        }
                                                                                                                                                    }, 30);
                                                                                                                                                "
            class="fixed top-5 right-5 z-50 space-y-2">

            {{-- Success Toast --}}
            @if (session('success'))
                <div x-show="show" x-transition
                    class="relative flex flex-col max-w-sm w-full bg-blue-100 border border-blue-300 text-blue-800 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-check text-blue-600"></i>
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="ml-3 text-blue-600 hover:text-blue-800">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="h-1 bg-blue-200 rounded-b-lg overflow-hidden">
                        <div class="h-full bg-blue-600 transition-all duration-75" :style="`width: ${progress}%;`"></div>
                    </div>
                </div>
            @endif

            {{-- Error Toast --}}
            @if (session('error'))
                <div x-show="show" x-transition
                    class="relative flex flex-col max-w-sm w-full bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-lg">
                    <div class="flex items-center justify-between p-4">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                            <span class="font-medium">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="ml-3 text-red-600 hover:text-red-800">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="h-1 bg-red-200 rounded-b-lg overflow-hidden">
                        <div class="h-full bg-red-600 transition-all duration-75" :style="`width: ${progress}%;`"></div>
                    </div>
                </div>
            @endif

            {{-- Error Validation --}}
            @if ($errors->any())
                <div x-show="show" x-transition
                    class="relative flex flex-col max-w-sm w-full bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-lg">
                    <div class="flex flex-col p-4 gap-2">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-circle-xmark text-red-600"></i>
                            <span class="font-semibold">Terjadi kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                        <button @click="show = false" class="ml-auto mt-2 text-red-600 hover:text-red-800 shrink-0">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                    <div class="h-1 bg-red-200 rounded-b-lg overflow-hidden">
                        <div class="h-full bg-red-600 transition-all duration-75" :style="`width: ${progress}%;`"></div>
                    </div>
                </div>
            @endif

        </div>

        <div x-data="{ activeTab: 'detail' }" class="space-y-6">

            {{-- Card utama --}}
            <div class="bg-white shadow-md rounded-xl overflow-hidden">

                {{-- Header Judul --}}
                <div class="p-6 flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-900">Detail Aduan WBS</h1>

                    {{-- Tombol Selesai --}}
                    @if($report->status !== 'Selesai')
                        <form action="{{ route('wbs_admin.kelola-aduan.update', $report->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="field" value="status">
                            <input type="hidden" name="value" value="Selesai">

                            <button type="submit"
                                class="flex items-center justify-center gap-2 px-3 py-2 sm:px-4 sm:py-2 
                                                                                                                                                                                                   bg-green-600 text-white text-xs sm:text-sm font-semibold 
                                                                                                                                                                                                   rounded-lg shadow hover:bg-green-700 
                                                                                                                                                                                                   focus:ring-2 focus:ring-green-400 focus:outline-none 
                                                                                                                                                                                                   transition-all duration-200 w-full sm:w-auto">
                                <i class="fas fa-check-circle text-sm sm:text-base"></i>
                                <span class="truncate">Selesaikan Aduan</span>
                            </button>
                        </form>
                    @else
                        <span
                            class="inline-flex items-center justify-center gap-2 px-3 py-2 sm:px-4 sm:py-2 
                                                                                                                                                                                                   text-xs sm:text-sm font-semibold text-green-700 
                                                                                                                                                                                                   bg-green-100 rounded-lg w-full sm:w-auto">
                            <i class="fas fa-check-circle text-sm sm:text-base"></i>
                            Aduan Selesai
                        </span>
                    @endif
                </div>

                {{-- Tabs --}}
                <div class="border-b px-6">
                    <nav class="flex gap-6">
                        <button @click="activeTab = 'detail'"
                            :class="activeTab === 'detail' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="py-3 border-b-2 font-medium text-sm">
                            Detail Aduan
                        </button>
                        <button @click="activeTab = 'followup'"
                            :class="activeTab === 'followup' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="py-3 border-b-2 font-medium text-sm">
                            Tindak Lanjut
                        </button>
                        <button @click="activeTab = 'comment'"
                            :class="activeTab === 'comment' ? 'border-blue-600 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                            class="py-3 border-b-2 font-medium text-sm">
                            Komentar
                        </button>
                    </nav>
                </div>

                {{-- Content Tabs --}}
                <div class="p-6">

                    {{-- Detail Aduan --}}
                    <div x-show="activeTab === 'detail'" class="space-y-6">
                        {{-- Grid utama --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                     {{-- Kolom kiri: Lampiran --}}
<div class="w-full h-full relative">
    @if ($report->lampiran && count($report->lampiran) > 0)
        @php
            $firstImage = collect($report->lampiran)->first(
                fn($file) => preg_match('/\.(jpg|jpeg|png|gif)$/i', $file)
            );
        @endphp

        {{-- Preview gambar pertama --}}
        @if ($firstImage)
            <img src="{{ asset('storage/' . $firstImage) }}" alt="Lampiran"
                class="w-full h-full object-cover rounded-lg shadow-sm">
        @else
            <div class="flex items-center justify-center h-64 text-gray-400 italic bg-gray-50 rounded-lg">
                Tidak ada gambar (hanya file dokumen)
            </div>
        @endif

        {{-- Tombol Edit Lampiran --}}
        <button @click="openModal = 'lampiran'"
            class="absolute top-2 right-2 bg-white/80 p-2 rounded-full shadow hover:bg-white">
            <i class="fas fa-edit text-blue-600"></i>
        </button>
    @else
        <div class="flex items-center justify-center h-64 text-gray-400 italic bg-gray-50 rounded-lg relative">
            Tidak ada lampiran
            {{-- Tambah Lampiran --}}
            <button @click="openModal = 'lampiran'"
                class="absolute top-2 right-2 bg-white/80 p-2 rounded-full shadow hover:bg-white">
                <i class="fas fa-plus text-green-600"></i>
            </button>
        </div>
    @endif
</div>


                            {{-- Kolom kanan: Detail --}} <div class="flex flex-col justify-center space-y-6"> {{-- Tracking
                                ID & Waktu Kejadian --}} <div class="grid grid-cols-2 gap-4"> {{-- Tracking ID --}} <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1 justify-between"> <span
                                                class="flex items-center gap-1"> <i class="fas fa-hashtag"></i> Tracking ID
                                            </span> <button @click="openModal = 'tracking_id'"
                                                class="text-blue-500 hover:text-blue-700"> <i class="fas fa-edit"></i>
                                            </button> </h2>
                                        <p class="text-sm font-semibold text-gray-900"> {{ $report->tracking_id }} </p>
                                    </div> {{-- Waktu Kejadian --}} <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1 justify-between"> <span
                                                class="flex items-center gap-1"> <i class="fas fa-clock"></i> Waktu Kejadian
                                            </span> <button @click="openModal = 'waktu_kejadian'"
                                                class="text-blue-500 hover:text-blue-700"> <i class="fas fa-edit"></i>
                                            </button> </h2>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $report->waktu_kejadian->format('d-m-Y H:i') }}
                                        </p>
                                    </div>
                                </div> {{-- Status & Kategori --}} <div class="grid grid-cols-2 gap-4"> {{-- Status --}}
                                    <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1 justify-between"> <span
                                                class="flex items-center gap-1"> <i class="fas fa-info-circle"></i> Status
                                            </span> <button @click="openModal = 'status'"
                                                class="text-blue-500 hover:text-blue-700"> <i class="fas fa-edit"></i>
                                            </button> </h2> <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full {{ $report->status == 'Diajukan' ? 'bg-red-100 text-red-600' : ($report->status == 'Dibaca' ? 'bg-blue-100 text-blue-600' : ($report->status == 'Direspon' ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600')) }}">
                                            {{ ucfirst($report->status) }} </span>
                                    </div> {{-- Kategori --}} <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1 justify-between"> <span
                                                class="flex items-center gap-1"> <i class="fas fa-tags"></i> Kategori
                                            </span> <button @click="openModal = 'kategori_id'"
                                                class="text-blue-500 hover:text-blue-700"> <i class="fas fa-edit"></i>
                                            </button> </h2> <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-600">
                                            {{ $report->kategori->nama ?? '-' }} </span>
                                    </div>
                                </div> {{-- Terlapor & Wilayah --}} <div class="grid grid-cols-2 gap-4"> {{-- Terlapor --}}
                                    <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1 justify-between"> <span
                                                class="flex items-center gap-1"> <i class="fas fa-user-secret"></i> Terlapor
                                            </span> <button @click="openModal = 'nama_terlapor'"
                                                class="text-blue-500 hover:text-blue-700"> <i class="fas fa-edit"></i>
                                            </button> </h2>
                                        <p class="font-semibold text-gray-900"> {{ $report->nama_terlapor }} </p>
                                    </div> {{-- Wilayah --}} <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1 justify-between"> <span
                                                class="flex items-center gap-1"> <i class="fas fa-map-marker-alt"></i>
                                                Wilayah </span> <button @click="openModal = 'wilayah_id'"
                                                class="text-blue-500 hover:text-blue-700"> <i class="fas fa-edit"></i>
                                            </button> </h2>
                                        <p class="font-semibold text-gray-900"> {{ $report->wilayah->nama ?? '-' }} </p>
                                    </div>
                                </div>
                            </div>
                        </div> {{-- Bagian bawah --}} <div class="xl:pb-6 space-y-4"> {{-- Lokasi --}} <div>
                                <div class="flex justify-between items-start mb-3">
                                    <h2 class="text-xs text-gray-500 flex items-center gap-1"> <i
                                            class="fas fa-map-marker-alt"></i> Lokasi Kejadian </h2> <button
                                        @click="openModal = 'lokasi_uraian'"
                                        class="flex items-center gap-1 text-blue-500 hover:text-blue-700 text-sm"> <i
                                            class="fas fa-edit"></i> Edit </button>
                                </div>
                                <p class="text-base font-medium text-gray-900"> {{ $report->lokasi_kejadian }} </p>
                            </div> {{-- Uraian --}} <div class="mt-4">
                                <h2 class="text-xs text-gray-500 flex items-center gap-1 mb-3"> <i
                                        class="fas fa-align-left"></i> Uraian </h2>
                                <p class="text-base text-gray-900 leading-relaxed"> {{ $report->uraian }} </p>
                            </div>
                        </div>
                    </div>

                    {{-- === Tab Tindak Lanjut === --}}
                    <div x-show="activeTab === 'followup'" class="space-y-6">
                        <h2 class="text-lg font-semibold">Daftar Tindak Lanjut</h2>
                        <div class="space-y-4">
                            @forelse($report->followUps as $fu)
                                <div class="relative p-4 bg-gray-50 rounded-lg shadow">
                                    {{-- Tombol Edit & Hapus --}}
                                    <div class="absolute top-2 right-2 flex gap-2">
                                        {{-- Edit --}}
                                        <button
                                            @click="$dispatch('open-edit-modal', {id: {{ $fu->id }}, deskripsi: '{{ $fu->deskripsi }}' })"
                                            class="text-blue-600 hover:text-blue-800">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        {{-- Hapus --}}
                                        <button @click="$dispatch('open-delete-modal', {id: {{ $fu->id }}})"
                                            class="text-red-600 hover:text-red-800">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>

                                    <p class="text-xs text-gray-500 mt-2">
                                        {{ $fu->user->name ?? 'Anonim' }} | {{ $fu->created_at->format('d-m-Y H:i') }}
                                    </p>

                                    <p class="text-sm text-gray-700">{{ $fu->deskripsi }}</p>

                                    {{-- Preview Gambar --}}
                                    @if($fu->lampiran)
                                        <img src="{{ asset('storage/' . $fu->lampiran) }}" alt="Lampiran"
                                            class="mt-2 w-32 h-32 object-cover rounded cursor-pointer"
                                            @click="$dispatch('open-image-modal', {url: '{{ asset('storage/' . $fu->lampiran) }}' })">
                                    @endif


                                </div>
                            @empty
                                <p class="text-gray-500 italic">Belum ada tindak lanjut.</p>
                            @endforelse
                        </div>

                        {{-- Form tambah tindak lanjut --}}
                        <form action="{{ route('wbs_admin.kelola-aduan.storeFollowUp', $report->id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <textarea name="deskripsi" class="w-full border rounded p-2" rows="3"
                                placeholder="Tulis tindak lanjut..."></textarea>
                            <input type="file" name="lampiran" class="block text-sm">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700">
                                Simpan Tindak Lanjut
                            </button>
                        </form>
                    </div>

                    {{-- Modal Edit --}}
                    <div x-data="{ open: false, followupId: null, deskripsi: '' }"
                        x-on:open-edit-modal.window="open = true; followupId = $event.detail.id; deskripsi = $event.detail.deskripsi">

                        <div x-cloak x-show="open"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                            <div class="bg-white rounded-lg p-6 w-96 space-y-4">
                                <h3 class="text-lg font-semibold">Edit Tindak Lanjut</h3>

                                <form method="POST" :action="`/wbs_admin/followup/${followupId}`"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <textarea x-model="deskripsi" name="deskripsi" class="w-full border rounded p-2"
                                        rows="3"></textarea>

                                    <input type="file" name="lampiran" class="block text-sm mt-2">

                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" @click="open = false"
                                            class="px-3 py-1 text-gray-600">Batal</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Delete --}}
                    <div x-data="{ open: false, followupId: null }"
                        x-on:open-delete-modal.window="open = true; followupId = $event.detail.id">
                        <div x-cloak x-show="open"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg p-6 w-80 space-y-4">
                                <h3 class="text-lg font-semibold">Hapus Tindak Lanjut</h3>
                                <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus tindak lanjut ini?</p>
                                <form method="POST" :action="`/wbs_admin/kelola-aduan/follow-ups/${followupId}`">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" @click="open = false"
                                            class="px-3 py-1 text-gray-600">Batal</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Komentar --}}
                    <div x-show="activeTab === 'comment'" class="space-y-6">
                        <h2 class="text-lg font-semibold">Daftar Komentar</h2>

                        <div class="space-y-4">
                            @forelse($report->comments as $c)
                                <div class="p-4 bg-gray-50 rounded-lg shadow flex justify-between items-start">
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 mt-2">
                                            {{ $c->user->name ?? 'Anonim' }} | {{ $c->created_at->format('d-m-Y H:i') }}
                                        </p>

                                        <p class="text-sm text-gray-700">{{ $c->pesan }}</p>

                                        {{-- Lampiran --}}
                                        @if($c->file)
                                            @php
                                                $ext = strtolower(pathinfo($c->file, PATHINFO_EXTENSION));
                                                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                            @endphp

                                            @if($isImage)
                                                <img src="{{ asset('storage/' . $c->file) }}" alt="Lampiran"
                                                    class="mt-2 w-32 h-32 object-cover rounded cursor-pointer shadow border"
                                                    @click="$dispatch('open-image-modal', { url: '{{ asset('storage/' . $c->file) }}' })">
                                            @else
                                                <a href="{{ asset('storage/' . $c->file) }}" target="_blank"
                                                    class="text-xs text-blue-600 hover:underline">
                                                    Lihat File
                                                </a>
                                            @endif
                                        @endif
                                    </div>

                                    {{-- Tombol aksi edit & hapus --}}
                                    <div class="flex gap-2 ml-4">
                                        <!-- Edit -->
                                        <button
                                            @click="$dispatch('open-edit-comment', { id: {{ $c->id }}, pesan: '{{ $c->pesan }}' })"
                                            class="text-blue-600 hover:text-blue-800 text-sm">
                                            <i class="fas fa-edit"></i>
                                        </button>

                                        <!-- Hapus -->
                                        <button @click="$dispatch('open-delete-comment', { id: {{ $c->id }} })"
                                            class="text-red-600 hover:text-red-800 text-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">Belum ada komentar.</p>
                            @endforelse
                        </div>

                        {{-- Form tambah komentar --}}
                        <form action="{{ route('wbs_admin.kelola-aduan.storeComment', $report->id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-4">
                            @csrf
                            <textarea name="pesan" class="w-full border rounded p-2" rows="3"
                                placeholder="Tulis komentar..."></textarea>
                            <input type="file" name="file" class="block text-sm">
                            <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700">
                                Simpan Komentar
                            </button>
                        </form>
                    </div>

                    {{-- === GLOBAL Modal Preview Gambar (1x di luar semua tab) === --}}
                    <div x-data="{ open: false, imageUrl: '' }"
                        x-on:open-image-modal.window="open = true; imageUrl = $event.detail.url">
                        <div x-cloak x-show="open"
                            class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
                            <div class="relative">
                                {{-- Close Button --}}
                                <button @click="open = false"
                                    class="absolute top-2 right-2 text-white text-2xl font-bold">&times;</button>

                                {{-- Klik di luar untuk close --}}
                                <div @click.away="open = false">
                                    <img :src="imageUrl" alt="Lampiran" class="max-h-[80vh] max-w-[90vw] rounded shadow-lg">
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit Komentar --}}
                    <div x-data="{ open: false, commentId: null, pesan: '' }"
                        x-on:open-edit-comment.window="open = true; commentId = $event.detail.id; pesan = $event.detail.pesan">
                        <div x-cloak x-show="open"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg p-6 w-96 space-y-4">
                                <h3 class="text-lg font-semibold">Edit Komentar</h3>
                                <form method="POST" :action="`/wbs_admin/kelola-aduan/comment/${commentId}`">
                                    @csrf
                                    @method('PUT')
                                    <textarea x-model="pesan" name="pesan" class="w-full border rounded p-2"
                                        rows="3"></textarea>
                                    <input type="file" name="file" class="block text-sm mt-2">
                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" @click="open = false"
                                            class="px-3 py-1 text-gray-600">Batal</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Hapus Komentar --}}
                    <div x-data="{ open: false, commentId: null }"
                        x-on:open-delete-comment.window="open = true; commentId = $event.detail.id">
                        <div x-cloak x-show="open"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg p-6 w-80 space-y-4">
                                <h3 class="text-lg font-semibold">Hapus Komentar</h3>
                                <p class="text-sm text-gray-600">Apakah Anda yakin ingin menghapus komentar ini?</p>
                                <form method="POST" :action="`/wbs_admin/kelola-aduan/comment/${commentId}`">
                                    @csrf
                                    @method('DELETE')
                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" @click="open = false"
                                            class="px-3 py-1 text-gray-600">Batal</button>
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-600 text-white rounded-lg">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Modal edit (reusable) --}}
                <template x-if="openModal">
                    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                        <div class="bg-white rounded-xl shadow-lg w-full max-w-md p-6">

                            {{-- Judul --}}
                            <h2 class="text-lg font-semibold text-gray-800 mb-4">
                                Edit <span class="capitalize" x-text="openModal"></span>
                            </h2>

                            {{-- Form --}}
                            <form method="POST" :action="`{{ route('wbs_admin.kelola-aduan.update', $report->id) }}`"
                                class="space-y-4">
                                @csrf
                                @method('PATCH')

                                <input type="hidden" name="field" :value="openModal">

                                {{-- Input dinamis --}}
                                <div>
                                    {{-- Tracking ID --}}
                                    <template x-if="openModal === 'tracking_id'">
                                        <input type="text" name="value" class="w-full border rounded-lg px-3 py-2"
                                            value="{{ $report->tracking_id }}">
                                    </template>

                                    {{-- Nama Terlapor --}}
                                    <template x-if="openModal === 'nama_terlapor'">
                                        <input type="text" name="value" class="w-full border rounded-lg px-3 py-2"
                                            value="{{ $report->nama_terlapor }}">
                                    </template>

                                    {{-- Status --}}
                                    <template x-if="openModal === 'status'">
                                        <select name="value" class="w-full border rounded-lg px-3 py-2">
                                            <option value="Diajukan" {{ $report->status == 'Diajukan' ? 'selected' : '' }}>
                                                Diajukan
                                            </option>
                                            <option value="Dibaca" {{ $report->status == 'Dibaca' ? 'selected' : '' }}>
                                                Dibaca
                                            </option>
                                            <option value="Direspon" {{ $report->status == 'Direspon' ? 'selected' : '' }}>
                                                Direspon
                                            </option>
                                            <option value="Selesai" {{ $report->status == 'Selesai' ? 'selected' : '' }}>
                                                Selesai
                                            </option>
                                        </select>
                                    </template>

                                    {{-- Kategori --}}
                                    <template x-if="openModal === 'kategori_id'">
                                        <select name="value" class="w-full border rounded-lg px-3 py-2">
                                            @foreach(\App\Models\KategoriUmum::where('tipe', 'wbs_admin')->get() as $k)
                                                <option value="{{ $k->id }}" {{ $report->kategori_id == $k->id ? 'selected' : '' }}>
                                                    {{ $k->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </template>

                                    {{-- Wilayah --}}
                                    <template x-if="openModal === 'wilayah_id'">
                                        <select name="value" class="w-full border rounded-lg px-3 py-2">
                                            @foreach(\App\Models\WilayahUmum::all() as $w)
                                                <option value="{{ $w->id }}" {{ $report->wilayah_id == $w->id ? 'selected' : '' }}>
                                                    {{ $w->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </template>

                                    {{-- Waktu Kejadian --}}
                                    <template x-if="openModal === 'waktu_kejadian'">
                                        <input type="datetime-local" name="value" class="w-full border rounded-lg px-3 py-2"
                                            value="{{ $report->waktu_kejadian ? $report->waktu_kejadian->format('Y-m-d\TH:i') : '' }}">
                                    </template>

                                    {{-- Lokasi & Uraian --}}
                                    <template x-if="openModal === 'lokasi_uraian'">
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Lokasi
                                                    Kejadian</label>
                                                <input type="text" name="lokasi_kejadian"
                                                    class="w-full border rounded-lg px-3 py-2"
                                                    value="{{ $report->lokasi_kejadian }}">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700">Uraian</label>
                                                <textarea name="uraian" rows="4"
                                                    class="w-full border rounded-lg px-3 py-2">{{ $report->uraian }}</textarea>
                                            </div>
                                        </div>
                                    </template>
{{-- Modal Lampiran --}}
<template x-if="openModal === 'lampiran'">
    <div class="space-y-4">
        {{-- Upload File Baru --}}
        <form method="POST" action="{{ route('wbs_admin.kelola-aduan.update', $report->id) }}"
              enctype="multipart/form-data" class="space-y-3">
            @csrf
            @method('PATCH')
            <input type="hidden" name="field" value="lampiran">

            <input type="file" name="lampiran[]" multiple
                class="w-full border rounded-lg px-3 py-2 focus:ring focus:ring-blue-200">

            {{-- Tombol aksi --}}
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" @click="openModal=null"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                    Upload
                </button>
            </div>
        </form>
    
        {{-- Daftar Lampiran Lama --}}
        @if ($report->lampiran && count($report->lampiran) > 0)
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Lampiran Saat Ini</label>
                <ul class="space-y-2">
                    @foreach($report->lampiran as $file)
                        <li class="flex items-center justify-between bg-gray-50 p-2 rounded">
                            {{-- Thumbnail gambar kalau file image --}}
                            @if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file))
                                <img src="{{ asset('storage/' . $file) }}"
                                     class="w-12 h-12 object-cover rounded mr-2">
                            @endif

                            <span class="text-sm truncate flex-1">{{ basename($file) }}</span>

                            {{-- Tombol hapus --}}
                            <form method="POST" action="{{ route('wbs_admin.kelola-aduan.update', $report->id) }}">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="field" value="hapus_lampiran">
                                <input type="hidden" name="file" value="{{ $file }}">
                                <button type="submit"
                                    class="text-red-500 hover:text-red-700 text-sm ml-2">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</template>

                                   {{-- Default input --}}
<template
    x-if="!['status','kategori_id','wilayah_id','waktu_kejadian','lokasi_uraian','tracking_id','nama_terlapor','lampiran'].includes(openModal)">
    <input type="text" name="value" class="w-full border rounded-lg px-3 py-2"
        :placeholder="`Masukkan ${openModal} baru`">
</template>

                                </div>

                               {{-- Tombol aksi --}}
<div class="flex justify-end gap-2 pt-2" 
     x-show="openModal !== 'lampiran'">
    <button type="button" @click="openModal=null"
        class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition">
        Batal
    </button>
    <button type="submit"
        class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
        Simpan
    </button>
</div>

                            </form>
                        </div>
                    </div>
                </template>


            </div>
@endsection