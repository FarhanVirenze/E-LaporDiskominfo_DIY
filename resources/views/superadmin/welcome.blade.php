@extends('superadmin.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet" />
@endsection

@section('content')
    @php
        $user = Auth::user();
    @endphp
    <!-- Notifikasi Merah -->
    @if (session('success'))
        <div id="alert-success" class="fixed top-5 right-5 z-50 flex items-center justify-between gap-4 
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
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <!-- Pesan -->
            <span class="flex-1 font-medium tracking-wide">{{ session('success') }}</span>

            <!-- Tombol Close -->
            <button onclick="document.getElementById('alert-success').remove()"
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
            // Ganti spinner jadi centang dengan animasi pop
            setTimeout(() => {
                document.getElementById('success-spinner').classList.add('hidden');
                const check = document.getElementById('success-check');
                check.classList.remove('hidden');
                check.classList.add('animate-pop');
            }, 800);

            // Auto hide notif setelah 3.5 detik
            setTimeout(() => {
                const alert = document.getElementById('alert-success');
                if (alert) {
                    alert.classList.add('opacity-0', 'translate-y-2');
                    setTimeout(() => alert.remove(), 500);
                }
            }, 3500);
        </script>
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
                    <!-- Slide 1 -->
                    <div class="swiper-slide relative">
                        <!-- Overlay biru gradient (z-0 - paling bawah) -->
                        <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>

                        <!-- Gambar (z-10 - di atas gradient tapi di bawah overlay hitam) -->
                        <img src="{{ asset('images/carousel2.jpg') }}"
                            class="absolute inset-0 w-full h-full object-cover z-10 will-change-transform backface-hidden"
                            loading="eager" alt="E-Lapor">

                        <!-- Overlay hitam (z-20 - paling atas) -->
                        <div class="absolute inset-0 bg-black/50 z-20"></div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>

                        <img src="{{ asset('images/carousel4.jpg') }}"
                            class="absolute inset-0 w-full h-full object-cover z-10 will-change-transform backface-hidden"
                            loading="eager" alt="Pengaduan">

                        <div class="absolute inset-0 bg-black/50 z-20"></div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>

                        <img src="{{ asset('images/carousel3.jpg') }}"
                            class="absolute inset-0 w-full h-full object-cover z-10 will-change-transform backface-hidden"
                            loading="eager" alt="Layanan Publik">

                        <div class="absolute inset-0 bg-black/50 z-20"></div>
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
                <div class="grid grid-cols-3 gap-6 mt-8 text-center" data-aos="fade-up" data-aos-delay="800">
                    <!-- Total Aduan -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-file-alt text-3xl text-rose-500 mb-2"></i>
                        <p class="text-xl font-bold text-white">
                            {{ \App\Models\Report::count() }}
                        </p>
                        <span class="text-sm opacity-80">Total Aduan</span>
                    </div>

                    <!-- Aduan Bulan Ini -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-calendar-alt text-3xl text-rose-500 mb-2"></i>
                        <p class="text-xl font-bold text-white">
                            {{ \App\Models\Report::whereMonth('created_at', \Carbon\Carbon::now()->month)
        ->whereYear('created_at', \Carbon\Carbon::now()->year)
        ->count() }}
                        </p>
                        <span class="text-sm opacity-80">Aduan Bulan Ini</span>
                    </div>

                    <!-- Aduan Selesai -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-check-circle text-3xl text-rose-500 mb-2"></i>
                        <p class="text-xl font-bold text-white">
                            {{ \App\Models\Report::where('status', \App\Models\Report::STATUS_SELESAI)->count() }}
                        </p>
                        <span class="text-sm opacity-80">Aduan Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop View -->
        <div class="hidden lg:block relative h-[110vh] overflow-hidden">
            <!-- Background Swiper (Full) -->
            <div class="absolute inset-0 z-10">
                <div class="swiper mySwiper w-full h-full">
                    <div class="swiper-wrapper">
                        <!-- Slide 1 -->
                        <div class="swiper-slide relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>
                            <img src="{{ asset('images/carousel2.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover z-10" alt="E-Lapor">
                            <div class="absolute inset-0 bg-black/50 z-20"></div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="swiper-slide relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>
                            <img src="{{ asset('images/carousel4.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover z-10" alt="Pengaduan">
                            <div class="absolute inset-0 bg-black/50 z-20"></div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="swiper-slide relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>
                            <img src="{{ asset('images/carousel3.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover z-10" alt="Layanan Publik">
                            <div class="absolute inset-0 bg-black/50 z-20"></div>
                        </div>
                    </div>

                    <!-- Pagination harus di luar swiper-wrapper -->
                    <div class="swiper-pagination z-20"></div>
                </div>
            </div>

            <!-- Konten -->
            <div
                class="relative z-30 container mx-auto px-6 sm:px-10 lg:px-16 h-full flex flex-col items-center justify-center text-center text-white animate__animated animate__fadeIn">

                <h1 class="text-5xl font-extrabold mb-6 leading-tight">
                    Selamat Datang di <span class="text-white">E-Lapor DIY</span>
                </h1>

                <p class="text-lg max-w-3xl mb-6 opacity-90">
                    Layanan pengaduan masyarakat berbasis digital untuk wilayah Daerah Istimewa Yogyakarta.
                </p>

                <p class="text-xl font-semibold italic mb-8 text-white">
                    Laporkan sekarang, wujudkan DIY yang lebih baik!
                </p>

                <div class="flex flex-wrap gap-4 justify-center">
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
                <div class="grid grid-cols-3 gap-6 mt-8 text-center" data-aos="fade-up" data-aos-delay="800">
                    <!-- Total Aduan -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-file-alt text-3xl text-rose-500 mb-2"></i>
                        <p class="text-xl font-bold text-white">
                            {{ \App\Models\Report::count() }}
                        </p>
                        <span class="text-sm opacity-80">Total Aduan</span>
                    </div>

                    <!-- Aduan Bulan Ini -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-calendar-alt text-3xl text-rose-500 mb-2"></i>
                        <p class="text-xl font-bold text-white">
                            {{ \App\Models\Report::whereMonth('created_at', \Carbon\Carbon::now()->month)
        ->whereYear('created_at', \Carbon\Carbon::now()->year)
        ->count() }}
                        </p>
                        <span class="text-sm opacity-80">Aduan Bulan Ini</span>
                    </div>

                    <!-- Aduan Selesai -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-check-circle text-3xl text-rose-500 mb-2"></i>
                        <p class="text-xl font-bold text-white">
                            {{ \App\Models\Report::where('status', \App\Models\Report::STATUS_SELESAI)->count() }}
                        </p>
                        <span class="text-sm opacity-80">Aduan Selesai</span>
                    </div>
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

    <!-- Alur Layanan -->
    <section class="py-14 pb-10 relative bg-white text-[#37474F] overflow-hidden">
        <!-- Layer Partikel -->
        <div id="particles-js" class="absolute inset-0 z-0"></div>

        <!-- Konten -->
        <div class="relative z-10 max-w-[70rem] 2xl:max-w-[93rem] mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-16 text-gray-800" data-aos="fade-up">Alur Layanan</h2>
            @php
                $steps = [
                    ['icon' => 'fas fa-edit', 'title' => 'Tulis Aduan', 'desc' => 'Tulis aduan Anda dengan lengkap dan jelas.', 'bg' => 'bg-red-500', 'border' => 'border-red-500', 'text' => 'text-red-500'],
                    ['icon' => 'fas fa-share-square', 'title' => 'Proses Delegasi', 'desc' => 'Aduan Anda akan otomatis terdelegasi ke instansi berwenang.', 'bg' => 'bg-orange-500', 'border' => 'border-orange-500', 'text' => 'text-orange-500'],
                    ['icon' => 'fas fa-eye', 'title' => 'Proses Dibaca', 'desc' => 'Instansi akan membaca aduan Anda dengan cepat.', 'bg' => 'bg-blue-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500'],
                    ['icon' => 'fas fa-tasks', 'title' => 'Proses Tindak Lanjut', 'desc' => 'Instansi akan menindaklanjuti aduan Anda dengan cepat.', 'bg' => 'bg-purple-600', 'border' => 'border-purple-600', 'text' => 'text-purple-600'],
                    ['icon' => 'fas fa-comments', 'title' => 'Tanggapan Balik', 'desc' => 'Anda dapat menanggapi kembali balasan dari instansi berwenang.', 'bg' => 'bg-yellow-500', 'border' => 'border-yellow-500', 'text' => 'text-yellow-500'],
                    ['icon' => 'fas fa-check-circle', 'title' => 'Selesai', 'desc' => 'Jika tindak lanjut selesai, maka instansi akan menutup aduan.', 'bg' => 'bg-green-600', 'border' => 'border-green-600', 'text' => 'text-green-600']
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 relative" data-aos="fade-up" data-aos-delay="50"
                data-aos-duration="800">

                <!-- Garis putus-putus untuk mobile (nyambung semua nomor) -->
                <div class="absolute left-6 top-6 bottom-0 w-0.5 md:hidden"
                    style="background: repeating-linear-gradient(to bottom, rgba(239,68,68,0.7), rgba(239,68,68,0.7) 8px, transparent 8px, transparent 16px);">
                </div>

                @foreach ($steps as $index => $step)
                    @php
                        $aosType = 'fade-up';
                        $aosTypeDesktop = $index % 2 === 0 ? 'fade-right' : 'fade-left';
                    @endphp

                    <div class="group flex items-start gap-6 relative z-10" data-aos="{{ $aosType }}"
                        data-aos-md="{{ $aosTypeDesktop }}" data-aos-delay="{{ 100 + ($index * 100) }}">

                        <!-- Nomor -->
                        <div
                            class="flex-shrink-0 w-12 h-12 {{ $step['bg'] }} text-white rounded-full flex items-center justify-center text-lg font-bold shadow-lg">
                            {{ $index + 1 }}
                        </div>

                        <!-- Card -->
                        <div
                            class="bg-gradient-to-br from-red-50 to-red-100 {{ $step['border'] }} border-l-4 shadow-2xl rounded-xl p-6 flex-1 text-left transition-all duration-300 hover:shadow-3xl hover:-translate-y-1">
                            <div class="text-3xl {{ $step['text'] }} mb-3">
                                <i class="{{ $step['icon'] }}"></i>
                            </div>
                            <h3 class="text-lg font-semibold mb-2 text-black">{{ $step['title'] }}</h3>
                            <p class="text-gray-800 text-sm leading-relaxed">{{ $step['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

        <script>
            // Custom attribute untuk ganti AOS animation di breakpoint md ke atas
            document.addEventListener("DOMContentLoaded", function () {
                if (window.innerWidth >= 768) {
                    document.querySelectorAll("[data-aos-md]").forEach(el => {
                        el.setAttribute("data-aos", el.getAttribute("data-aos-md"));
                    });
                }
            });
        </script>

        <!-- Aduan Cepat -->
        <div id="aduanCepatBox"
            class="group relative bg-gradient-to-br from-[#1e3a8a]/95 to-[#2563eb]/90 shadow-lg backdrop-blur-md
                                                                                    px-5 py-6 mt-14 w-full md:max-w-[67rem] 2xl:max-w-[90rem] mx-auto rounded-none md:rounded-2xl overflow-hidden z-30"
            data-aos="fade-up">

            <!-- Background -->
            <div class="absolute inset-0 bg-cover bg-center z-0" style="background-image: url('/images/red.jpg');"></div>
            <div class="absolute inset-0 bg-black/10 z-20"></div>

            <!-- Konten -->
            <div class="relative z-30">
                <h2 class="text-2xl md:text-3xl font-semibold text-white mb-6 text-center pb-2"
                    style="font-family:'Open Sans','Segoe UI',sans-serif;">
                    Aduan Cepat
                </h2>
                {{-- Overlay jika belum login --}}
                @guest
                    <div id="form-overlay"
                        class="absolute inset-0 z-10 bg-white bg-opacity-80  backdrop-blur-sm flex items-center justify-center rounded-2xl
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               opacity-0 scale-95 pointer-events-none transition-all duration-500 ease-out
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               group-hover:opacity-100 group-hover:scale-100 group-hover:pointer-events-auto">
                        <div
                            class="text-red-700 text-center font-semibold px-4 transform transition duration-500 ease-out translate-y-4 group-hover:translate-y-0">
                            <i class="fas fa-exclamation-triangle text-3xl mb-2 animate-pulse"></i><br>
                            Untuk dapat mengisi formulir <strong>Aduan Cepat</strong>, silakan terlebih dahulu melakukan
                            <a href="{{ route('login') }}"
                                class="text-blue-700 hover:text-blue-800 underline font-semibold">Login</a>
                            ke akun Anda.
                        </div>
                    </div>
                @endguest

                <form method="POST" action="{{ route('superadmin.aduan.store') }}" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10">
                    @csrf

                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <!-- Input Judul -->
                        <div class="flex flex-col leading-none">
                            <input type="text" name="judul" maxlength="150" placeholder="Judul Aduan Singkat Minimal (10 Kata)"
                                class="w-full border rounded-lg px-4 py-3 md:py-4 bg-white text-gray-900" required>
                            <span class="text-sm text-white/90 mt-2 block">0/150</span>
                        </div>
                        @error('judul')
                            <div class="text-white text-sm mt-0">{{ $message }}</div>
                        @enderror
                        <!-- Textarea Isi -->
                        <div class="flex flex-col leading-none">
                            <textarea name="isi" placeholder="Kronologi Lengkap Aduan Minimal (20 Kata)" rows="2" maxlength="1000"
                                class="w-full border rounded-lg px-4 py-3 md:py-4 bg-white text-gray-900"
                                required></textarea>
                            <span class="text-sm text-white/90 mt-2 block">0/1000</span>
                        </div>
                        @error('isi')
                            <div class="text-white text-sm mt-0">{{ $message }}</div>
                        @enderror

                        <!-- Dropdown Kategori -->
                        <select id="kategoriSelect" name="kategori_id"
                            class="flex-1 border rounded-lg px-4 py-3 bg-white text-gray-900 relative" required>
                            <option value="">- Pilih Kategori -</option>
                            @forelse(App\Models\KategoriUmum::where('tipe', 'non_wbs_admin')->get() as $kategori)
                                <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                            @empty
                                <option value="" disabled>Tidak ada kategori tersedia</option>
                            @endforelse

                        </select>
                        @error('kategori_id')
                            <div class="text-white text-sm mt-1">{{ $message }}</div>
                        @enderror

                        <div class="flex gap-2 relative overflow-visible">

                            <!-- Dropdown Wilayah -->
                            <select name="wilayah_id" class="w-full border rounded-lg px-4 py-3 bg-white text-gray-900"
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

                            <!-- Tombol Trigger -->
                            <div>
                                <label id="openFileModalBtn"
                                    class="bg-transparent border border-white hover:bg-white/10 text-white px-4 md:px-5 py-5 md:py-5 rounded-lg font-bold shadow-lg cursor-pointer flex items-center">
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
                                        <strong>.pdf</strong>, <strong>.doc</strong>, <strong>.docx</strong>.<br>
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
                                        class="bg-gradient-to-r from-red-600 to-rose-500 text-white px-4 py-2 rounded-full w-full mb-6 text-md font-semibold transition shadow-lg
                                                                                                                                                                                                                                                                                                                    hover:from-red-700 hover:to-rose-600">
                                        + Tambah file
                                    </button>

                                    <!-- Tombol Aksi -->
                                    <div class="flex justify-end mb-2 space-x-2">
                                        <button type="button" id="confirmFileBtn"
                                            class="bg-gradient-to-r from-blue-600 to-cyan-500 hover:from-blue-700 hover:to-cyan-600 text-white px-4 py-2 rounded-full transition">
                                            Simpan
                                        </button>

                                        <button onclick="closeFileModal()" type="button"
                                            class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-full transition">
                                            Batal
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
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full transition">
                                            Hapus
                                        </button>
                                        <button onclick="closeDeleteModal()"
                                            class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-full transition">
                                            Batal
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label onclick="openLocationModal()"
                                    class="bg-transparent border border-white hover:bg-white/10 text-white px-4 md:px-5 py-5 md:py-5 rounded-lg font-bold shadow-lg cursor-pointer flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2"></i> Lokasi
                                </label>
                            </div>

                            <!-- Hidden Inputs -->
                            <input type="hidden" name="lokasi" id="lokasiInput">
                            <input type="hidden" name="latitude" id="latitudeInput">
                            <input type="hidden" name="longitude" id="longitudeInput">
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
                                class="w-full border rounded-lg px-4 py-2 bg-white text-gray-900" readonly>
                            <input type="email" name="email_pengadu" placeholder="Alamat email Anda"
                                value="{{ $user?->email }}"
                                class="w-full border rounded-lg px-4 py-2 bg-white text-gray-900" readonly>
                            <input type="text" name="telepon_pengadu" placeholder="Nomor telepon"
                                value="{{ $user?->nomor_telepon }}"
                                class="w-full border rounded-lg px-4 py-2 bg-white text-gray-900" readonly>
                            <input type="text" name="nik" placeholder="NIK" value="{{ $user?->nik }}"
                                class="w-full border rounded-lg px-4 py-2 bg-white text-gray-900" readonly>
                        </div>

                        {{-- === reCAPTCHA di sini === --}}
                        <div class="mt-4">
                            {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::renderJs() !!}
                            {!! \Anhskohbo\NoCaptcha\Facades\NoCaptcha::display() !!}
                            @error('g-recaptcha-response')
                                <span class="text-red-500 text-sm mt-2 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <label class="text-sm text-white mt-4 block">
                            <input type="checkbox" required>
                            Dengan mengisi form ini dan mengirimkan Aduan, Anda telah menyetujui
                            <a href="#" class="text-blue-200 underline hover:text-white">Ketentuan Layanan</a> dan
                            <a href="#" class="text-blue-200 underline hover:text-white">Kebijakan Privasi</a> kami.
                        </label>

                        <button type="submit"
                            class="w-full bg-transparent border border-white hover:bg-white/10 text-white py-4 rounded-lg font-bold text-lg shadow-lg transition">
                            Adukan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Lokasi -->
        <div id="locationModal"
            class="fixed inset-0 z-50 flex items-center justify-center transition-opacity duration-300 ease-in-out hidden
                                                                                                                                                                                                                                                                                                bg-black/30">

            <!-- Background gambar full, posisi absolute di belakang -->
            <div class="absolute inset-0 bg-cover bg-center opacity-70" style="background-image: url('/images/red.jpg');">
            </div>

            <!-- Overlay gelap transparan -->
            <div class="absolute inset-0 bg-black/30 z-20"></div>

            <!-- Konten modal -->
            <div class="relative z-30 w-full max-w-2xl p-6 rounded-2xl border border-white/30 bg-white/10 shadow-lg">
                <!-- Header -->
                <div class="flex items-center justify-between mb-5">
                    <h2 class="text-2xl font-semibold text-white flex items-center gap-4">
                        <i class="fas fa-map-marker-alt text-white/90"></i>
                        <span>Pilih Lokasi Terkait</span>
                    </h2>
                    <button onclick="resetMapToDefault()" title="Reset lokasi"
                        class="text-white/90 hover:text-white transition">
                        <i class="fas fa-sync-alt text-lg"></i>
                    </button>
                </div>

                <!-- Input Pencarian Lokasi -->
                <div class="mb-4 relative">
                    <label for="searchLocation" class="block text-sm font-medium text-white mb-1">Cari
                        Alamat</label>
                    <input type="text" id="searchLocation" placeholder="Ketik alamat atau tempat..."
                        class="w-full bg-transparent border border-white/40 rounded-lg px-4 py-2 text-white font-semibold                                                                                                                                                                                                placeholder-white focus:outline-none focus:ring-2 focus:ring-white/70 hover:bg-white/10 transition" />

                    <ul id="searchSuggestions"
                        class="absolute z-50 bg-white text-gray-700 w-full mt-1 rounded-lg shadow-lg overflow-hidden hidden max-h-48 overflow-y-auto">
                    </ul>
                </div>

                <!-- Alamat -->
                <div class="mb-4">
                    <label for="alamatField" class="block text-sm font-medium text-white mb-1">Alamat</label>
                    <input type="text" id="alamatField" readonly
                        class="w-full bg-transparent border border-white/40 rounded-lg px-4 py-2 text-white font-semibold
                                                                                                                                                                                                                                                                                                                                                               focus:outline-none focus:ring-2 focus:ring-white/70" />
                </div>

                <!-- Koordinat -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="latitudeField" class="block text-sm font-medium text-white mb-1">Lintang</label>
                        <input type="text" id="latitudeField" readonly
                            class="w-full bg-transparent border border-white/40 rounded-lg px-4 py-2 text-white font-semibold                                                                                                                                                                                                            focus:outline-none focus:ring-2 focus:ring-white/70" />
                    </div>
                    <div>
                        <label for="longitudeField" class="block text-sm font-medium text-white mb-1">Bujur</label>
                        <input type="text" id="longitudeField" readonly
                            class="w-full bg-transparent border border-white/40 rounded-lg px-4 py-2 text-white font-semibold                                                                                                                                                                                                    focus:outline-none focus:ring-2 focus:ring-white/70" />
                    </div>
                </div>

                <!-- Petunjuk -->
                <div class="text-white/90 text-sm mb-3 flex items-center gap-2">
                    <i class="fas fa-info-circle"></i>
                    Klik pada peta untuk memilih lokasi.
                </div>

                <!-- Peta -->
                <div id="map" class="w-full h-64 rounded-lg border border-white/40 shadow-inner mb-6 overflow-hidden">
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-3">
                    <button onclick="saveLocation()"
                        class="px-4 py-2 rounded-full bg-gradient-to-r from-red-500 to-rose-500 text-white font-semibold shadow-lg hover:shadow-xl hover:from-red-700 hover:to-rose-600 transition duration-150">
                        Simpan Lokasi
                    </button>

                    <button onclick="closeLocationModal()"
                        class="px-4 py-2 rounded-full bg-white/10 border border-white/30 text-white font-semibold shadow-lg hover:bg-white/20 transition duration-150">
                        Batal
                    </button>
                </div>
            </div>
        </div>

        <!-- Lacak Aduanmu -->
        <div id="lacakContent"
            class="mt-14 relative overflow-hidden rounded-none md:rounded-2xl md:max-w-[67rem] 2xl:max-w-[90rem] mx-auto"
            data-aos="fade-up">

            <!-- Background -->
            <div class="absolute inset-0 bg-cover bg-center z-0 rounded-none md:rounded-2xl"
                style="background-image: url('/images/red.jpg');"></div>
            <div class="absolute inset-0 bg-black/10 z-20 rounded-none md:rounded-2xl"></div>

            <!-- Konten -->
            <div class="relative z-30 p-8 md:p-10 md:px-16 md:py-8 shadow-lg rounded-none md:rounded-2xl">
                <h3 class="text-2xl md:text-3xl font-semibold text-white mb-6 text-center">Lacak Aduanmu</h3>

                <!-- Form -->
                <form action="{{ route('report.lacak') }}" method="POST" class="flex items-center gap-3 max-w-lg mx-auto">
                    @csrf
                    <input type="text" name="tracking_id" placeholder="Nomor Tiket Aduan"
                        class="flex-1 border rounded-full px-6 py-3 bg-white text-gray-900 placeholder-gray-500
                                                                                                   text-base font-semibold tracking-wide shadow text-center
                                                                                                   focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition duration-300"
                        required>
                    <button type="submit"
                        class="whitespace-nowrap bg-transparent border border-white hover:bg-white/10 text-white px-6 py-3 rounded-full font-bold shadow-lg transition cursor-pointer flex items-center">
                        <i class="fas fa-search mr-2"></i> Lacak
                    </button>
                </form>
            </div>
        </div>
        @php
            use Illuminate\Support\Facades\Auth;

            $user = Auth::user();

            if ($user && $user->role === 'admin') {
                $kategoriIds = $user->kategori ? $user->kategori->pluck('id')->toArray() : [];
                $reports = \App\Models\Report::whereIn('kategori_id', $kategoriIds)
                    ->latest()
                    ->take(9)
                    ->get();
            } elseif ($user && $user->role === 'superadmin') {
                $reports = \App\Models\Report::latest()->take(9)->get();
            } else {
                $reports = \App\Models\Report::latest()->take(9)->get();
            }
        @endphp

        <div class="relative max-w-7xl mx-auto mt-6 p-6 md:max-w-[70rem] 2xl:max-w-[93rem]" data-aos="fade-up">

            <div class="flex items-center justify-between mb-4 md:mb-8">
                <h2 class="text-gray-900 text-2xl font-bold">Aduan Terbaru</h2>
                <a href="{{ route('daftar-aduan') }}"
                    class="flex items-center gap-1 text-red-500 text-sm mt-1 font-semibold hover:text-red-700 group">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-4 h-4 md:w-5 md:h-5 transition-transform duration-300 group-hover:translate-x-1"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>

            {{-- Mobile: Carousel --}}
            <div class="relative md:hidden">
                <!-- Prev -->
                <button id="prevBtn"
                    class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white shadow rounded-full w-10 h-10 flex items-center justify-center disabled:opacity-40">
                    <i class="fas fa-chevron-left text-blue-700 text-sm"></i>
                </button>

                <!-- Carousel Container -->
                <div id="carouselContainer" class="overflow-x-auto overflow-y-hidden scroll-smooth scrollbar-hide mt-6">
                    <div id="carouselItems" class="flex">
                        @foreach ($reports as $report)
                            @php
                                $defaultImage = asset('images/image.jpg');
                                $thumbnail = $defaultImage;

                                if (!empty($report->file)) {
                                    // Pastikan $report->file berupa array
                                    $files = is_array($report->file) ? $report->file : json_decode($report->file, true);

                                    if (is_array($files) && count($files) > 0) {
                                        foreach ($files as $f) {
                                            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                                $thumbnail = asset($f);
                                                break;
                                            }
                                        }
                                    }
                                }
                            @endphp

                            <div class="min-w-[calc(50%-0.75rem)] max-w-[calc(50%-0.75rem)] mx-1 bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden"
                                data-aos="fade-up">
                                <a href="{{ route('reports.show', ['id' => $report->id]) }}" class="relative block">
                                    <img src="{{ $thumbnail }}" alt="Thumbnail Aduan"
                                        class="w-full h-40 object-cover rounded-t-xl">

                                    <span
                                        class="absolute top-2 left-2 px-3 py-1 rounded-full text-xs font-semibold shadow-lg
                                                                                                                                                                                                                                            @if($report->status === 'Diajukan') bg-red-200 text-red-800
                                                                                                                                                                                                                                            @elseif($report->status === 'Dibaca') bg-blue-200 text-blue-800
                                                                                                                                                                                                                                            @elseif($report->status === 'Direspon') bg-yellow-200 text-yellow-800
                                                                                                                                                                                                                                            @elseif($report->status === 'Selesai') bg-green-200 text-green-800
                                                                                                                                                                                                                                              @elseif($report->status === 'Arsip') bg-stone-200 text-stone-800
                                                                                                                                                                                                                                            @else bg-gray-200 text-gray-700
                                                                                                                                                                                                                                            @endif">
                                        {{ $report->status }}
                                    </span>

                                    <span
                                        class="absolute bottom-2 left-1/2 transform -translate-x-1/2 
                                                                                                                                                                                                                                            bg-zinc-900/60 text-white text-[8.5px] px-2 py-[1px] 
                                                                                                                                                                                                                                            rounded-full backdrop-blur-sm tracking-wider italic 
                                                                                                                                                                                                                                            font-semibold shadow-md shadow-black/30 ring-1 ring-white/10">
                                        {{ $report->is_anonim ? 'Anonim' : $report->nama_pengadu }}
                                    </span>
                                </a>

                                <div class="p-3">
                                    <h3 class="font-semibold text-lg text-gray-800 truncate">
                                        <a href="{{ route('reports.show', ['id' => $report->id]) }}"
                                            class="hover:text-blue-600">
                                            {{ Str::limit($report->judul, 27) }}
                                        </a>
                                    </h3>

                                    <div class="flex items-center gap-1 text-[10px] text-gray-600 mt-1">
                                        <i class="fa-solid fa-calendar-alt text-[11px] text-zinc-500 relative top-[0.5px]"></i>
                                        <span class="truncate">
                                            {{ $report->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}
                                            WIB
                                        </span>
                                    </div>

                                    <p class="text-sm text-gray-700 mt-2 line-clamp-2">
                                        <a href="{{ route('reports.show', ['id' => $report->id]) }}"
                                            class="hover:text-blue-600">
                                            {{ Str::limit($report->isi, 100) }}
                                        </a>
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Next -->
                <button id="nextBtn"
                    class="absolute right-0 top-1/2 -translate-y-1/2 bg-white shadow rounded-full w-10 h-10 flex items-center justify-center disabled:opacity-40">
                    <i class="fas fa-chevron-right text-blue-700"></i>
                </button>
            </div>

            {{-- Desktop: Grid --}}
            <div class="hidden md:grid grid-cols-3 gap-8">
                @foreach ($reports as $report)
                    @php
                        $defaultImage = asset('images/image.jpg');
                        $thumbnail = $defaultImage;

                        if (!empty($report->file)) {
                            // Pastikan $report->file berupa array
                            $files = is_array($report->file) ? $report->file : json_decode($report->file, true);

                            if (is_array($files) && count($files) > 0) {
                                foreach ($files as $f) {
                                    $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));
                                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                        $thumbnail = asset($f);
                                        break;
                                    }
                                }
                            }
                        }
                    @endphp

                    <div class="bg-white rounded-2xl shadow hover:shadow-lg hover:scale-[1.02] transition-transform duration-300 ease-in-out overflow-hidden"
                        data-aos="fade-up">
                        <a href="{{ route('reports.show', ['id' => $report->id]) }}" class="relative block">
                            <!-- Gambar dengan ukuran seragam -->
                            <img src="{{ $thumbnail }}" alt="Thumbnail Aduan" class="w-full h-64 object-cover">

                            <!-- Status -->
                            <span
                                class="absolute top-2 left-2 px-4 py-1.5 rounded-full text-base font-semibold shadow-lg
                                                                                                                                                                                                                            @if($report->status === 'Diajukan') bg-red-200 text-red-800
                                                                                                                                                                                                                            @elseif($report->status === 'Dibaca') bg-blue-200 text-blue-800
                                                                                                                                                                                                                            @elseif($report->status === 'Direspon') bg-yellow-200 text-yellow-800
                                                                                                                                                                                                                            @elseif($report->status === 'Selesai') bg-green-200 text-green-800
                                                                                                                                                                                                                             @elseif($report->status === 'Arsip') bg-stone-200 text-stone-800
                                                                                                                                                                                                                            @else bg-gray-200 text-gray-700
                                                                                                                                                                                                                            @endif">
                                {{ $report->status }}
                            </span>

                            <!-- Nama pengadu -->
                            <span
                                class="absolute bottom-2 left-1/2 transform -translate-x-1/2 
                                                                                                                                                                                                                            bg-zinc-900/60 text-white text-[12px] px-3 py-[3px] 
                                                                                                                                                                                                                            rounded-full backdrop-blur-sm tracking-wider italic 
                                                                                                                                                                                                                            font-semibold shadow-md shadow-black/30 ring-1 ring-white/10">
                                {{ $report->is_anonim ? 'Anonim' : $report->nama_pengadu }}
                            </span>
                        </a>

                        <!-- Konten -->
                        <div class="p-3">
                            <h3 class="font-semibold text-lg text-gray-800 truncate">
                                <a href="{{ route('reports.show', ['id' => $report->id]) }}" class="hover:text-blue-600">
                                    {{ Str::limit($report->judul, 40) }}
                                </a>
                            </h3>

                            <div class="flex items-center gap-1 text-[10px] text-gray-600 mt-1">
                                <i class="fa-solid fa-calendar-alt text-[11px] text-zinc-500 relative top-[0.5px]"></i>
                                <span class="truncate">
                                    {{ $report->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}
                                    WIB
                                </span>
                            </div>

                            <p class="text-sm text-gray-700 mt-2 line-clamp-2">
                                <a href="{{ route('reports.show', ['id' => $report->id]) }}" class="hover:text-blue-600">
                                    {{ Str::limit($report->isi, 100) }}
                                </a>
                            </p>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>

    </section>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
    <!-- Mapbox CSS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <!-- Mapbox JS -->
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1/mapbox-gl-geocoder.min.js"></script>
    <link rel="stylesheet"
        href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1/mapbox-gl-geocoder.css" />
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
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

        // ==== GLOBAL KONFIGURASI PETA ====
        mapboxgl.accessToken = "pk.eyJ1IjoiZmFkaWxhaDI0OCIsImEiOiJja3dnZXdmMnQwbno1MnRxcXYwdjB3cG9qIn0.v4gAtavpn1GzgtD7f3qapA";

        let map, marker;
        let jogjaPlaces = [];
        let jogjaDataLoaded = false;

        // ==== DATA MANUAL TAMBAHAN ====
        const manualPlaces = [
            {
                name: "Diskominfo DIY",
                address: "Jl. Brigjen Katamso No. 3, Yogyakarta",
                lat: -7.801389,
                lon: 110.368056,
                category: "office"
            },
            {
                name: "Diskominfo Bantul",
                address: "Jl. Lingkar Timur, Manding, Trirenggo, Bantul",
                lat: -7.912229,
                lon: 110.335879,
                category: "office"
            },
            {
                name: "Diskominfo Sleman",
                address: "Jl. Parasamya, Beran Lor, Tridadi, Sleman",
                lat: -7.716879,
                lon: 110.356150,
                category: "office"
            }
        ];

        // ==== FALLBACK DATA MANUAL ====
        function useManualData() {
            jogjaPlaces = manualPlaces;
            jogjaDataLoaded = true;
            console.warn("Menggunakan data manual (OSM gagal / timeout).");
            console.log("Data manual:", jogjaPlaces);
        }

        function loadJogjaData() {
            const cached = localStorage.getItem("jogjaPlaces");
            const cacheTime = Number(localStorage.getItem("jogjaPlaces_time"));
            const oneDay = 24 * 60 * 60 * 1000;

            // Ambil dari cache kalau masih valid, lalu gabungkan dengan manualPlaces
            if (cached && cacheTime && (Date.now() - cacheTime) < oneDay) {
                jogjaPlaces = [...JSON.parse(cached), ...manualPlaces];
                jogjaDataLoaded = true;
                console.log(`Loaded ${jogjaPlaces.length} lokasi dari cache + manual`);
                return;
            }

            const areaQuery = `area["name"="Daerah Istimewa Yogyakarta"]->.searchArea;`;

            // Beberapa query kecil
            const queries = [
                `
                                                                                                                                                [out:json][timeout:20];
                                                                                                                                                ${areaQuery}
                                                                                                                                                (node["place"](area.searchArea); way["place"](area.searchArea););
                                                                                                                                                out center tags;
                                                                                                                                                `,
                `
                                                                                                                                                [out:json][timeout:20];
                                                                                                                                                ${areaQuery}
                                                                                                                                                (node["highway"~"motorway|trunk|primary|secondary|tertiary|residential"](area.searchArea););
                                                                                                                                                out center tags;
                                                                                                                                                `,
                `
                                                                                                                                                [out:json][timeout:20];
                                                                                                                                                ${areaQuery}
                                                                                                                                                (node["amenity"](area.searchArea); way["amenity"](area.searchArea););
                                                                                                                                                out center tags;
                                                                                                                                                `,
                `
                                                                                                                                                [out:json][timeout:20];
                                                                                                                                                ${areaQuery}
                                                                                                                                                (node["shop"](area.searchArea); way["shop"](area.searchArea););
                                                                                                                                                out center tags;
                                                                                                                                                `,
                `
                                                                                                                                                [out:json][timeout:20];
                                                                                                                                                ${areaQuery}
                                                                                                                                                (node["office"](area.searchArea); way["office"](area.searchArea););
                                                                                                                                                out center tags;
                                                                                                                                                `
            ];

            const fetchQuery = (query) => {
                return fetch("https://overpass.kumi.systems/api/interpreter", {
                    method: "POST",
                    body: query
                }).then(res => res.json());
            };

            const timeoutId = setTimeout(() => {
                console.warn("Timeout — menggunakan data manual");
                useManualData();
            }, 10000);

            Promise.all(queries.map(q => fetchQuery(q)))
                .then(results => {
                    clearTimeout(timeoutId);

                    // Gabungkan semua hasil
                    let allElements = results.flatMap(r => r.elements);

                    // Buang duplikat berdasarkan lat+lon
                    let unique = [];
                    let seen = new Set();
                    for (let el of allElements) {
                        const lat = el.lat || el.center?.lat;
                        const lon = el.lon || el.center?.lon;
                        if (!lat || !lon) continue;
                        const key = `${lat},${lon}`;
                        if (!seen.has(key)) {
                            seen.add(key);
                            unique.push({
                                name: el.tags?.name || "Tanpa Nama",
                                address: [
                                    el.tags?.['addr:street'],
                                    el.tags?.['addr:housenumber'],
                                    el.tags?.['addr:city']
                                ].filter(Boolean).join(', '),
                                lat,
                                lon
                            });
                        }
                    }

                    // Gabungkan hasil OSM dengan manualPlaces
                    jogjaPlaces = [...unique, ...manualPlaces];
                    jogjaDataLoaded = true;

                    // Simpan ke cache
                    localStorage.setItem("jogjaPlaces", JSON.stringify(unique));
                    localStorage.setItem("jogjaPlaces_time", Date.now());

                    console.log(`Loaded ${jogjaPlaces.length} lokasi (gabungan OSM + manual)`);
                })
                .catch(err => {
                    clearTimeout(timeoutId);
                    console.error("Gagal ambil data:", err);
                    useManualData();
                });
        }

        // ==== DEBOUNCE FUNCTION ====
        function debounce(func, wait) {
            let timeout;
            return function (...args) {
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(this, args), wait);
            };
        }

        // ==== AUTOCOMPLETE PENCARIAN (Radius dari Lokasi User) ====
        function setupAutocomplete(userLat, userLon, radiusKm = 50) {
            const searchInput = document.getElementById('searchLocation');
            const suggestionsBox = document.getElementById('searchSuggestions');

            // Hitung jarak (Haversine)
            function distanceKm(lat1, lon1, lat2, lon2) {
                const R = 6371; // km
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a =
                    Math.sin(dLat / 2) ** 2 +
                    Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                    Math.sin(dLon / 2) ** 2;
                return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
            }

            searchInput.addEventListener('input', debounce(function () {
                const query = this.value.trim().toLowerCase();
                suggestionsBox.innerHTML = '';

                if (!jogjaDataLoaded) {
                    suggestionsBox.innerHTML = '<li class="px-4 py-2 text-gray-500">Memuat data lokasi...</li>';
                    suggestionsBox.classList.remove('hidden');
                    return;
                }

                if (query.length < 2) {
                    suggestionsBox.classList.add('hidden');
                    return;
                }

                const matches = jogjaPlaces
                    .filter(p => {
                        const inRadius = distanceKm(userLat, userLon, p.lat, p.lon) <= radiusKm;
                        if (!inRadius) return false;
                        const nameMatch = p.name?.toLowerCase().includes(query);
                        const addressMatch = p.address?.toLowerCase().includes(query);
                        return nameMatch || addressMatch;
                    })
                    .sort((a, b) => {
                        const aStarts = a.name?.toLowerCase().startsWith(query) || a.address?.toLowerCase().startsWith(query);
                        const bStarts = b.name?.toLowerCase().startsWith(query) || b.address?.toLowerCase().startsWith(query);
                        if (aStarts === bStarts) {
                            return a.name.localeCompare(b.name);
                        }
                        return aStarts ? -1 : 1;
                    })
                    .slice(0, 100);

                if (matches.length === 0) {
                    suggestionsBox.classList.add('hidden');
                    return;
                }

                matches.forEach(place => {
                    const li = document.createElement('li');
                    li.innerHTML = `<strong>${place.name}</strong><br><small class="text-gray-500">${place.address || ''}</small>`;
                    li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';

                    li.addEventListener('click', () => {
                        searchInput.value = place.name;
                        document.getElementById('alamatField').value = place.address || place.name;
                        document.getElementById('latitudeField').value = place.lat.toFixed(6);
                        document.getElementById('longitudeField').value = place.lon.toFixed(6);

                        if (map) {
                            map.flyTo({ center: [place.lon, place.lat], zoom: 15 });
                            if (!marker) {
                                marker = new mapboxgl.Marker().setLngLat([place.lon, place.lat]).addTo(map);
                            } else {
                                marker.setLngLat([place.lon, place.lat]);
                            }
                        }

                        suggestionsBox.classList.add('hidden');
                    });

                    suggestionsBox.appendChild(li);
                });

                suggestionsBox.classList.remove('hidden');
            }, 200));

            // Tutup suggestion jika klik di luar
            document.addEventListener('click', e => {
                if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
                    suggestionsBox.classList.add('hidden');
                }
            });
        }

        // ==== MODAL PETA ====
        function setupMapModal() {
            window.openLocationModal = function () {
                const modal = document.getElementById('locationModal');
                const content = modal.querySelector('div');

                modal.classList.remove('hidden');
                content.classList.remove('modal-animate-out');
                content.classList.add('modal-animate-in');

                if (!map) {
                    map = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/streets-v12',
                        center: [110.370529, -7.797068],
                        zoom: 13
                    });

                    map.addControl(new mapboxgl.NavigationControl());

                    map.on('click', e => {
                        const { lng, lat } = e.lngLat;

                        if (!marker) {
                            marker = new mapboxgl.Marker().setLngLat([lng, lat]).addTo(map);
                        } else {
                            marker.setLngLat([lng, lat]);
                        }

                        document.getElementById('latitudeField').value = lat.toFixed(6);
                        document.getElementById('longitudeField').value = lng.toFixed(6);

                        // Ambil alamat dari Mapbox
                        fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lng},${lat}.json?access_token=${mapboxgl.accessToken}&language=id`)
                            .then(res => res.json())
                            .then(data => {
                                document.getElementById('alamatField').value =
                                    data.features?.[0]?.place_name || '';
                            })
                            .catch(err => console.error('Geocoding error:', err));
                    });
                }
            };
        }

        // ==== INISIALISASI ====
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({ offset: 120, easing: 'ease-out-cubic' });
            loadJogjaData();
            setupMapModal();

            // Langsung minta izin lokasi
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    pos => {
                        const lat = pos.coords.latitude;
                        const lon = pos.coords.longitude;
                        console.log("Lokasi user:", lat, lon);
                        setupAutocomplete(lat, lon, 50); // radius default 50 km
                    },
                    err => {
                        console.warn("Gagal ambil lokasi user, pakai pusat Jogja");
                        setupAutocomplete(-7.7956, 110.3695, 50);
                    },
                    { enableHighAccuracy: true, timeout: 5000, maximumAge: 0 }
                );
            } else {
                console.warn("Geolocation tidak didukung browser");
                setupAutocomplete(-7.7956, 110.3695, 50);
            }
        });

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
            const defaultLatLng = [110.370529, -7.797068];
            map.setCenter(defaultLatLng);
            map.setZoom(13);

            if (marker) {
                marker.remove();
                marker = null;
            }

            document.getElementById('latitudeField').value = '';
            document.getElementById('longitudeField').value = '';
            document.getElementById('alamatField').value = '';
        }

        // ====== Swiper Init ======
        const swiper = new Swiper('.mySwiper', {
            loop: true,
            pagination: { el: '.swiper-pagination', clickable: true },
            autoplay: { delay: 5000, disableOnInteraction: false },
            observer: true,
            observeParents: true,
            on: {
                init: () => {
                    const content = document.getElementById('heroContent');
                    document.querySelector('.mySwiper').classList.remove('invisible');
                    content.classList.remove('opacity-0');
                    content.classList.add('opacity-100');
                    AOS.refresh();
                }
            }
        });

        // ====== Variabel Global File ======
        const maxFiles = 3;
        let fileToDelete = null;
        const addFileBtn = document.getElementById('addFileBtn');
        const fileInputsContainer = document.getElementById('fileInputs');
        const fileInputHiddenContainer = document.getElementById('fileInputHiddenContainer');
        const fileModal = document.getElementById('fileModal');
        const deleteConfirmModal = document.getElementById('deleteConfirmModal');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const confirmFileBtn = document.getElementById('confirmFileBtn');
        const openFileModalBtn = document.getElementById('openFileModalBtn');

        // ====== Carousel ======
        const carouselItems = document.getElementById('carouselItems');
        const container = document.getElementById('carouselContainer');
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const cardWidth = document.querySelector('#carouselItems > div')?.offsetWidth + 8 || 0;
        const itemsPerPage = 2;
        const totalItems = {{ count($reports) }};
        let currentIndex = 0;

        const scrollAmount = container.offsetWidth * 0.9;

        prevBtn?.addEventListener('click', () => {
            container.scrollBy({
                left: -scrollAmount, behavior: 'smooth'
            });
        });

        nextBtn?.addEventListener('click', () => {
            container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
        });

        function updateButtonState() {
            prevBtn.disabled = container.scrollLeft <= 0;
            nextBtn.disabled = container.scrollLeft + container.clientWidth >= container.scrollWidth - 1;
        }

        container.addEventListener('scroll', updateButtonState);
        window.addEventListener('load', updateButtonState);

        // ==== REVERSE DRAG SCROLL ====
        let isDragging = false;
        let startX;
        let scrollStart;

        container.addEventListener('mousedown', (e) => {
            isDragging = true;
            container.classList.add('cursor-grabbing');
            startX = e.pageX;
            scrollStart = container.scrollLeft;
        });

        container.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const dx = e.pageX - startX;
            container.scrollLeft = scrollStart + dx;
        });

        container.addEventListener('mouseup', () => {
            isDragging = false;
            container.classList.remove('cursor-grabbing');
        });

        container.addEventListener('mouseleave', () => {
            isDragging = false;
            container.classList.remove('cursor-grabbing');
        });

        updateButtonState();

        // ====== Input Counter ======
        const judulInput = document.getElementById('judulInput');
        const judulCounter = document.getElementById('judulCounter');
        const isiInput = document.getElementById('isiInput');
        const isiCounter = document.getElementById('isiCounter');

        judulInput?.addEventListener('input', () => {
            judulCounter.textContent = `${judulInput.value.length}/150`;
        });

        isiInput?.addEventListener('input', () => {
            isiCounter.textContent = `${isiInput.value.length}/1000`;
        });

        // ====== Fungsi File ======
        function updateAddFileButtonVisibility() {
            const currentInputs = fileInputsContainer.querySelectorAll('input[type="file"]');
            addFileBtn.classList.toggle('hidden', currentInputs.length >= maxFiles);
        }

        addFileBtn?.addEventListener('click', () => {
            if (fileInputsContainer.querySelectorAll('input[type="file"]').length >= maxFiles) return;
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 mb-2';
            div.innerHTML = `
                                                                                                                                                                                                                                                                                                                                                <input type="file" name="file[]" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.zip"
                                                                                                                                                                                                                                                                                                                                                    class="file-input flex-1 border px-2 py-1 rounded text-sm">
                                                                                                                                                                                                                                                                                                                                                <button type="button" class="deleteFileBtn text-red-600 hover:text-red-800 text-lg">
                                                                                                                                                                                                                                                                                                                                                    <i class="fas fa-trash-alt"></i>
                                                                                                                                                                                                                                                                                                                                                </button>`;
            fileInputsContainer.appendChild(div);
            updateAddFileButtonVisibility();
        });

        fileInputsContainer?.addEventListener('click', e => {
            const deleteBtn = e.target.closest('.deleteFileBtn');
            if (deleteBtn) {
                fileToDelete = deleteBtn.closest('.flex');
                deleteConfirmModal.classList.remove('hidden');
                deleteConfirmModal.classList.add('flex');
            }
        });

        confirmDeleteBtn?.addEventListener('click', () => {
            if (fileToDelete) {
                fileToDelete.remove();
                fileToDelete = null;
                updateAddFileButtonVisibility();
            }
            closeDeleteModal();
        });

        function closeDeleteModal() {
            deleteConfirmModal.classList.add('hidden');
            deleteConfirmModal.classList.remove('flex');
        }

        confirmFileBtn?.addEventListener('click', () => {
            const inputs = fileInputsContainer.querySelectorAll('input[type="file"]');
            let validFiles = 0;
            inputs.forEach(input => { if (input.files.length > 0) validFiles++; });

            if (validFiles > maxFiles) {
                alert('Maksimal 3 file!');
                return;
            }

            fileInputHiddenContainer.innerHTML = '';
            inputs.forEach(input => {
                if (input.files.length > 0) fileInputHiddenContainer.appendChild(input);
            });

            fileInputsContainer.innerHTML = '';
            fileModal.classList.remove('flex');
            fileModal.classList.add('hidden');
            addFileBtn.classList.remove('hidden');
        });

        openFileModalBtn?.addEventListener('click', () => {
            fileModal.classList.remove('hidden');
            fileModal.classList.add('flex');
            const hiddenInputs = fileInputHiddenContainer.querySelectorAll('input[type="file"]');
            hiddenInputs.forEach(input => fileInputsContainer.appendChild(input));
            fileInputHiddenContainer.innerHTML = '';
            updateAddFileButtonVisibility();
        });

        function closeFileModal() {
            fileModal.classList.remove('flex');
            fileModal.classList.add('hidden');
            fileInputsContainer.innerHTML = '';
        }

        // ====== Anonimitas Toggle ======
        const anonimCheckbox = document.getElementById('anonimCheckbox');
        const identitasGroup = document.querySelector('.identitas-group');
        anonimCheckbox?.addEventListener('change', function () {
            identitasGroup.style.display = this.checked ? 'none' : 'block';
        });

        // ====== Overlay Login ======
        const formContainer = document.getElementById('aduanCepatBox');
        const overlay = document.getElementById('form-overlay');
        if (overlay && formContainer) {
            formContainer.addEventListener('mouseenter', () => overlay.classList.remove('hidden'));
            formContainer.addEventListener('mouseleave', () => overlay.classList.add('hidden'));
            const form = formContainer.querySelector('form');
            form?.addEventListener('submit', e => e.preventDefault());
        }

        // ====== Spinner ke Checklist ======
        const spinner = document.getElementById('success-spinner');
        const check = document.getElementById('success-check');
        setTimeout(() => {
            spinner.classList.add('hidden');
            check.classList.remove('hidden');
            check.classList.add('scale-100');
        }, 1000);

        // ====== Auto Fade Alert ======
        const fadeOutAndRemove = el => {
            el?.classList.remove('opacity-100');
            el?.classList.add('opacity-0');
            setTimeout(() => el.style.display = 'none', 500);
        };

        setTimeout(() => {
            fadeOutAndRemove(document.getElementById('alert-success'));
            fadeOutAndRemove(document.getElementById('alert-error'));
        }, 3000);

        // ====== TomSelect Init ======
        new TomSelect('#kategoriSelect', {
            placeholder: '- Pilih Kategori -',
            allowEmptyOption: true,
            create: false,
            sortField: { field: 'text', direction: 'asc' }
        });

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

        // === Daftarkan fungsi global untuk HTML onclick ===
        window.openLocationModal = openLocationModal;
        window.closeLocationModal = closeLocationModal;
        window.saveLocation = saveLocation;
        window.resetMapToDefault = resetMapToDefault;
        window.closeFileModal = closeFileModal;
        window.closeDeleteModal = closeDeleteModal;
    </script>
@endpush