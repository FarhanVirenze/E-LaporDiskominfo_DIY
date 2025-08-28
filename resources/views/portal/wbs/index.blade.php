@extends('portal.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4 sm:px-6 lg:px-8 text-gray-800">
    <h1 class="text-2xl sm:text-3xl font-bold text-center mt-14 mb-6 text-gray-900">
        WHISTLEBLOWING SYSTEM (WBS)
    </h1>

    {{-- Jika belum login (guest) --}}
    @guest
        <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-6">
            Untuk mengirim Aduan, Anda harus
            <a href="{{ route('login') }}"
                class="font-semibold text-blue-700 hover:text-blue-900 hover:underline transition">
                login
            </a>
            terlebih dahulu.
        </div>

        <div class="bg-blue-100 border border-blue-300 text-blue-900 rounded-lg p-6 mb-6">
            <h2 class="text-lg sm:text-xl font-bold mb-2">Apa itu Whistleblowing System (WBS)?</h2>
            <p class="text-sm leading-relaxed mb-3">
                <span class="font-semibold">Whistleblowing System (WBS)</span> adalah mekanisme pelaporan pelanggaran
                yang dilakukan secara rahasia dan aman oleh masyarakat atau pihak internal instansi.
                Sistem ini digunakan untuk melaporkan tindakan yang melanggar hukum, kode etik, atau peraturan lainnya.
            </p>
            <p class="text-sm leading-relaxed">
                Pelapor dijamin <span class="font-semibold">kerahasiaannya</span>, dan dapat memilih untuk tetap
                <span class="font-semibold">anonim</span>. Semua laporan akan diproses oleh pihak yang berwenang dengan
                prinsip kehati-hatian dan profesionalisme.
            </p>
        </div>

        <div class="bg-yellow-50 border border-yellow-200 text-yellow-900 rounded-lg p-6">
            <h2 class="text-lg sm:text-xl font-bold mb-2">Kategori Pelanggaran dalam WBS</h2>
            <ul class="list-disc list-inside space-y-1 text-sm">
                <li>Gratifikasi</li>
                <li>Penyimpangan dari Tugas dan Fungsi</li>
                <li>Benturan Kepentingan</li>
                <li>Melanggar Peraturan dan Perundangan yang Berlaku</li>
                <li>Tindak Pidana Korupsi</li>
            </ul>
            <p class="text-sm mt-3">
                Silakan pilih salah satu kategori tersebut saat mengisi formulir aduan agar laporan Anda dapat ditangani
                secara tepat.
            </p>
        </div>
    @endguest

    {{-- Jika sudah login (auth) tampilkan konten lama --}}
    @auth
    {{-- Tab Navigasi --}}
    <div class="flex justify-center mb-2 mt-4 border-b border-gray-200 overflow-x-auto">
        <a href="{{ route('wbs.index') }}" class="px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base font-semibold whitespace-nowrap {{ request()->get('tab') !== 'riwayat'
        ? 'bg-red-700 text-white border-b-4 border-red-900'
        : 'text-gray-600 hover:text-red-700' }}">
            Formulir WBS
        </a>
        <a href="{{ route('wbs.index', ['tab' => 'riwayat']) }}" class="px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base font-semibold whitespace-nowrap {{ request()->get('tab') === 'riwayat'
        ? 'bg-red-700 text-white border-b-4 border-red-900'
        : 'text-gray-600 hover:text-red-700' }}">
            Pantau Aduan WBS
        </a>
    </div>

    {{-- Toast Notification --}}
    <div x-data="{ show: true, progress: 100 }" x-init="
                        let interval = setInterval(() => {
                            if (progress <= 0) { 
                                show = false; 
                                clearInterval(interval); 
                            } else {
                                progress -= 2; // makin kecil = makin cepat habis (100/2 = 50 steps)
                            }
                        }, 60); // total kira-kira 3 detik
                    " x-show="show" x-transition:enter="transition ease-out duration-300 transform"
        x-transition:enter-start="translate-x-5 opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transition ease-in duration-300 transform"
        x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-5 opacity-0"
        class="fixed top-5 right-5 z-50 space-y-3">

        {{-- Success Toast --}}
        @if (session('success'))
            <div
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
                {{-- Progress Bar --}}
                <div class="h-1 bg-blue-200 rounded-b-lg overflow-hidden">
                    <div class="h-full bg-blue-600 transition-all duration-75" :style="`width: ${progress}%;`"></div>
                </div>
            </div>
        @endif

        {{-- Error Toast --}}
        @if (session('error'))
            <div
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
                {{-- Progress Bar --}}
                <div class="h-1 bg-red-200 rounded-b-lg overflow-hidden">
                    <div class="h-full bg-red-600 transition-all duration-75" :style="`width: ${progress}%;`"></div>
                </div>
            </div>
        @endif

        {{-- Error Validation --}}
        @if ($errors->any())
            <div
                class="relative flex flex-col max-w-sm w-full bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-lg">
                <div class="flex items-start justify-between p-4">
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fa-solid fa-circle-xmark text-red-600"></i>
                            <span class="font-semibold">Terjadi kesalahan:</span>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button @click="show = false" class="ml-3 text-red-600 hover:text-red-800 shrink-0">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                {{-- Progress Bar --}}
                <div class="h-1 bg-red-200 rounded-b-lg overflow-hidden">
                    <div class="h-full bg-red-600 transition-all duration-75" :style="`width: ${progress}%;`"></div>
                </div>
            </div>
        @endif

    </div>

    {{-- Konten Tab --}}
    @if (request()->get('tab') === 'riwayat')
        {{-- Form Pantau Aduan --}}
        <div class="bg-white shadow rounded-lg p-6 sm:p-8 max-w-lg mx-auto text-center">
            <h2 class="text-xl font-bold text-gray-800 mb-2">Pantau Aduan</h2>
            <p class="text-gray-600 mb-6 text-sm">
                Cari tahu kemajuan Aduan dengan memasukkan Kode Unik Aduan Anda.
            </p>

            <form action="{{ route('wbs.track') }}" method="GET" class="space-y-4">
                <input type="text" name="tracking_id" placeholder="Masukkan Kode Unik Aduan"
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500 text-center">

                <button type="submit"
                    class="w-full bg-red-700 text-white px-4 py-2 rounded-full shadow hover:bg-red-800 font-semibold">
                    PANTAU
                </button>
            </form>
        </div>
    @else
        {{-- Formulir WBS --}}
        <div class="bg-white shadow rounded-lg p-4 sm:p-6 lg:p-8">
            <form action="{{ route('wbs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                {{-- Data Diri Pengadu --}}
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 border-b pb-2">Data Diri Pengadu</h2>
                <ul class="text-sm text-gray-600 mb-4 list-disc list-inside space-y-1">
                    <li>Anda dapat menggunakan nama samaran sebagai isian nama.</li>
                    <li>** Isikan email dan/atau nomor telepon yang dapat dihubungi.</li>
                    <li>Kami menjamin kerahasiaan data diri pengadu.</li>
                    <li>Anda dapat memberi centang pada <span class="font-semibold">Kirim sebagai Anonim</span> jika Anda
                        memilih untuk tidak memberikan data diri Anda.</li>
                </ul>

                <div x-data="{ anonim: {{ old('is_anonim') ? 'true' : 'false' }} }" class="space-y-4">
                    {{-- Checkbox Anonim --}}
                    <div class="flex items-center space-x-2">
                        <input type="checkbox" name="is_anonim" value="1" id="is_anonim" x-model="anonim"
                            class="rounded border-gray-300">
                        <label for="is_anonim" class="text-sm text-gray-700">Kirim Sebagai Anonim</label>
                    </div>

                    {{-- Form Identitas --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-show="!anonim">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nama *</label>
                            <input type="text" name="nama_pengadu" placeholder="Masukkan Nama"
                                value="{{ old('nama_pengadu', $user->name ?? '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm" {{ $user ? 'readonly' : '' }}>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email **</label>
                            <input type="email" name="email_pengadu" placeholder="Masukkan Email"
                                value="{{ old('email_pengadu', $user->email ?? '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm" {{ $user ? 'readonly' : '' }}>
                        </div>

                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">No. Telepon **</label>
                            <input type="text" name="telepon_pengadu" placeholder="Masukkan No. Telepon"
                                value="{{ old('telepon_pengadu', $user->nomor_telepon ?? '') }}"
                                class="w-full border-gray-300 rounded-lg shadow-sm" {{ $user ? 'readonly' : '' }}>
                        </div>

                        @if($user && !empty($user->nik))
                            <div class="sm:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">NIK</label>
                                <input type="text" name="nik" placeholder="Nomor Induk Kependudukan"
                                    value="{{ old('nik', $user->nik) }}" class="w-full border-gray-300 rounded-lg shadow-sm"
                                    readonly>
                            </div>
                        @endif
                        @endauth
                    </div>
                </div>

                {{-- Data Aduan --}}
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 border-b pb-2">Data Aduan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Nama yang Diadukan --}}
                    <div x-data="{ text: '', max: 50 }">
                        <label class="block text-sm font-medium text-gray-700">Nama yang Diadukan *</label>
                        <input type="text" name="nama_terlapor" x-model="text" maxlength="50"
                            placeholder="John Doe, selaku Kepala Bidang tertentu"
                            class="w-full border-gray-300 rounded-lg shadow-sm">
                        <p class="text-xs text-gray-500 mt-1" x-text="text.length + '/' + max"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Wilayah *</label>
                        <select name="wilayah_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                            <option value="">-- Pilih Wilayah --</option>
                            @foreach($wilayahUmum as $wilayah)
                                <option value="{{ $wilayah->id }}">{{ $wilayah->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kategori Pelanggaran *</label>
                        <select name="kategori_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                            <option value="">-- Pilih Kategori --</option>
                            @forelse(App\Models\KategoriUmum::where('tipe', 'wbs_admin')->get() as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @empty
                                <option value="" disabled>Tidak ada kategori WBS Admin tersedia</option>
                            @endforelse
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Kejadian *</label>
                        <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Waktu Kejadian *</label>
                        <input type="time" name="waktu_kejadian" value="{{ old('waktu_kejadian') }}"
                            class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-red-500 focus:border-red-500">
                    </div>

                    {{-- Tempat Kejadian --}}
                    <div class="sm:col-span-2" x-data="{ text: '', max: 100 }">
                        <label class="block text-sm font-medium text-gray-700">Tempat Kejadian Pelanggaran *</label>
                        <input type="text" name="lokasi_kejadian" x-model="text" maxlength="100"
                            placeholder="Tulis sedetail mungkin, contoh: Ruang Sidang Kantor X, Jl. Makmur no.25, Depok, Sleman"
                            class="w-full border-gray-300 rounded-lg shadow-sm">
                        <p class="text-xs text-gray-500 mt-1" x-text="text.length + '/' + max"></p>
                    </div>
                    {{-- Uraian Aduan --}}
                    <div class="sm:col-span-2" x-data="{ text: '', max: 2000 }">
                        <label class="block text-sm font-medium text-gray-700">Uraian Aduan *</label>
                        <textarea name="uraian" rows="5" x-model="text" maxlength="2000"
                            placeholder="Tulis kronologi kejadian dan informasi lainnya selengkap mungkin sejauh yang Anda ketahui"
                            class="w-full border-gray-300 rounded-lg shadow-sm"></textarea>
                        <p class="text-xs text-gray-500 mt-1" x-text="text.length + '/' + max"></p>
                    </div>
                </div>

                {{-- Lampiran --}}
                <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-2 border-b pb-2">Lampiran</h2>
                <p class="text-sm text-gray-600 mb-3">
                    • Maksimal 3 file, masing-masing maksimal 10 MB.<br>
                    • Jenis file: dokumen, gambar, audio, video, arsip.<br>
                    • Total ukuran semua file tidak boleh lebih dari 30 MB.
                </p>

                <!-- Tombol tambah -->
                <button type="button" id="add-upload" class="mb-3 px-4 py-2 text-white rounded shadow font-semibold 
                   bg-gradient-to-r from-blue-500 to-cyan-600
                   hover:from-blue-700 hover:to-cyan-600 transition duration-300">
                    + Tambah Lampiran
                </button>

                <!-- Wrapper untuk input file -->
                <div id="lampiran-wrapper" class="space-y-2"></div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const wrapper = document.getElementById('lampiran-wrapper');
                        const addBtn = document.getElementById('add-upload');

                        addBtn.addEventListener('click', function () {
                            const inputs = wrapper.querySelectorAll('.lampiran-item');
                            if (inputs.length >= 3) {
                                alert('Maksimal 3 lampiran saja.');
                                return;
                            }

                            const div = document.createElement('div');
                            div.className = "lampiran-item flex items-center gap-2";

                            const input = document.createElement('input');
                            input.type = 'file';
                            input.name = 'lampiran[]';
                            input.className = 'border-gray-300 rounded-lg shadow-sm w-[80%] sm:flex-1';

                            const removeBtn = document.createElement('button');
                            removeBtn.type = 'button';
                            removeBtn.innerHTML = '<i class="fa-solid fa-trash"></i>';
                            removeBtn.className = 'shrink-0 px-3 py-2 text-red-600 hover:text-red-800 rounded';
                            removeBtn.addEventListener('click', function () {
                                div.remove();
                            });

                            div.appendChild(input);
                            div.appendChild(removeBtn);
                            wrapper.appendChild(div);
                        });
                    });
                </script>

                {{-- Persetujuan --}}
                <div class="space-y-2 text-sm text-gray-700">
                    <div>
                        <input type="checkbox" class="rounded border-gray-300">
                        Dengan mengisi form ini, saya menyetujui
                        <a href="#" class="text-red-600 underline">Ketentuan Layanan</a> dan
                        <a href="#" class="text-red-600 underline">Kebijakan Privasi</a>.
                    </div>
                    <div>
                        <input type="checkbox" class="rounded border-gray-300">
                        Saya menyatakan bahwa data yang saya isikan benar adanya.
                    </div>
                </div>

                {{-- Tombol --}}
                <button type="submit"
                    class="w-full bg-red-700 text-white px-4 py-2 rounded-lg shadow hover:bg-red-800 font-semibold">
                    Adukan
                </button>
            </form>
        </div>
    @endif
</div>
@endsection