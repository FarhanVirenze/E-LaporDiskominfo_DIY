@extends('portal.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet" />
@endsection

@section('content')
    @php
        $user = Auth::user();
    @endphp
    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div id="alert-success"
            class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 opacity-100 animate-fade-in">
            <!-- Icon Wrapper -->
            <div id="success-icon-wrapper" class="transition-all duration-300">
                <!-- Spinner awal -->
                <svg id="success-spinner" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>

                <!-- Centang, disembunyikan dulu -->
                <svg id="success-check" class="w-6 h-6 text-white hidden" fill="none" viewBox="0 0 24 24">
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <!-- Pesan -->
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div id="alert-error"
            class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 opacity-100 animate-fade-in">
            <!-- Icon -->
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- Pesan Error Global -->
    @if($errors->any())
        <div class="alert alert-danger bg-red-500 text-white p-4 rounded-lg mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Hero Section -->
    <section class="relative text-white overflow-hidden">
        <div class="lg:hidden relative h-[110vh]">
            <!-- Swiper -->
            <div class="swiper mySwiper w-full h-full relative z-10 invisible transition-opacity duration-300">
                <div class="swiper-wrapper">
                    <div class="swiper-slide relative">
                        <img src="{{ asset('images/carousel1.jpg') }}"
                            class="w-full h-full object-cover will-change-transform backface-hidden" loading="eager"
                            alt="E-Lapor">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#0039CB]/70 to-[#2962FF]/60"></div>
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>
                    <div class="swiper-slide relative">
                        <img src="{{ asset('images/carousel2.jpg') }}"
                            class="w-full h-full object-cover will-change-transform backface-hidden" loading="eager"
                            alt="Pengaduan">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#0039CB]/70 to-[#2962FF]/60"></div>
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>
                    <div class="swiper-slide relative">
                        <img src="{{ asset('images/carousel3.jpg') }}"
                            class="w-full h-full object-cover will-change-transform backface-hidden" loading="eager"
                            alt="Layanan Publik">
                        <div class="absolute inset-0 bg-gradient-to-r from-[#0039CB]/70 to-[#2962FF]/60"></div>
                        <div class="absolute inset-0 bg-black/40"></div>
                    </div>
                </div>

                <!-- Pagination & Navigation -->
                <div class="swiper-pagination z-20"></div>
            </div>

            <!-- Konten Teks -->
            <div id="heroContent"
                class="absolute inset-0 z-30 flex flex-col justify-center items-center text-center h-full px-6 py-10 opacity-0 transition-opacity duration-700 ">

                <h1 class="text-3xl font-extrabold mb-10 leading-tight" data-aos="fade-down" data-aos-delay="0">
                    <span class="block">Selamat Datang di</span>
                    <span class="block">E-Lapor DIY</span>
                </h1>

                <p class="text-base opacity-90 mb-4 max-w-md" data-aos="fade-down" data-aos-delay="200">
                    Layanan pengaduan masyarakat berbasis digital untuk wilayah Daerah Istimewa Yogyakarta.
                </p>

                <p class="text-lg font-semibold italic mb-6 text-white max-w-md" data-aos="fade-down" data-aos-delay="400">
                    Adukan sekarang, wujudkan DIY yang lebih baik!
                </p>

                <div class="flex flex-wrap justify-center gap-3" data-aos="fade-up" data-aos-delay="600">
                    <a href="#aduanCepatBox"
                        class="bg-transparent border border-white hover:bg-white/10 text-white px-5 py-2.5 rounded-lg font-bold shadow-lg transition">
                        Mulai Aduan
                    </a>
                    <a href="#lacakContent"
                        class="bg-transparent border border-white hover:bg-white/10 text-white px-5 py-2.5 rounded-lg font-bold shadow-lg transition">
                        Lacak Aduan
                    </a>
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-3 gap-4 mt-8 text-center" data-aos="fade-up" data-aos-delay="800">
                    <div>
                        <p class="text-xl font-bold text-[#FFD700]">20K+</p>
                        <span class="text-sm opacity-80">Aduan Diterima</span>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-[#FFD700]">95%</p>
                        <span class="text-sm opacity-80">Selesai Diproses</span>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-[#FFD700]">2 Hari</p>
                        <span class="text-sm opacity-80">Waktu Respon</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop View -->
        <div class="hidden lg:grid container mx-auto px-6 sm:px-10 lg:px-16 py-16 lg:grid-cols-2 gap-10 items-center">
            <!-- Left -->
            <div class="animate__animated animate__fadeInLeft text-left">
                <h1 class="text-5xl font-extrabold mb-6 leading-tight">
                    Selamat Datang di <span class="text-[#FFD700]">E-Lapor DIY</span>
                </h1>
                <p class="text-lg mb-10 opacity-90">
                    Layanan pengaduan masyarakat berbasis digital untuk wilayah Daerah Istimewa Yogyakarta. Laporkan aduan
                    Anda secara cepat, mudah, dan transparan.
                </p>
                <p class="text-xl font-semibold italic mb-8 text-yellow-200">
                    Laporkan sekarang, wujudkan DIY yang lebih baik!
                </p>
                <div class="flex gap-4">
                    <a href="#aduanCepatBox"
                        class="bg-transparent border border-white hover:bg-white/10 text-white px-6 py-3 rounded-lg font-bold shadow-lg transition">
                        Mulai Laporkan
                    </a>
                    <a href="#lacakContent"
                        class="bg-transparent border border-white hover:bg-white/10 text-white px-6 py-3 rounded-lg font-bold shadow-lg transition">
                        Lacak Status
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 mt-10 text-center">
                    <div>
                        <p class="text-2xl font-bold text-[#FFD700]">20K+</p>
                        <span class="text-sm opacity-80">Aduan Diterima</span>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#FFD700]">95%</p>
                        <span class="text-sm opacity-80">Selesai Diproses</span>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-[#FFD700]">2 Hari</p>
                        <span class="text-sm opacity-80">Waktu Respon</span>
                    </div>
                </div>
            </div>

            <!-- Right -->
            <div class="animate__animated animate__fadeInRight w-full max-w-lg">
                <div class="swiper mySwiper rounded-xl shadow-2xl overflow-hidden">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{ asset('images/carousel1.jpg') }}" class="w-full h-96 object-cover" alt="E-Lapor">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/carousel2.jpg') }}" class="w-full h-96 object-cover" alt="Pengaduan">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ asset('images/carousel3.jpg') }}" class="w-full h-96 object-cover"
                                alt="Layanan Publik">
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </div>

        <!-- Wave Divider -->
        <div class="absolute bottom-0 w-full overflow-hidden leading-[0] rotate-180 z-30">
            <svg class="relative block w-[calc(150%+1.3px)] h-[100px]" xmlns="http://www.w3.org/2000/svg"
                preserveAspectRatio="none" viewBox="0 0 1200 120">
                <path
                    d="M0,0V46.29c47.69,22,103.75,29.05,158,17.39C230.48,50.12,284,14.1,339.72,3.73c57.49-10.81,112.13,15.57,168,26.6C634,48.63,690,37.84,747.16,27.05c52.86-10.13,104.09-26.58,158-22.39,51.53,4,100.57,24.43,150.84,35.27,53.43,11.51,107.81,5.55,159-15.61V0Z"
                    opacity=".25" fill="#ffffff"></path>
                <path
                    d="M0,0V15.81C47.69,36.55,103.75,48.17,158,43.26c72.48-6.6,126-45.11,181.72-57.2C397.21-26.55,451.85-10.17,507.72,1C634,23.9,690,3.61,747.16-6.6c52.86-9.87,104.09-17.55,158-11.3,51.53,5.55,100.57,27.49,150.84,38.41C1109.43,32.8,1163.81,31.09,1215,15.81V0Z"
                    opacity=".5" fill="#ffffff"></path>
                <path
                    d="M0,0V5.63C47.69,22,103.75,35.69,158,33.06C230.48,29.28,284,1.13,339.72-2.71C397.21-6.65,451.85,7.62,507.72,16.59C634,36.53,690,15.89,747.16,6.64C800.02-2.37,851.25-5.9,905.16,2.15C956.69,9.5,1005.73,27.24,1056,34.46C1109.43,42.27,1163.81,39.81,1215,27.85V0Z"
                    fill="#ffffff"></path>
            </svg>
        </div>

    </section>

    <!-- Alur Layanan E-Lapor -->
    <section class="py-10 relative bg-white text-[#37474F] overflow-hidden">
        <!-- Layer Partikel -->
        <div id="particles-js" class="absolute inset-0 z-0"></div>

        <!-- Konten -->
        <div class="relative z-10 max-w-5xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16 text-gray-800">Alur Layanan E-Lapor</h2>

            <div class="relative border-l-2 border-dashed border-gray-300 ml-6 md:ml-10">
                @php
                    $steps = [
                        [
                            'icon' => 'fas fa-edit',
                            'title' => 'Tulis Aduan',
                            'desc' => 'Tulis aduan Anda dengan lengkap dan jelas melalui web atau aplikasi.',
                            'bg' => 'bg-red-500',
                            'border' => 'border-red-500',
                            'text' => 'text-red-500'
                        ],
                        [
                            'icon' => 'fas fa-share-alt',
                            'title' => 'Proses Delegasi',
                            'desc' => 'Aduan Anda akan otomatis terdelegasi ke instansi berwenang.',
                            'bg' => 'bg-orange-500',
                            'border' => 'border-orange-500',
                            'text' => 'text-orange-500'
                        ],
                        [
                            'icon' => 'fas fa-gavel',
                            'title' => 'Proses Tindak Lanjut',
                            'desc' => 'Instansi akan menindaklanjuti dan membalas aduan Anda dengan cepat.',
                            'bg' => 'bg-purple-600',
                            'border' => 'border-purple-600',
                            'text' => 'text-purple-600'
                        ],
                        [
                            'icon' => 'fas fa-comments',
                            'title' => 'Tanggapan Balik',
                            'desc' => 'Anda dapat menanggapi kembali balasan dari instansi berwenang.',
                            'bg' => 'bg-yellow-500',
                            'border' => 'border-yellow-500',
                            'text' => 'text-yellow-500'
                        ],
                        [
                            'icon' => 'fas fa-check-circle',
                            'title' => 'Selesai',
                            'desc' => 'Jika tindak lanjut selesai, maka instansi akan menutup aduan Anda.',
                            'bg' => 'bg-green-600',
                            'border' => 'border-green-600',
                            'text' => 'text-green-600'
                        ]
                    ];
                @endphp

                @foreach ($steps as $index => $step)
                    <div class="relative mb-16 flex items-start gap-6 md:gap-10" data-aos="fade-up"
                        data-aos-delay="{{ $index * 100 }}">
                        <!-- Dot Number -->
                        <div
                            class="flex-shrink-0 w-10 h-10 {{ $step['bg'] }} text-white rounded-full flex items-center justify-center text-sm font-bold z-20 shadow-lg">
                            {{ $index + 1 }}
                        </div>

                        <!-- Card Box -->
                        <div
                            class="bg-white {{ $step['border'] }} border-l-4 shadow-xl rounded-xl p-6 flex-1 @if ($index % 2 !== 0) ml-auto text-right @endif">
                            <div class="text-3xl {{ $step['text'] }} mb-3">
                                <i class="{{ $step['icon'] }}"></i>
                            </div>
                            <h3 class="text-xl font-semibold mb-2 text-gray-800">{{ $step['title'] }}</h3>
                            <p class="text-gray-600 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Form Aduan Cepat dengan Overlay -->
    <div id="aduanCepatBox"
        class="relative bg-gradient-to-br from-[#1e3a8a]/95 to-[#2563eb]/90 shadow-lg backdrop-blur-md px-5 py-6 w-full max-w-md mx-auto animate__animated animate__fadeInUp overflow-hidden">

        <!-- Overlay Gelap 30% -->
        <div class="absolute inset-0 bg-black/30 rounded-2xl z-0"></div>

        <!-- Konten Form -->
        <div class="relative z-10">
            <h2 class="text-2xl font-semibold text-white mb-6 text-center pb-2"
                style="font-family:'Open Sans','Segoe UI',sans-serif;">
                Aduan Cepat
            </h2>

            {{-- Overlay jika belum login --}}
            @guest
                <div id="form-overlay"
                    class="absolute inset-0 z-10 bg-white bg-opacity-80 flex items-center justify-center rounded-2xl animate__animated animate__fadeIn hidden">
                    <div class="text-red-700 text-center font-semibold animate__animated animate__fadeIn px-4">
                        <i class="fas fa-exclamation-triangle text-3xl mb-2"></i><br>
                        Untuk dapat mengisi formulir <strong>Aduan Cepat</strong>, silakan terlebih dahulu melakukan
                        <a href="{{ route('login') }}"
                            class="text-blue-800 underline hover:text-blue-900 font-semibold">Login</a>
                        ke akun Anda.
                    </div>
                </div>
            @endguest

            <form method="POST" action="{{ route('user.aduan.store') }}" enctype="multipart/form-data"
                class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf

                <!-- Kolom Kiri -->
                <div class="space-y-4">
                    <!-- Input Judul -->
                    <div class="flex flex-col leading-none">
                        <input type="text" name="judul" id="judulInput" maxlength="150" placeholder="Judul Aduan"
                            class="w-full border rounded-lg px-4 pt-2 pb-2 bg-white/80 text-gray-900 placeholder-gray-500 @error('judul') border-red-500 @enderror"
                            required>
                        <span id="judulCounter" class="text-sm text-white/90 mt-2">0/150</span>
                    </div>
                    @error('judul')
                        <div class="text-white text-sm mt-0">{{ $message }}</div>
                    @enderror
                    <!-- Textarea Isi -->
                    <div class="flex flex-col leading-none">
                        <textarea name="isi" id="isiInput" placeholder="Aduan Anda" rows="2" maxlength="1000"
                            class="w-full border rounded-lg px-4 pt-2 pb-1 bg-white/80 text-gray-900 placeholder-gray-500 @error('isi') border-red-500 @enderror"
                            required></textarea>
                        <span id="isiCounter" class="text-sm text-white/90 mt-2">0/1000</span>
                    </div>
                    @error('isi')
                        <div class="text-white text-sm mt-0">{{ $message }}</div>
                    @enderror
                    <!-- Dropdown Wilayah -->
                    <select name="wilayah_id"
                        class="w-full border rounded-lg px-4 py-2 bg-white/80 text-gray-900 @error('wilayah_id') border-red-500 @enderror"
                        required>
                        <option value="">- Pilih Wilayah -</option>
                        @forelse(App\Models\WilayahUmum::all() as $wilayah)
                            <option value="{{ $wilayah->id }}">{{ $wilayah->nama }}</option>
                        @empty
                            <option value="" disabled>Tidak ada wilayah tersedia</option>
                        @endforelse
                    </select>
                    @error('wilayah_id')
                        <div class="text-white text-sm mt-1">{{ $message }}</div>
                    @enderror

                    <div class="flex gap-2">
                        <!-- Dropdown Kategori -->
                        <select id="kategoriSelect" name="kategori_id"
                            class="w-full border rounded-lg px-4 py-2 bg-white/80 text-gray-900 @error('kategori_id') border-red-500 @enderror"
                            required>
                            <option value="">- Pilih Kategori -</option>
                            @forelse(App\Models\KategoriUmum::all() as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @empty
                                <option value="" disabled>Tidak ada kategori tersedia</option>
                            @endforelse
                        </select>
                        @error('kategori_id')
                            <div class="text-white text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <!-- Tombol Trigger -->
                        <div>
                            <label id="openFileModalBtn"
                                class="bg-transparent border border-white hover:bg-white/10 text-white px-5 py-4 rounded-lg font-bold shadow-lg transition cursor-pointer flex items-center">
                                <i class="fas fa-image mr-2"></i> File
                            </label>
                        </div>

                        <!-- Modal File -->
                        <div id="fileModal"
                            class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                            <div class="bg-white rounded-lg w-full max-w-xl p-6 shadow-lg relative">
                                <h2 class="text-lg font-semibold mb-3 text-gray-800">Lampirkan File</h2>

                                <!-- Keterangan -->
                                <p class="text-sm mb-2 text-gray-600 leading-relaxed">
                                    Jenis file yang dapat dilampirkan: <strong>.jpg</strong>,
                                    <strong>.jpeg</strong>,
                                    <strong>.png</strong>,
                                    <strong>.pdf</strong>, <strong>.doc</strong>, <strong>.docx</strong>,
                                    <strong>.xls</strong>, <strong>.xlsx</strong>, <strong>.zip</strong>.<br>
                                    Maksimal <strong>3 file</strong>, masing-masing <strong>tidak melebihi 10MB
                                        (10.240KB)</strong>.
                                </p>

                                <!-- Daftar Input -->
                                <div id="fileInputs" class="space-y-2 mb-4">
                                </div>

                                <!-- Hidden File Inputs (dipindahkan dari modal saat tekan OK) -->
                                <div id="fileInputHiddenContainer" class="hidden"></div>

                                <!-- Tombol Tambah -->
                                <button type="button" id="addFileBtn"
                                    class="bg-purple-700 hover:bg-purple-800 text-white px-4 py-2 rounded w-full mb-4 text-sm font-semibold transition">
                                    + Tambah file
                                </button>

                                <!-- Tombol Aksi -->
                                <div class="flex justify-end space-x-2">
                                    <button onclick="closeFileModal()" type="button"
                                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded transition">
                                        Batal
                                    </button>
                                    <button type="button" id="confirmFileBtn"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">
                                        Ok
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Konfirmasi Hapus -->
                        <div id="deleteConfirmModal"
                            class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
                            <div class="bg-white rounded-lg p-6 w-96 text-center shadow-lg">
                                <p class="text-lg mb-4 text-gray-800">Yakin ingin menghapus file ini?</p>
                                <div class="flex justify-center space-x-4">
                                    <button id="confirmDeleteBtn"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded transition">
                                        Hapus
                                    </button>
                                    <button onclick="closeDeleteModal()"
                                        class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded transition">
                                        Batal
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label onclick="openLocationModal()"
                                class="bg-transparent border border-white hover:bg-white/10 text-white px-5 py-4 rounded-lg font-bold shadow-lg transition cursor-pointer flex items-center">
                                <i class="fas fa-map-marker-alt mr-2"></i> Lokasi
                            </label>
                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="lokasi" id="lokasiInput">
                        <input type="hidden" name="latitude" id="latitudeInput">
                        <input type="hidden" name="longitude" id="longitudeInput">
                    </div>
                </div>

                <!-- Modal Lokasi -->
                <div id="locationModal"
                    class="fixed inset-0 z-50 bg-black/60 flex items-center justify-center transition-opacity duration-300 ease-in-out hidden">
                    <div
                        class="bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] rounded-2xl shadow-2xl w-full max-w-2xl p-6 relative animate-fade-in border border-red-900/40">

                        <!-- Header -->
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-2xl font-semibold text-white flex items-center gap-2">
                                <i class="fas fa-map-marker-alt text-white/90"></i> Pilih Lokasi Terkait
                            </h2>
                            <!-- Tombol Reset -->
                            <button onclick="resetMapToDefault()" class="text-white/90 hover:text-white transition"
                                title="Reset lokasi">
                                <i class="fas fa-sync-alt text-lg"></i>
                            </button>
                        </div>

                        <!-- Alamat -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-white mb-1">Alamat</label>
                            <input type="text" id="alamatField"
                                class="w-full border border-white/20 rounded-lg px-4 py-2 bg-white text-[#8B1E1E] font-semibold focus:outline-none focus:ring-2 focus:ring-white/40"
                                readonly>
                        </div>

                        <!-- Koordinat -->
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-sm font-medium text-white mb-1">Lintang</label>
                                <input type="text" id="latitudeField"
                                    class="w-full border border-white/20 rounded-lg px-4 py-2 bg-white text-[#8B1E1E] font-semibold focus:outline-none focus:ring-2 focus:ring-white/40"
                                    readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-white mb-1">Bujur</label>
                                <input type="text" id="longitudeField"
                                    class="w-full border border-white/20 rounded-lg px-4 py-2 bg-white text-[#8B1E1E] font-semibold focus:outline-none focus:ring-2 focus:ring-white/40"
                                    readonly>
                            </div>
                        </div>

                        <!-- Petunjuk -->
                        <div class="text-white/90 text-sm mb-3 flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Klik pada peta untuk memilih lokasi.
                        </div>

                        <!-- Peta -->
                        <div id="map"
                            class="w-full h-64 rounded-lg border border-white/30 shadow-inner mb-6 overflow-hidden">
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="flex justify-end gap-3">
                            <button onclick="closeLocationModal()"
                                class="px-4 py-2 bg-white text-[#8B1E1E] font-semibold rounded-lg hover:bg-gray-100 transition duration-150">
                                Batal
                            </button>
                            <button onclick="saveLocation()"
                                class="px-4 py-2 bg-white text-[#8B1E1E] font-semibold rounded-lg hover:bg-gray-100 transition duration-150">
                                Simpan Lokasi
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-4">
                    <label class="flex items-center space-x-2 text-white">
                        <input type="checkbox" name="is_anonim" id="anonimCheckbox" class="form-checkbox" value="1">
                        <span class="text-sm">Anonim</span>
                    </label>

                    <div class="identitas-group space-y-4">
                        <input type="text" name="nama_pengadu" placeholder="Nama Anda" value="{{ $user?->name }}"
                            class="w-full border rounded-lg px-4 py-2 bg-white/80 text-gray-900" readonly>
                        <input type="email" name="email_pengadu" placeholder="Alamat email Anda" value="{{ $user?->email }}"
                            class="w-full border rounded-lg px-4 py-2 bg-white/80 text-gray-900" readonly>
                        <input type="text" name="telepon_pengadu" placeholder="Nomor telepon"
                            value="{{ $user?->nomor_telepon }}"
                            class="w-full border rounded-lg px-4 py-2 bg-white/80 text-gray-900" readonly>
                        <input type="text" name="nik" placeholder="NIK" value="{{ $user?->nik }}"
                            class="w-full border rounded-lg px-4 py-2 bg-white/80 text-gray-900" readonly>
                    </div>

                    <label class="text-sm text-white mt-4 block">
                        <input type="checkbox" required>
                        Dengan mengisi form ini Anda menyetujui
                        <a href="#" class="text-blue-200 underline hover:text-white">Ketentuan Layanan</a> dan
                        <a href="#" class="text-blue-200 underline hover:text-white">Kebijakan Privasi</a>.
                    </label>

                    <button type="submit"
                        class="w-full bg-transparent border border-white hover:bg-white/10 text-white py-4 rounded-lg font-bold text-lg shadow-lg transition">
                        Adukan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Lacak Aduanmu -->
    <div id="lacakContent" class="container mx-auto text-center px-4 mt-14">
        <div class="w-full max-w-4xl mx-auto text-center">
            <h2 class="text-2xl md:text-3xl font-extrabold text-black mb-6">
                Lacak Aduanmu 
            </h2>

            <form action="{{ route('report.lacak') }}" method="POST"
                class="flex flex-col md:flex-row justify-center items-center gap-4">
                @csrf
                <input type="text" name="tracking_id" placeholder="Nomor Tiket Aduan" class="w-full md:flex-1 px-6 py-3 border border-blue-800 bg-white/90 rounded-full shadow 
                        focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 
                        text-base text-center font-semibold tracking-wider transition duration-300" required>

                <button type="submit" class="bg-gradient-to-br from-[#0D47A1] to-[#1976D2] hover:from-[#1565C0] hover:to-[#1E88E5] 
                        text-white font-bold px-8 py-3 rounded-full mt-4
                        uppercase tracking-wide shadow transition-all duration-200">
                    Lacak
                </button>
            </form>
        </div>
    </div>

    @php
        use Illuminate\Support\Facades\Auth;

        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            // Ambil ID kategori yang ditugaskan ke admin
            $kategoriIds = $user->kategori->pluck('id')->toArray();

            // Ambil hanya laporan sesuai kategori admin
            $reports = \App\Models\Report::whereIn('kategori_id', $kategoriIds)
                ->latest()
                ->take(9)
                ->get();
        } elseif ($user && $user->role === 'superadmin') {
            // Superadmin bisa melihat semua
            $reports = \App\Models\Report::latest()
                ->take(9)
                ->get();
        } else {
            // Pengguna biasa atau belum login
            $reports = \App\Models\Report::latest()
                ->take(9)
                ->get();
        }
    @endphp

    <!-- Aduan Terbaru -->
    <div
        class="relative bg-white border shadow-md rounded-lg p-8 w-full max-w-7xl mx-auto mt-16 animate__animated animate__fadeInUp">
        <h2 class="text-2xl font-extrabold text-gray-800 mb-6 text-center border-b pb-2">Aduan Terbaru</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @forelse ($reports as $report)
                <div
                    class="bg-white border-2 border-gray-300 p-4 shadow-lg rounded-lg hover:shadow-xl transition duration-300 w-full mx-auto">
                    <h3 class="font-semibold text-lg text-gray-800 text-left truncate">
                        <a href="{{ route('reports.show', ['id' => $report->id]) }}" class="hover:text-blue-600 transition-all">
                            {{ Str::limit($report->judul, 27) }}
                        </a>
                    </h3>

                    <p class="text-sm text-gray-600 mt-2 text-left line-clamp-2">
                        <a href="{{ route('reports.show', ['id' => $report->id]) }}" class="hover:text-blue-600 transition-all">
                            {{ Str::limit($report->isi, 100) }}
                        </a>
                    </p>

                    <div class="mt-4 space-y-2 text-xs text-gray-500">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-user text-blue-500"></i>
                            <span class="font-semibold">{{ $report->is_anonim ? 'Anonim' : $report->nama_pengadu }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="fas fa-clock text-gray-500"></i>
                            <span>
                                Dikirim pada:
                                {{ $report->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}
                                WIB
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="fas fa-list-alt text-green-500"></i>
                            <span>{{ $report->kategori->nama }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <i class="fas fa-tasks text-yellow-500"></i>
                            <span class="font-semibold">Status:</span>
                            <span
                                class="rounded-full px-2 py-1 font-semibold text-xs
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @if($report->status === 'Diajukan')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        bg-blue-200 text-blue-800
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @elseif($report->status === 'Dibaca')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        bg-teal-200 text-teal-800
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @elseif($report->status === 'Direspon')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        bg-yellow-200 text-yellow-800
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @elseif($report->status === 'Selesai')
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        bg-green-200 text-green-800
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @else
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        bg-gray-200 text-gray-700
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    @endif">
                                {{ $report->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center text-sm text-gray-600 bg-blue-100 border border-blue-300 rounded p-4">
                    Tidak ada aduan terbaru saat ini.
                </div>
            @endforelse
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
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

        // ==== GLOBAL LOKASI & PETA ====
        let map, marker;

        function openLocationModal() {
            const modal = document.getElementById('locationModal');
            const content = modal.querySelector('div');

            modal.classList.remove('hidden');
            content.classList.remove('modal-animate-out');
            content.classList.add('modal-animate-in');

            if (!map) {
                map = L.map('map').setView([-7.797068, 110.370529], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                map.on('click', function (e) {
                    const { lat, lng } = e.latlng;

                    if (marker) {
                        marker.setLatLng(e.latlng);
                    } else {
                        marker = L.marker(e.latlng).addTo(map);
                    }

                    document.getElementById('latitudeField').value = lat.toFixed(6);
                    document.getElementById('longitudeField').value = lng.toFixed(6);

                    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                        .then(res => res.json())
                        .then(data => {
                            document.getElementById('alamatField').value = data.display_name;
                        })
                        .catch(err => console.error('Geocoding error:', err));
                });
            }
        }

        function closeLocationModal() {
            const modal = document.getElementById('locationModal');
            const content = modal.querySelector('div');

            content.classList.remove('modal-animate-in');
            content.classList.add('modal-animate-out');

            setTimeout(() => {
                modal.classList.add('hidden');
                content.classList.remove('modal-animate-out');
            }, 250);
        }

        function saveLocation() {
            const alamat = document.getElementById('alamatField').value;
            const lat = document.getElementById('latitudeField').value;
            const lng = document.getElementById('longitudeField').value;

            if (!alamat || !lat || !lng) {
                alert('Silakan klik lokasi di peta terlebih dahulu.');
                return;
            }

            document.getElementById('lokasiInput').value = alamat;
            document.getElementById('latitudeInput').value = lat;
            document.getElementById('longitudeInput').value = lng;
            closeLocationModal();
        }

        function resetMapToDefault() {
            const defaultLatLng = [-7.797068, 110.370529];
            map.setView(defaultLatLng, 13);

            if (marker) {
                map.removeLayer(marker);
                marker = null;
            }

            document.getElementById('latitudeField').value = '';
            document.getElementById('longitudeField').value = '';
            document.getElementById('alamatField').value = '';
        }

        document.addEventListener('DOMContentLoaded', function () {
            AOS.init();

            const swiper = new Swiper('.mySwiper', {
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
                observer: true, // ⬅️ penting agar swiper tetap responsif saat elemen jadi visible
                observeParents: true,
                on: {
                    init: () => {
                        const content = document.getElementById('heroContent');
                        const swiperEl = document.querySelector('.mySwiper');

                        // Perbaiki visibilitas swiper (gambar)
                        swiperEl.classList.remove('invisible');

                        // Perbaiki animasi konten teks
                        content.classList.remove('opacity-0');
                        content.classList.add('opacity-100');

                        AOS.refresh();
                    }
                }
            });

            // Inisialisasi variabel
            let maxFiles = 3;
            let fileToDelete = null;

            const addFileBtn = document.getElementById('addFileBtn');
            const fileInputsContainer = document.getElementById('fileInputs');
            const fileInputHiddenContainer = document.getElementById('fileInputHiddenContainer');
            const fileModal = document.getElementById('fileModal');
            const deleteConfirmModal = document.getElementById('deleteConfirmModal');
            const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
            const confirmFileBtn = document.getElementById('confirmFileBtn');
            const openFileModalBtn = document.getElementById('openFileModalBtn');
            const judulInput = document.getElementById('judulInput');
            const judulCounter = document.getElementById('judulCounter');
            const isiInput = document.getElementById('isiInput');
            const isiCounter = document.getElementById('isiCounter');

            judulInput.addEventListener('input', () => {
                judulCounter.textContent = `${judulInput.value.length}/150`;
            });

            isiInput.addEventListener('input', () => {
                isiCounter.textContent = `${isiInput.value.length}/1000`;
            });

            // Fungsi untuk update tombol tambah
            function updateAddFileButtonVisibility() {
                const currentInputs = fileInputsContainer.querySelectorAll('input[type="file"]');
                if (addFileBtn) {
                    if (currentInputs.length >= maxFiles) {
                        addFileBtn.classList.add('hidden');
                    } else {
                        addFileBtn.classList.remove('hidden');
                    }
                }
            }

            // Tombol tambah file
            if (addFileBtn) {
                addFileBtn.addEventListener('click', () => {
                    const currentInputs = fileInputsContainer.querySelectorAll('input[type="file"]');
                    if (currentInputs.length >= maxFiles) return;

                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-3 mb-2';
                    div.innerHTML = `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <input type="file" name="file[]" 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.zip"
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       class="file-input flex-1 border px-2 py-1 rounded text-sm">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <button type="button" class="deleteFileBtn text-red-600 hover:text-red-800 text-lg">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                </button>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            `;
                    fileInputsContainer.appendChild(div);
                    updateAddFileButtonVisibility();
                });
            }

            // Delegasi klik tombol hapus untuk tampilkan modal konfirmasi
            fileInputsContainer.addEventListener('click', function (e) {
                const deleteBtn = e.target.closest('.deleteFileBtn');
                if (deleteBtn) {
                    fileToDelete = deleteBtn.closest('.flex'); // ambil elemen container div input+button
                    if (fileToDelete && deleteConfirmModal) {
                        deleteConfirmModal.classList.remove('hidden');
                        deleteConfirmModal.classList.add('flex');
                    }
                }
            });

            // Konfirmasi hapus
            if (confirmDeleteBtn) {
                confirmDeleteBtn.addEventListener('click', () => {
                    if (fileToDelete) {
                        fileToDelete.remove();
                        fileToDelete = null;
                        updateAddFileButtonVisibility(); // <-- Tambahkan ini
                    }
                    closeDeleteModal();
                });
            }

            // Saat tekan tombol OK / Konfirmasi
            if (confirmFileBtn) {
                confirmFileBtn.addEventListener('click', () => {
                    const inputs = fileInputsContainer.querySelectorAll('input[type="file"]');
                    let validFiles = 0;

                    inputs.forEach(input => {
                        if (input.files.length > 0) validFiles++;
                    });

                    if (validFiles > maxFiles) {
                        alert('Maksimal 3 file!');
                        return;
                    }

                    // Pindahkan input yang valid ke container hidden
                    fileInputHiddenContainer.innerHTML = '';
                    inputs.forEach(input => {
                        if (input.files.length > 0) {
                            fileInputHiddenContainer.appendChild(input); // pindahkan
                        }
                    });

                    fileInputsContainer.innerHTML = ''; // kosongkan modal
                    fileModal.classList.remove('flex');
                    fileModal.classList.add('hidden');
                    addFileBtn.classList.remove('hidden'); // reset tombol tambah
                });
            }

            // Saat buka modal, pindahkan kembali input dari hidden ke modal
            if (openFileModalBtn && fileModal) {
                openFileModalBtn.addEventListener('click', () => {
                    fileModal.classList.remove('hidden');
                    fileModal.classList.add('flex');

                    const hiddenInputs = fileInputHiddenContainer.querySelectorAll('input[type="file"]');
                    hiddenInputs.forEach(input => {
                        fileInputsContainer.appendChild(input); // kembalikan ke modal
                    });
                    fileInputHiddenContainer.innerHTML = '';

                    updateAddFileButtonVisibility(); // tampilkan/hide tombol tambah sesuai
                });
            }

            // Anonimitas toggle
            const anonimCheckbox = document.getElementById('anonimCheckbox');
            const identitasGroup = document.querySelector('.identitas-group');
            if (anonimCheckbox && identitasGroup) {
                anonimCheckbox.addEventListener('change', function () {
                    identitasGroup.style.display = this.checked ? 'none' : 'block';
                });
            }

            // Overlay login
            const formContainer = document.getElementById('aduanCepatBox');
            const overlay = document.getElementById('form-overlay');
            if (overlay && formContainer) {
                formContainer.addEventListener('mouseenter', () => overlay.classList.remove('hidden'));
                formContainer.addEventListener('mouseleave', () => overlay.classList.add('hidden'));

                const form = formContainer.querySelector('form');
                form?.addEventListener('submit', e => e.preventDefault());
            }

            // Spinner ke checklist
            const spinner = document.getElementById('success-spinner');
            const check = document.getElementById('success-check');
            setTimeout(() => {
                if (spinner && check) {
                    spinner.classList.add('hidden');
                    check.classList.remove('hidden');
                    check.classList.add('scale-100');
                }
            }, 1000);

            // Auto fade alert
            const fadeOutAndRemove = el => {
                if (!el) return;
                el.classList.remove('opacity-100');
                el.classList.add('opacity-0');
                setTimeout(() => el.style.display = 'none', 500);
            };

            setTimeout(() => {
                fadeOutAndRemove(document.getElementById('alert-success'));
                fadeOutAndRemove(document.getElementById('alert-error'));
            }, 3000);

            new TomSelect('#kategoriSelect', {
                placeholder: '- Pilih Kategori -',
                allowEmptyOption: true,
                create: false,
                sortField: {
                    field: 'text',
                    direction: 'asc'
                }
            });
        });

        // Fungsi tutup modal
        function closeFileModal() {
            const fileModal = document.getElementById('fileModal');
            const fileInputsContainer = document.getElementById('fileInputs');

            if (fileModal) {
                fileModal.classList.remove('flex');
                fileModal.classList.add('hidden');
            }

            // Reset input file (hapus semuanya)
            if (fileInputsContainer) {
                fileInputsContainer.innerHTML = '';
            }
        }

        function closeDeleteModal() {
            deleteConfirmModal.classList.add('hidden');
            deleteCon
            firmModal.classList.remove('flex');
        }

        const swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: { delay: 3000 },
            pagination: { el: ".swiper-pagination", clickable: true },
        });
    </script>
@endpush