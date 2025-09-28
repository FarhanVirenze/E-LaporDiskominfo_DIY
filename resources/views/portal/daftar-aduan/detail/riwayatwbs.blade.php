@extends('portal.layouts.app')

@section('content')
    <div class="w-full max-w-6xl mx-auto py-6 px-3 sm:px-6 mt-14 lg:px-8" x-data="{ openModal: null }">

        {{-- Tombol Kembali --}}
        <div class="sticky top-0 bg-white z-10 py-2">
            <a href="{{ route('user.aduan.riwayatwbs') }}"
                class="flex items-center text-red-500 hover:text-red-700 transition-colors duration-200 text-sm">
                <i class="fas fa-arrow-left mr-1"></i>
                Kembali
            </a>
        </div>

        {{-- Toast Notifikasi --}}
        <div x-data="{ show: true, progress: 100 }" x-init="
                                                             let interval = setInterval(() => {
                                                                 if(progress > 0) progress -= 1;
                                                                 else { show = false; clearInterval(interval); }
                                                             }, 30);
                                                         " class="fixed top-5 right-5 z-50 space-y-2">

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

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

                            {{-- Lampiran --}}
                            <div class="w-full h-full relative">
                                @if ($aduan->lampiran && count($aduan->lampiran) > 0)
                                    @php
                                        $firstImage = collect($aduan->lampiran)->first(fn($file) => preg_match('/\.(jpg|jpeg|png|gif)$/i', $file));
                                    @endphp
                                    @if ($firstImage)
                                        <div class="relative">
                                            <img src="{{ asset($firstImage) }}" alt="Lampiran"
                                                class="w-full h-52 object-cover rounded-lg shadow-sm">

                                            {{-- Overlay Nama Pengadu / Anonim --}}
                                            <span
                                                class="absolute bottom-2 left-1/2 transform -translate-x-1/2 bg-red-800 text-white font-bold text-sm px-3 py-1 rounded">
                                                {{ $aduan->is_anonim ? 'Anonim' : ($aduan->nama_pengadu ?? 'Tidak diketahui') }}
                                            </span>
                                        </div>
                                    @else
                                        <div
                                            class="flex items-center justify-center h-64 text-gray-400 italic bg-gray-50 rounded-lg">
                                            Tidak ada gambar (hanya file dokumen)
                                        </div>
                                    @endif
                                @else
                                    <div
                                        class="flex items-center justify-center h-64 text-gray-400 italic bg-gray-50 rounded-lg">
                                        Tidak ada lampiran
                                    </div>
                                @endif
                            </div>

                            {{-- Info Detail --}}
                            <div class="flex flex-col justify-start space-y-6">

                                {{-- Tracking & Waktu --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1"><i
                                                class="fas fa-hashtag"></i>
                                            Tracking ID</h2>
                                        <p class="text-sm font-semibold text-gray-900">{{ $aduan->tracking_id }}</p>
                                    </div>
                                    <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1"><i
                                                class="fas fa-clock"></i>
                                            Waktu Kejadian</h2>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $aduan->waktu_kejadian->format('d-m-Y H:i') }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Status & Kategori --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1"><i
                                                class="fas fa-info-circle"></i> Status</h2>
                                        <span class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full
                                                           {{ $aduan->status == 'Diajukan' ? 'bg-red-100 text-red-600' :
        ($aduan->status == 'Dibaca' ? 'bg-blue-100 text-blue-600' :
            ($aduan->status == 'Direspon' ? 'bg-yellow-100 text-yellow-600' : 'bg-green-100 text-green-600')) }}">
                                            {{ ucfirst($aduan->status) }}
                                        </span>

                                    </div>
                                    <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1"><i
                                                class="fas fa-tags"></i>
                                            Kategori</h2>
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-600">
                                            {{ $aduan->kategori->nama ?? '-' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Terlapor & Wilayah --}}
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1"><i
                                                class="fas fa-user-secret"></i> Terlapor</h2>
                                        <p class="font-semibold text-gray-900">{{ $aduan->nama_terlapor }}</p>
                                    </div>
                                    <div>
                                        <h2 class="text-xs text-gray-500 flex items-center gap-1"><i
                                                class="fas fa-map-marker-alt"></i> Wilayah</h2>
                                        <p class="font-semibold text-gray-900">{{ $aduan->wilayah->nama ?? '-' }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        {{-- Lokasi & Uraian full width --}}
                        <div class="mt-4 space-y-4 pt-2">
                            <div>
                                <h2 class="text-xs text-gray-500 flex items-center gap-1 mb-2"><i
                                        class="fas fa-map-marker-alt"></i> Lokasi Kejadian</h2>
                                <p class="text-base font-medium text-gray-900">{{ $aduan->lokasi_kejadian }}</p>
                            </div>
                            <div>
                                <h2 class="text-xs text-gray-500 flex items-center gap-1 mb-2"><i
                                        class="fas fa-align-left"></i>
                                    Uraian</h2>
                                <p class="text-base text-gray-900 leading-relaxed">{{ $aduan->uraian }}</p>
                            </div>
                        </div>

                    </div> {{-- End Detail Aduan --}}

                    {{-- Tindak Lanjut --}}
                    <div x-show="activeTab === 'followup'" x-cloak class="space-y-6">
                        <div class="space-y-4">
                            @forelse($aduan->followUps as $fu)
                                <div class="p-4 bg-gray-50 rounded-lg shadow">
                                    <p class="text-xs text-gray-500 mt-2">{{ $fu->user->name ?? 'Anonim' }} |
                                        {{ $fu->created_at->format('d-m-Y H:i') }}
                                    </p>
                                    <p class="text-sm text-gray-700">{{ $fu->deskripsi }}</p>
                                    @if($fu->lampiran)
                                        <img src="{{ asset($fu->lampiran) }}" alt="Lampiran"
                                            class="mt-2 w-32 h-32 object-cover rounded shadow">
                                    @endif
                                </div>
                            @empty
                                <p class="text-gray-500 italic">Belum ada tindak lanjut.</p>
                            @endforelse
                        </div>
                    </div>
                    {{-- Komentar --}}
                    <div x-show="activeTab === 'comment'" x-cloak class="space-y-6">

                        <div class="space-y-4">
                            @forelse($aduan->comments as $c)
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
                                                <img src="{{ asset($c->file) }}" alt="Lampiran"
                                                    class="mt-2 w-32 h-32 object-cover rounded cursor-pointer shadow border"
                                                    @click="$dispatch('open-image-modal', { url: '{{ asset($c->file) }}' })">
                                            @else
                                                <a href="{{ asset($c->file) }}" target="_blank"
                                                    class="text-xs text-blue-600 hover:underline">
                                                    Lihat File
                                                </a>
                                            @endif
                                        @endif
                                    </div>

                                    {{-- Tombol aksi: edit & hapus --}}
                                    <div class="flex gap-2 ml-4">
                                        @if(auth()->check() && (auth()->id() === $c->user_id || in_array(auth()->user()->role, ['admin', 'superadmin'])))
                                            {{-- Tombol Edit --}}
                                            <button
                                                @click="$dispatch('open-edit-comment', { id: {{ $c->id }}, pesan: '{{ $c->pesan }}' })"
                                                class="text-blue-600 hover:text-blue-800 text-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            {{-- Tombol Hapus --}}
                                            <button @click="$dispatch('open-delete-comment', { id: {{ $c->id }} })"
                                                class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 italic">Belum ada komentar.</p>
                            @endforelse
                        </div>

                        {{-- Form tambah komentar --}}
                        <form action="{{ route('user.wbs.comment.store', $aduan->id) }}" method="POST"
                            enctype="multipart/form-data" class="space-y-4 mt-4">
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

                    {{-- === GLOBAL Modal Preview Gambar === --}}
                    <div x-data="{ open: false, imageUrl: '' }"
                        x-on:open-image-modal.window="open = true; imageUrl = $event.detail.url">
                        <div x-cloak x-show="open"
                            class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50">
                            <div class="relative">
                                <button @click="open = false"
                                    class="absolute top-2 right-2 text-white text-2xl font-bold">&times;</button>
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
                                <form method="POST" :action="`/user/wbs/comment/${commentId}`"
                                    enctype="multipart/form-data">
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
                                <form method="POST" :action="`/user/wbs/comment/${commentId}`">
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
                </div> {{-- End Content Tabs --}}

            </div>
        </div>
@endsection