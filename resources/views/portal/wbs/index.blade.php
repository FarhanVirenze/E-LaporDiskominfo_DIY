@extends('portal.layouts.app')

@section('content')
    <div class="relative w-full overflow-hidden">

        {{-- Hero Section --}}
        <div class="relative w-full h-[800px] md:h-[800px] lg:h-[800px] xl:h-[1000px] overflow-hidden font-sans">

            {{-- Background Layer --}}
            <div class="w-full h-full relative bg-gradient-to-tr from-red-700 via-red-600 to-orange-500">
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="absolute inset-0 grid grid-cols-4 gap-10 justify-items-center items-center opacity-25">
                    <i class="fas fa-file-alt text-white text-7xl"></i>
                    <i class="fas fa-exclamation-triangle text-yellow-300 text-7xl"></i>
                    <i class="fas fa-eye text-orange-200 text-7xl"></i>
                    <i class="fas fa-handshake text-white text-7xl"></i>
                    <i class="fas fa-user-shield text-yellow-200 text-7xl"></i>
                    <i class="fas fa-gavel text-orange-300 text-7xl"></i>
                    <i class="fas fa-search text-white text-7xl"></i>
                    <i class="fas fa-comment-dots text-yellow-100 text-7xl"></i>
                </div>
            </div>

            {{-- Konten Tengah --}}
            <div
                class="absolute inset-0 flex flex-col items-center justify-center px-6 md:px-20 text-center space-y-4 md:space-y-6 bg-black/50">
                <h2
                    class="text-white font-extrabold text-3xl md:text-5xl lg:text-6xl leading-snug tracking-tight drop-shadow-lg">
                    Whistleblowing System (WBS)
                </h2>
                <p class="text-white text-sm md:text-xl font-medium tracking-wide max-w-2xl">
                    Platform untuk melaporkan pelanggaran secara cepat, aman, dan rahasia, sehingga setiap aduan dapat
                    ditindaklanjuti dengan tepat.
                </p>
                <div
                    class="inline-flex items-center gap-3 sm:gap-4 px-4 sm:px-6 py-2 rounded-xl bg-gradient-to-r from-red-600 to-red-700 shadow-lg">
                    <div class="flex items-center justify-center w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-red-800">
                        <i class="fas fa-exclamation-triangle text-white text-sm sm:text-lg"></i>
                    </div>
                    <p class="text-[11px] sm:text-sm md:text-lg font-semibold text-white tracking-wide">
                        Laporkan Pelanggaran, <span class="italic font-normal">Aman & Terjamin Rahasia!</span>
                    </p>
                </div>
            </div>

            {{-- Wave --}}
            <svg class="absolute bottom-0 w-full h-32 md:h-40 lg:h-48" viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="#fff" fill-opacity="1"
                    d="M0,192 C240,64 360,288 720,160 C1080,32 1200,288 1440,128 L1440,320 L0,320 Z">
                </path>
            </svg>
        </div>

        {{-- Konten WBS --}}
        <div class="w-full mx-auto py-10 text-gray-800 -mt-16 relative z-10">

            @guest
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-6">
                    Untuk mengirim Aduan, Anda harus
                    <a href="{{ route('login') }}"
                        class="font-semibold text-blue-700 hover:text-blue-900 hover:underline transition">
                        login
                    </a> terlebih dahulu.
                </div>

                <div class="bg-blue-100 border border-blue-300 text-blue-900 rounded-lg p-6 mb-6">
                    <h2 class="text-xl font-bold mb-2">Apa itu Whistleblowing System (WBS)?</h2>
                    <p class="text-sm leading-relaxed mb-3"><span class="font-semibold">Whistleblowing System (WBS)</span>
                        adalah mekanisme pelaporan pelanggaran secara rahasia.</p>
                    <p class="text-sm leading-relaxed">Pelapor dijamin <span class="font-semibold">kerahasiaannya</span> dan
                        bisa tetap <span class="font-semibold">anonim</span>.</p>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 text-yellow-900 rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-2">Kategori Pelanggaran</h2>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        <li>Gratifikasi</li>
                        <li>Penyimpangan dari Tugas dan Fungsi</li>
                        <li>Benturan Kepentingan</li>
                        <li>Melanggar Peraturan dan Perundangan</li>
                        <li>Tindak Pidana Korupsi</li>
                    </ul>
                </div>
            @endguest

            {{-- Auth --}}
            @auth
                {{-- Tabs --}}
                <div class="flex justify-center mb-2 mt-4 border-b border-gray-200 overflow-x-auto">
                    <a href="?tab=formulir"
                        class="px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base font-semibold whitespace-nowrap {{ request()->get('tab') !== 'riwayat' ? 'bg-red-700 text-white border-b-4 border-red-900' : 'text-gray-600 hover:text-red-700' }}">Formulir
                        WBS</a>
                    <a href="?tab=riwayat"
                        class="px-4 sm:px-6 py-2 sm:py-3 text-sm sm:text-base font-semibold whitespace-nowrap {{ request()->get('tab') === 'riwayat' ? 'bg-red-700 text-white border-b-4 border-red-900' : 'text-gray-600 hover:text-red-700' }}">Pantau
                        Aduan WBS</a>
                </div>

                {{-- Toast Notifications --}}
                <div x-data="{ show: true, progress: 100 }"
                    x-init="let interval = setInterval(() => { if(progress<=0){show=false;clearInterval(interval)} else{progress-=2}},60);"
                    x-show="show" x-transition:enter="transition ease-out duration-300 transform"
                    x-transition:enter-start="translate-x-5 opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
                    x-transition:leave="transition ease-in duration-300 transform"
                    x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="translate-x-5 opacity-0"
                    class="fixed top-16 right-5 z-60 space-y-3 pointer-events-auto">

                    @if(session('success'))
                        <div
                            class="relative flex flex-col max-w-sm w-full bg-blue-100 border border-blue-300 text-blue-800 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between p-4">
                                <div class="flex items-center gap-2"><i class="fa-solid fa-circle-check text-blue-600"></i> <span
                                        class="font-medium">{{ session('success') }}</span></div>
                                <button @click="show=false" class="ml-3 text-blue-600 hover:text-blue-800"><i
                                        class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="h-1 bg-blue-200 rounded-b-lg overflow-hidden">
                                <div class="h-full bg-blue-600 transition-all duration-75" :style="`width: ${progress}%;`"></div>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div
                            class="relative flex flex-col max-w-sm w-full bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-lg">
                            <div class="flex items-center justify-between p-4">
                                <div class="flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation text-red-600"></i>
                                    <span class="font-medium">{{ session('error') }}</span>
                                </div>
                                <button @click="show=false" class="ml-3 text-red-600 hover:text-red-800"><i
                                        class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="h-1 bg-red-200 rounded-b-lg overflow-hidden">
                                <div class="h-full bg-red-600 transition-all duration-75" :style="`width: ${progress}%;`"></div>
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div
                            class="relative flex flex-col max-w-sm w-full bg-red-100 border border-red-300 text-red-800 rounded-lg shadow-lg">
                            <div class="flex items-start justify-between p-4">
                                <div class="flex flex-col gap-1">
                                    <div class="flex items-center gap-2 mb-1"><i class="fa-solid fa-circle-xmark text-red-600"></i>
                                        <span class="font-semibold">Terjadi kesalahan:</span>
                                    </div>
                                    <ul class="list-disc list-inside text-sm space-y-1">@foreach($errors->all() as $err)<li>
                                        {{ $err }}
                                    </li>@endforeach</ul>
                                </div>
                                <button @click="show=false" class="ml-3 text-red-600 hover:text-red-800 shrink-0"><i
                                        class="fa-solid fa-xmark"></i></button>
                            </div>
                            <div class="h-1 bg-red-200 rounded-b-lg overflow-hidden">
                                <div class="h-full bg-red-600 transition-all duration-75" :style="`width: ${progress}%;`"></div>
                            </div>
                        </div>
                    @endif
                </div>
                @if (request()->get('tab') === 'riwayat')
                    <div class="relative shadow-lg rounded-none sm:rounded-xl overflow-hidden mx-auto text-center bg-cover bg-center p-8 sm:p-12"
                        style="background-image: url('/images/red.jpg'); max-width: 1250px;">

                        <!-- Overlay gelap transparan untuk kontras teks -->
                        <div class="absolute inset-0 bg-black/10"></div>

                        <div class="relative z-10 flex flex-col items-center justify-center space-y-4 md:space-y-6">
                            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white leading-tight">
                                Lacak Aduan Wbs
                            </h2>
                            <p class="text-white/80 text-sm sm:text-base md:text-lg max-w-xl">
                                Cari tahu Aduan Wbs dengan memasukkan Kode Unik Aduan Anda.
                            </p>

                            <form action="{{ route('user.aduan.riwayatwbs.track') }}" method="POST"
                                class="w-full sm:w-4/5 md:w-3/4 lg:w-2/3 flex flex-col items-center space-y-4 pb-6 mx-auto">
                                @csrf
                                <input type="text" name="tracking_id" placeholder="Masukkan Kode Unik Aduan"
                                    class="w-full bg-white text-gray-900 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-red-500 focus:border-red-500 text-center py-2 px-4 sm:py-3 sm:px-6 @error('tracking_id') border-red-500 @enderror"
                                    value="{{ old('tracking_id') }}" required>

                                <!-- Error message -->
                                @error('tracking_id')
                                    <p class="relative z-20 mt-2 text-red-500 text-sm text-center">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <button type="submit"
                                    class="w-full bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white font-semibold py-2 sm:py-3 rounded-full shadow-md transition-all duration-300">
                                    Lacak
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Layer Partikel -->
                    <div id="particles-js" class="absolute inset-0 z-0 pointer-events-none"></div>
                    {{-- Formulir WBS --}}
                    <div class="relative bg-cover bg-center shadow-2xl rounded-3xl p-6 md:p-10 lg:p-16 max-w-7xl mx-auto"
                        style="background-image: url('/images/red.jpg');">

                        {{-- Overlay semi-transparan untuk kontras --}}
                        <div class="absolute inset-0 bg-black/10 rounded-2xl"></div>

                        <form action="{{ route('wbs.store') }}" method="POST" enctype="multipart/form-data"
                            class="relative space-y-8 z-10">
                            @csrf

                            {{-- Data Diri Pengadu --}}
                            <section class="space-y-4">
                                <h2 class="text-2xl font-bold text-white border-b border-white/50 pb-2">Data Diri Pengadu</h2>
                                <ul class="text-sm text-white/80 list-disc list-inside space-y-1">
                                    <li>Bisa menggunakan nama samaran.</li>
                                    <li>Isikan email dan/atau nomor telepon yang bisa dihubungi.</li>
                                    <li>Kerahasiaan data dijamin.</li>
                                    <li>Centang <span class="font-semibold">Kirim sebagai Anonim</span> untuk menyembunyikan
                                        identitas.</li>
                                </ul>

                                <div x-data="{ anonim: {{ old('is_anonim') ? 'true' : 'false' }} }" class="space-y-4">
                                    {{-- Checkbox Anonim --}}
                                    <div class="flex items-center gap-2">
                                        <input type="checkbox" name="is_anonim" value="1" id="is_anonim" x-model="anonim"
                                            class="w-5 h-5 text-red-500 border-gray-300 rounded focus:ring-red-400">
                                        <label for="is_anonim" class="text-white font-medium text-sm">Kirim Sebagai
                                            Anonim</label>
                                    </div>

                                    {{-- Form Identitas --}}
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" x-show="!anonim">
                                        <div>
                                            <label class="block text-sm font-medium text-white">Nama *</label>
                                            <input type="text" name="nama_pengadu" placeholder="Masukkan Nama"
                                                value="{{ old('nama_pengadu', $user->name ?? '') }}"
                                                class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-white/90 text-black focus:ring-2 focus:ring-red-400 focus:border-red-400"
                                                {{ $user ? 'readonly' : '' }}>
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-white">Email **</label>
                                            <input type="email" name="email_pengadu" placeholder="Masukkan Email"
                                                value="{{ old('email_pengadu', $user->email ?? '') }}"
                                                class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-white/90 text-black focus:ring-2 focus:ring-red-400 focus:border-red-400"
                                                {{ $user ? 'readonly' : '' }}>
                                        </div>

                                        <div class="sm:col-span-2">
                                            <label class="block text-sm font-medium text-white">No. Telepon **</label>
                                            <input type="text" name="telepon_pengadu" placeholder="Masukkan No. Telepon"
                                                value="{{ old('telepon_pengadu', $user->nomor_telepon ?? '') }}"
                                                class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-white/90 text-black focus:ring-2 focus:ring-red-400 focus:border-red-400"
                                                {{ $user ? 'readonly' : '' }}>
                                        </div>

                                        @if($user && !empty($user->nik))
                                            <div class="sm:col-span-2">
                                                <label class="block text-sm font-medium text-white">NIK</label>
                                                <input type="text" name="nik" placeholder="Nomor Induk Kependudukan"
                                                    value="{{ old('nik', $user->nik) }}"
                                                    class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-gray-100 text-black"
                                                    readonly>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </section>

                            {{-- Data Aduan --}}
                            <section class="space-y-4">
                                <h2 class="text-2xl font-bold text-white border-b border-white/50 pb-2">Data Aduan</h2>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                                    {{-- Nama Terlapor --}}
                                    <div x-data="{ text: '', max: 50 }">
                                        <label class="block text-sm font-medium text-white">Nama yang Diadukan *</label>
                                        <input type="text" name="nama_terlapor" x-model="text" maxlength="50"
                                            placeholder="John Doe, Kepala Bidang tertentu"
                                            class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-white/90 text-black focus:ring-2 focus:ring-red-400 focus:border-red-400">
                                        <p class="text-xs text-white/70 mt-1" x-text="text.length + '/' + max"></p>
                                    </div>

                                    {{-- Wilayah --}}
                                    <div>
                                        <label class="block text-sm font-medium text-white">Wilayah *</label>
                                        <select name="wilayah_id"
                                            class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-white/90 text-black focus:ring-2 focus:ring-red-400 focus:border-red-400">
                                            <option value="">-- Pilih Wilayah --</option>
                                            @foreach($wilayahUmum as $wilayah)
                                                <option value="{{ $wilayah->id }}">{{ $wilayah->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Kategori --}}
                                    <div>
                                        <label class="block text-sm font-medium text-white">Kategori Pelanggaran *</label>
                                        <select name="kategori_id"
                                            class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-white/90 text-black focus:ring-2 focus:ring-red-400 focus:border-red-400">
                                            <option value="">-- Pilih Kategori --</option>
                                            @forelse(App\Models\KategoriUmum::where('tipe', 'wbs_admin')->get() as $kategori)
                                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                            @empty
                                                <option value="" disabled>Tidak ada kategori WBS Admin tersedia</option>
                                            @endforelse
                                        </select>
                                    </div>

                                    {{-- Tanggal --}}
                                    <div>
                                        <label class="block text-sm font-medium text-white">Tanggal Kejadian *</label>
                                        <input type="date" name="tanggal_kejadian" value="{{ old('tanggal_kejadian') }}"
                                            class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-white/90 text-black focus:ring-2 focus:ring-red-400 focus:border-red-400">
                                    </div>

                                    {{-- Waktu --}}
                                    <div>
                                        <label class="block text-sm font-medium text-white">Waktu Kejadian *</label>
                                        <input type="time" name="waktu_kejadian" value="{{ old('waktu_kejadian') }}"
                                            class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-white/90 text-black focus:ring-2 focus:ring-red-400 focus:border-red-400">
                                    </div>

                                    {{-- Tempat Kejadian --}}
                                    <div class="sm:col-span-2" x-data="{ text: '', max: 100 }">
                                        <label class="block text-sm font-medium text-white">Tempat Kejadian Pelanggaran
                                            *</label>
                                        <input type="text" name="lokasi_kejadian" x-model="text" maxlength="100"
                                            placeholder="Ruang Sidang Kantor X, Jl. Makmur no.25, Depok, Sleman"
                                            class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-white/90 text-black focus:ring-2 focus:ring-red-400 focus:border-red-400">
                                        <p class="text-xs text-white/70 mt-1" x-text="text.length + '/' + max"></p>
                                    </div>

                                    {{-- Uraian Aduan --}}
                                    <div class="sm:col-span-2" x-data="{ text: '', max: 2000 }">
                                        <label class="block text-sm font-medium text-white">Uraian Aduan *</label>
                                        <textarea name="uraian" rows="3" x-model="text" maxlength="2000"
                                            placeholder="Tulis kronologi dan informasi lengkap"
                                            class="w-full border border-white/50 rounded-lg shadow-sm px-3 py-2 bg-white/90 text-black focus:ring-2 focus:ring-red-400 focus:border-red-400"></textarea>
                                        <p class="text-xs text-white/70 mt-1" x-text="text.length + '/' + max"></p>
                                    </div>

                                </div>
                            </section>

                            {{-- Lampiran --}}
                            <section class="space-y-4">
                                <h2 class="text-2xl font-bold text-white border-b border-white/50 pb-2">Lampiran</h2>
                                <p class="text-sm text-white/80">
                                    Maksimal 3 file, masing-masing maksimal 10 MB. Jenis file: dokumen, gambar, audio, video,
                                    arsip.
                                    Total ukuran tidak boleh lebih dari 30 MB.
                                </p>

                                {{-- Tombol tambah --}}
                                <button type="button" id="add-upload"
                                    class="px-4 py-2 bg-gradient-to-r from-red-500 to-red-700 text-white rounded-lg shadow font-semibold hover:from-red-600 hover:to-red-800 transition duration-300">
                                    + Tambah Lampiran
                                </button>

                                {{-- Wrapper input dinamis --}}
                                <div id="lampiran-wrapper" class="space-y-2"></div>
                            </section>

                            {{-- Script --}}
                            <script>
                                document.addEventListener("DOMContentLoaded", () => {
                                    const wrapper = document.getElementById("lampiran-wrapper");
                                    const addBtn = document.getElementById("add-upload");
                                    let count = 0;
                                    const maxFiles = 3;

                                    addBtn.addEventListener("click", () => {
                                        if (count < maxFiles) {
                                            count++;

                                            // Container input + hapus
                                            const div = document.createElement("div");
                                            div.classList.add("flex", "items-center", "space-x-2");

                                            // Input file
                                            const input = document.createElement("input");
                                            input.type = "file";
                                            input.name = "lampiran[]";
                                            input.classList.add(
                                                "flex-1",
                                                "border-gray-300",
                                                "rounded-lg",
                                                "shadow-sm",
                                                "text-sm",
                                                "text-white",
                                                "bg-white/10",
                                                "file:mr-3",
                                                "file:py-1.5",
                                                "file:px-3",
                                                "file:rounded-md",
                                                "file:border-0",
                                                "file:text-sm",
                                                "file:font-semibold",
                                                "file:bg-red-600",
                                                "file:text-white",
                                                "hover:file:bg-red-700",
                                                "cursor-pointer"
                                            );

                                            // Tombol hapus dengan ikon trash
                                            const removeBtn = document.createElement("button");
                                            removeBtn.type = "button";
                                            removeBtn.innerHTML = '<i class="fas fa-trash"></i>'; // pakai Font Awesome
                                            removeBtn.classList.add(
                                                "p-2",
                                                "bg-red-600/80",
                                                "hover:bg-red-700",
                                                "text-white",
                                                "rounded-lg",
                                                "shadow",
                                                "transition",
                                                "duration-200"
                                            );

                                            removeBtn.addEventListener("click", () => {
                                                div.remove();
                                                count--;
                                            });

                                            div.appendChild(input);
                                            div.appendChild(removeBtn);
                                            wrapper.appendChild(div);
                                        } else {
                                            alert("Maksimal 3 lampiran saja.");
                                        }
                                    });
                                });
                            </script>

                            {{-- Persetujuan --}}
                            <section class="space-y-2 text-sm text-white/80">
                                <div class="flex items-start gap-2">
                                    <input type="checkbox" class="w-4 h-4 mt-1 rounded border-gray-300">
                                    <p>
                                        Dengan mengisi form ini, saya menyetujui
                                        <a href="{{ route('ketentuan.layanan') }}"
                                            class="text-blue-300 hover:text-blue-400 hover:underline transition">
                                            Ketentuan Layanan
                                        </a>
                                        dan
                                        <a href="{{ route('kebijakan.privasi') }}"
                                            class="text-blue-300 hover:text-blue-400 hover:underline transition">
                                            Kebijakan Privasi
                                        </a>.
                                    </p>
                                </div>
                                <div class="flex items-start gap-2">
                                    <input type="checkbox" class="w-4 h-4 mt-1 rounded border-gray-300">
                                    <p>Saya menyatakan data yang saya isikan benar adanya.</p>
                                </div>
                            </section>

                            {{-- === reCAPTCHA di sini === --}}
                            <div class="mt-4">
                                {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::renderJs() !!}
                                {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::display() !!}
                                @error('g-recaptcha-response')
                                    <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                                @enderror
                            </div>
                            {{-- Tombol Submit --}}
                            <button type="submit"
                                class="w-full bg-gradient-to-r from-red-500 to-red-700 hover:from-red-600 hover:to-red-800 text-white py-3 rounded-xl shadow font-semibold transition duration-300">
                                Adukan
                            </button>
                        </form>
                    </div>
                @endif
            @endauth
        </div>

        {{-- Particles.js --}}
        <script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
        <script>
            particlesJS("particles-js", {
                particles: {
                    number: { value: 60, density: { enable: true, value_area: 800 } },
                    color: { value: "#0F3D3E" },
                    shape: { type: "circle" },
                    opacity: { value: 0.3 },
                    size: { value: 5, random: true },
                    line_linked: {
                        enable: true,
                        distance: 150,
                        color: "#0F3D3E",
                        opacity: 0.2,
                        width: 1
                    },
                    move: {
                        enable: true,
                        speed: 2,
                        direction: "none",
                        random: false,
                        out_mode: "bounce"
                    }
                },
                interactivity: {
                    detect_on: "canvas",
                    events: {
                        onhover: { enable: true, mode: "repulse" },
                        onclick: { enable: true, mode: "push" }
                    },
                    modes: {
                        repulse: { distance: 100 },
                        push: { particles_nb: 4 }
                    }
                },
                retina_detect: true
            });
        </script>
@endsection