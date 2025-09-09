@extends('portal.layouts.app')

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
        <div id="alert-success"
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
        <div id="alert-error" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            class="fixed top-5 right-5 z-50 w-80 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500"
            x-transition.opacity>

            <!-- Header dengan tombol close -->
            <div class="flex justify-between items-start">
                <span class="text-sm">{{ session('error') }}</span>
                <button @click="show = false" class="ml-3 text-white hover:text-gray-200">
                    ✕
                </button>
            </div>

            <!-- Progress bar -->
            <div class="relative w-full h-1 bg-red-700 mt-3 rounded">
                <div class="absolute top-0 left-0 h-1 bg-white rounded animate-progress"></div>
            </div>
        </div>

        <!-- Animasi progress bar -->
        <style>
            @keyframes progress {
                from {
                    width: 100%;
                }

                to {
                    width: 0%;
                }
            }

            .animate-progress {
                animation: progress 5s linear forwards;
            }
        </style>
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
                        <img src="{{ asset('images/aduan2.jpg') }}"
                            class="absolute inset-0 w-full h-full object-cover z-10 will-change-transform backface-hidden"
                            loading="eager" alt="E-Lapor">

                        <!-- Overlay hitam (z-20 - paling atas) -->
                        <div class="absolute inset-0 bg-black/65 z-20"></div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="swiper-slide relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>

                        <img src="{{ asset('images/aduan3.jpg') }}"
                            class="absolute inset-0 w-full h-full object-cover z-10 will-change-transform backface-hidden"
                            loading="eager" alt="Pengaduan">

                        <div class="absolute inset-0 bg-black/65 z-20"></div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="swiper-slide relative">
                        <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>

                        <img src="{{ asset('images/aduan1.jpg') }}"
                            class="absolute inset-0 w-full h-full object-cover z-10 will-change-transform backface-hidden"
                            loading="eager" alt="Layanan Publik">

                        <div class="absolute inset-0 bg-black/55 z-20"></div>
                    </div>
                </div>

                <!-- Pagination & Navigation -->
                <div class="swiper-pagination z-20"></div>
            </div>

            <!-- Fonts -->
            <link
                href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap"
                rel="stylesheet">

            <style>
                .font-heading {
                    font-family: 'Poppins', sans-serif;
                }

                .font-body {
                    font-family: 'Inter', sans-serif;
                }
            </style>

            <!-- Hero Content -->
            <div id="heroContent"
                class="absolute inset-0 z-30 flex flex-col justify-center items-center text-center h-full px-6 py-10 opacity-0 transition-opacity duration-700">

                <!-- Heading -->
                <h1 class="text-2xl sm:text-3xl lg:text-5xl font-bold mb-6 leading-tight font-heading text-white"
                    data-aos="fade-down" data-aos-delay="0">
                    Wujudkan DIY Lebih Baik</span> <br class="sm:hidden" /> Bersama E-Lapor
                </h1>

                <!-- Sub Heading -->
                <p class="text-sm sm:text-xl lg:text-2xl max-w-2xl mb-6 opacity-90 font-body text-white"
                    data-aos="fade-down" data-aos-delay="200">
                    Platform pengaduan digital yang cepat, dan terpercaya untuk masyarakat Daerah Istimewa
                    Yogyakarta.
                </p>

                <!-- Tagline -->
                <div class="w-full flex justify-center px-4 mb-8" data-aos="fade-down" data-aos-delay="400">
                    <div
                        class="inline-flex items-center gap-3 sm:gap-4 px-4 sm:px-6 py-2 sm:py-2 rounded-xl
                                                                                                                                                                                            border border-yellow-400 bg-gradient-to-r from-yellow-200 to-yellow-300
                                                                                                                                                                                            shadow-md">

                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-yellow-500">
                                <i class="fas fa-bullhorn text-white text-sm sm:text-lg"></i>
                            </div>
                        </div>

                        <!-- Text -->
                        <div class="text-center">
                            <p class="text-[11px] sm:text-sm md:text-lg font-semibold text-yellow-900 tracking-wide">
                                Aduan Anda, <span class="italic font-normal">Perubahan untuk Kita Semua!</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Button -->
                <div class="flex justify-center" data-aos="fade-up" data-aos-delay="600">
                    <a href="#aduanCepatBox"
                        class="relative inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-rose-500 to-red-600 p-[1px] shadow-lg transition hover:scale-105 hover:shadow-xl">
                        <span
                            class="flex items-center gap-3 px-8 sm:px-12 py-3 sm:py-4 bg-black/20 rounded-full text-white font-bold text-base sm:text-lg lg:text-xl">
                            <i class="fas fa-paper-plane"></i>
                            Buat Aduan Cepat
                        </span>
                    </a>
                </div>

                <!-- Statistik -->
                <div class="grid grid-cols-3 gap-6 mt-10 text-center" data-aos="fade-up" data-aos-delay="800">
                    <!-- Total Aduan -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-file-alt text-3xl md:text-5xl text-rose-500 mb-2"></i>
                        <p class="text-xl font-bold text-white">
                            {{ \App\Models\Report::count() }}
                        </p>
                        <span class="text-sm opacity-80">Total Aduan</span>
                    </div>

                    <!-- Aduan Bulan Ini -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-calendar-alt text-3xl md:text-5xl text-rose-500 mb-2"></i>
                        <p class="text-xl font-bold text-white">
                            {{ \App\Models\Report::whereMonth('created_at', \Carbon\Carbon::now()->month)
        ->whereYear('created_at', \Carbon\Carbon::now()->year)
        ->count() }}
                        </p>
                        <span class="text-sm opacity-80">Aduan Bulan Ini</span>
                    </div>

                    <!-- Aduan Selesai -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-check-circle text-3xl md:text-5xl text-rose-500 mb-2"></i>
                        <p class="text-xl font-bold text-white">
                            {{ \App\Models\Report::where('status', \App\Models\Report::STATUS_SELESAI)->count() }}
                        </p>
                        <span class="text-sm opacity-80">Aduan Selesai</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Desktop View -->
        <div class="hidden lg:block relative h-[96vh] overflow-hidden">
            <!-- Background Swiper (Full) -->
            <div class="absolute inset-0 z-10">
                <div class="swiper mySwiper w-full h-full">
                    <div class="swiper-wrapper">
                        <!-- Slide 1 -->
                        <div class="swiper-slide relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>
                            <img src="{{ asset('images/aduan2.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover z-10" alt="E-Lapor">
                            <div class="absolute inset-0 bg-black/65 z-20"></div>
                        </div>

                        <!-- Slide 2 -->
                        <div class="swiper-slide relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>
                            <img src="{{ asset('images/aduan3.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover z-10" alt="Pengaduan">
                            <div class="absolute inset-0 bg-black/65 z-20"></div>
                        </div>

                        <!-- Slide 3 -->
                        <div class="swiper-slide relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-red-500/20 to-red-400/10 z-20"></div>
                            <img src="{{ asset('images/aduan1.jpg') }}"
                                class="absolute inset-0 w-full h-full object-cover z-10" alt="Layanan Publik">
                            <div class="absolute inset-0 bg-black/55 z-20"></div>
                        </div>
                    </div>

                    <!-- Pagination harus di luar swiper-wrapper -->
                    <div class="swiper-pagination z-20"></div>
                </div>
            </div>

            <!-- Konten -->
            <div
                class="relative z-30 container mx-auto px-6 sm:px-10 lg:px-16 h-full flex flex-col items-center justify-center text-center text-white animate__animated animate__fadeIn">

                <!-- Tambahkan di <head> -->
                <link
                    href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@600;700&display=swap"
                    rel="stylesheet">

                <style>
                    .font-heading {
                        font-family: 'Poppins', sans-serif;
                    }

                    .font-body {
                        font-family: 'Inter', sans-serif;
                    }
                </style>

                <!-- Konten -->
                <h1 class="text-xl sm:text-xl md:text-xl lg:text-4xl font-bold mb-6 leading-tight font-heading">
                    Wujudkan <span class="text-white">DIY Lebih Baik</span> Bersama E-Lapor
                </h1>

                <!-- Deskripsi -->
                <p class="text-base sm:text-md md:text-lg lg:text-xl max-w-3xl mb-6 opacity-90 font-body">
                    Platform pengaduan digital yang cepat, transparan, dan terpercaya untuk masyarakat Daerah Istimewa
                    Yogyakarta.
                </p>

                <!-- Tagline Alert -->
                <div class="w-full flex justify-center px-4 mb-8">
                    <div
                        class="inline-flex items-center gap-4 px-6 py-2 rounded-xl
                                                                                                                                                                                                border border-yellow-400 bg-gradient-to-r from-yellow-200 to-yellow-300
                                                                                                                                                                                                shadow-md">

                        <!-- Icon -->
                        <div class="flex-shrink-0">
                            <div class="flex items-center justify-center w-9 h-9 rounded-full bg-yellow-500">
                                <i class="fas fa-bullhorn text-white text-lg"></i>
                            </div>
                        </div>

                        <!-- Text -->
                        <div>
                            <p class="text-base sm:text-lg font-semibold text-yellow-900 tracking-wide">
                                Aduan Anda, <span class="italic font-normal">Perubahan untuk Kita Semua!</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="flex justify-center">
                    <a href="#aduanCepatBox"
                        class="relative inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-rose-500 to-red-600 p-[1px] shadow-lg transition hover:scale-105 hover:shadow-xl">
                        <span
                            class="flex items-center gap-3 sm:gap-4 px-8 sm:px-12 md:px-16 lg:px-12 py-2 sm:py-2 bg-black/20 rounded-full text-white font-bold text-base sm:text-xl md:text-2xl">
                            <i class="fas fa-paper-plane"></i>
                            Buat Aduan Cepat
                        </span>
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 mt-10 text-center" data-aos="fade-up" data-aos-delay="800">
                    <!-- Total Aduan -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-file-alt text-3xl lg:text-5xl text-rose-500 mb-2"></i>
                        <p class="text-xl lg:text-3xl font-bold text-white">
                            {{ \App\Models\Report::count() }}
                        </p>
                        <span class="text-sm lg:text-lg opacity-80">Total Aduan</span>
                    </div>

                    <!-- Aduan Bulan Ini -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-calendar-alt text-3xl lg:text-5xl text-rose-500 mb-2"></i>
                        <p class="text-xl lg:text-3xl font-bold text-white">
                            {{ \App\Models\Report::whereMonth('created_at', \Carbon\Carbon::now()->month)
        ->whereYear('created_at', \Carbon\Carbon::now()->year)
        ->count() }}
                        </p>
                        <span class="text-sm lg:text-lg opacity-80">Aduan Bulan Ini</span>
                    </div>

                    <!-- Aduan Selesai -->
                    <div class="flex flex-col items-center">
                        <i class="fas fa-check-circle text-3xl lg:text-5xl text-rose-500 mb-2"></i>
                        <p class="text-xl lg:text-3xl font-bold text-white">
                            {{ \App\Models\Report::where('status', \App\Models\Report::STATUS_SELESAI)->count() }}
                        </p>
                        <span class="text-sm lg:text-lg opacity-80">Aduan Selesai</span>
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
    <section class="py-14 pb-10 relative bg-white text-[#37474F] overflow-hidden" data-aos="fade-up">
        <!-- Layer Partikel -->
        <div id="particles-js" class="absolute inset-0 z-0"></div>

        <!-- Konten -->
        <div class="relative z-10 max-w-[95rem] mx-auto px-6">
            <h2 class="text-3xl font-bold text-center mb-14 text-gray-800">
                Alur Layanan
            </h2>

            @php
                $steps = [
                    ['icon' => 'fas fa-edit', 'title' => 'Tulis Aduan', 'desc' => 'Tulis aduan Anda dengan lengkap dan jelas.', 'bg' => 'bg-red-500', 'border' => 'border-red-500', 'text' => 'text-red-500'],
                    ['icon' => 'fas fa-share-square', 'title' => 'Proses Delegasi', 'desc' => 'Aduan Anda akan otomatis terdelegasi ke instansi berwenang.', 'bg' => 'bg-orange-500', 'border' => 'border-orange-500', 'text' => 'text-orange-500'],
                    ['icon' => 'fas fa-eye', 'title' => 'Proses Dibaca', 'desc' => 'Instansi akan membaca aduan Anda dengan cepat.', 'bg' => 'bg-blue-500', 'border' => 'border-blue-500', 'text' => 'text-blue-500'],
                    ['icon' => 'fas fa-tasks', 'title' => 'Proses Tindak Lanjut', 'desc' => 'Instansi akan menindaklanjuti aduan Anda dengan cepat.', 'bg' => 'bg-purple-600', 'border' => 'border-purple-600', 'text' => 'text-purple-600'],
                    ['icon' => 'fas fa-comments', 'title' => 'Tanggapan Balik', 'desc' => 'Anda dapat menanggapi kembali balasan dari instansi berwenang.', 'bg' => 'bg-yellow-500', 'border' => 'border-yellow-500', 'text' => 'text-yellow-500'],
                    ['icon' => 'fas fa-check-circle', 'title' => 'Selesai', 'desc' => 'Jika tindak lanjut selesai, maka instansi akan menutup aduan.', 'bg' => 'bg-green-600', 'border' => 'border-green-600', 'text' => 'text-green-600'],
                ];
            @endphp

            <!-- Desktop & Tablet: Roadmap Zigzag -->
            <div class="hidden md:block relative">
                <!-- Wave Tablet -->
                <div class="absolute top-1/2 left-0 w-full h-28 lg:hidden -translate-y-1/2 z-0">
                    <div>
                        <svg class="w-full h-full" fill="none" stroke="#dc2626" stroke-width="4">
                            <path
                                d="M50,40 
                                                                                                                                                               C130,10 220,80 300,50
                                                                                                                                                               S460,0 540,40
                                                                                                                                                               S650,80 780,40
                                                                                                                                                               Q810,20 825,40"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                </div>

                <!-- Wave Desktop (xl, lebih pendek) -->
                <div class="absolute top-1/2 left-0 w-full h-32 hidden lg:block 2xl:hidden -translate-y-1/2 z-0">
                    <div>
                        <svg class="w-full h-full" fill="none" stroke="#dc2626" stroke-width="5">
                            <path d="M100,60 
                                                                                                 C200,0 300,120 400,60 
                                                                                                 S600,0 700,60
                                                                                                 S900,120 1000,60
                                                                                                 Q1050,30 1100,60"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                </div>

                <!-- Wave Desktop (2xl, lebih panjang biar pas ke step 6) -->
                <div class="absolute top-1/2 left-0 w-full h-32 hidden 2xl:block -translate-y-1/2 z-0">
                    <div>
                        <svg class="w-full h-full" fill="none" stroke="#dc2626" stroke-width="5">
                            <path d="M100,60 
                                                                                                 C200,0 300,120 400,60 
                                                                                                 S600,0 700,60
                                                                                                 S900,120 1000,60
                                                                                                 S1200,0 1300,60"
                                stroke-linecap="round" />
                        </svg>
                    </div>
                </div>

                <!-- Steps Zigzag -->
                <div class="relative flex justify-between items-center px-4 md:px-5 lg:px-10">
                    @foreach ($steps as $index => $step)
                        <div class="w-1/6 flex flex-col 
                                                                                                                                                                                                                                                                                                                                        {{ $index % 2 == 0 ? '-mt-14 md:-mt-20 lg:-mt-28' : 'mt-14 md:mt-20 lg:mt-28' }} 
                                                                                                                                                                                                                                                                                                                                        items-center text-center relative group"
                            data-aos="{{ $index % 2 == 0 ? 'fade-up-right' : 'fade-up-left' }}"
                            data-aos-delay="{{ 100 + ($index * 100) }}">

                            <!-- Lingkaran Icon + Nomor -->
                            <div
                                class="relative flex items-center justify-center 
                                                                                                                                                                                                                                                                                                                                            w-10 h-10 md:w-12 md:h-12 lg:w-16 lg:h-16 
                                                                                                                                                                                                                                                                                                                                            {{ $step['bg'] }} text-white rounded-full 
                                                                                                                                                                                                                                                                                                                                            shadow-md md:shadow-lg shadow-red-200 
                                                                                                                                                                                                                                                                                                                                            text-lg md:text-xl lg:text-2xl">
                                <i class="{{ $step['icon'] }}"></i>
                                <!-- Nomor Urut -->
                                <span
                                    class="absolute -bottom-2 -right-2 
                                                                                                                                                                                                                                                                                                                                                bg-red-600 text-white font-bold rounded-full shadow
                                                                                                                                                                                                                                                                                                                                                w-4 h-4 md:w-5 md:h-5 lg:w-6 lg:h-6
                                                                                                                                                                                                                                                                                                                                                text-[9px] md:text-[10px] lg:text-xs 
                                                                                                                                                                                                                                                                                                                                                flex items-center justify-center">
                                    {{ $index + 1 }}
                                </span>
                            </div>

                            <!-- Card Ringkas -->
                            <div
                                class="mt-2 md:mt-3 bg-gradient-to-br from-red-50 to-red-100  rounded-lg shadow-xl md:shadow-xl 
                                                                                                                                                                                                                                                                                                                                            px-2 py-2 md:px-3 md:py-2 lg:px-4 lg:py-3 
                                                                                                                                                                                                                                                                                                                                            w-32 md:w-36 lg:w-44 
                                                                                                                                                                                                                                                                                                                                            hover:-translate-y-1 transition-all duration-300 
                                                                                                                                                                                                                                                                                                                                            hover:shadow-red-200 z-10">
                                <h3 class="text-[11px] md:text-xs lg:text-sm font-semibold mb-1 text-gray-800">
                                    {{ $step['title'] }}
                                </h3>
                                <p class="text-[9px] md:text-[10px] lg:text-xs text-gray-600 leading-snug">
                                    {{ $step['desc'] }}
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Mobile: Roadmap Zigzag dengan Wave -->
            <div class="md:hidden relative space-y-4">

                <!-- Wave Mobile (vertikal) -->
                <div class="absolute left-1/2 top-0 bottom-0 -translate-x-1/2 w-16 h-full z-0">
                    <svg class="w-full h-full" fill="none" stroke="#dc2626" stroke-width="4" preserveAspectRatio="none"
                        viewBox="0 0 100 1000">
                        <path d="M50,50
                                                                                                                 Q65,50 50,100
                                                                                                                 T50,200
                                                                                                                 T50,300
                                                                                                                 T50,400
                                                                                                                 T50,500
                                                                                                                 T50,600
                                                                                                                 T50,700
                                                                                                                 T50,800
                                                                                                                 T50,930"
                            stroke-linecap="round" />
                    </svg>
                </div>

                @foreach ($steps as $index => $step)
                    <div class="flex w-full relative" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}"
                        data-aos-delay="{{ 100 + ($index * 100) }}">

                        <!-- Card -->
                        <div class="w-1/2 {{ $index % 2 == 0 ? 'pr-5 flex justify-end' : 'pl-5 flex justify-start order-2' }}">
                            <div
                                class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl shadow-lg
                                                                                                                                                                                                                   px-5 py-4 w-44 sm:w-48
                                                                                                                                                                                                                   hover:-translate-y-1 transition-all duration-300 hover:shadow-red-200">
                                <h3 class="text-sm font-semibold mb-1 text-gray-800">
                                    {{ $step['title'] }}
                                </h3>
                                <p class="text-xs text-gray-600 leading-snug">
                                    {{ $step['desc'] }}
                                </p>
                            </div>
                        </div>

                        <!-- Icon + Nomor -->
                        <div
                            class="absolute left-1/2 -translate-x-1/2 top-1/2 -translate-y-1/2 
                                                                                                                                                                                        flex items-center justify-center 
                                                                                                                                                                                        w-14 h-14 {{ $step['bg'] }} text-white rounded-full 
                                                                                                                                                                                        shadow-md shadow-red-200 text-xl z-10">
                            <i class="{{ $step['icon'] }}"></i>
                            <span
                                class="absolute -bottom-2.5 -right-2.5 bg-red-600 text-white font-bold rounded-full shadow
                                                                                                                                                                                           w-6 h-6 text-[11px] flex items-center justify-center">
                                {{ $index + 1 }}
                            </span>
                        </div>

                        <!-- Spacer -->
                        <div class="w-1/2"></div>
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
            class="scroll-mt-44 sm:scroll-mt-40 md:scroll-mt-40 
                                                                                                                                                                                                                    group relative bg-gradient-to-br from-[#1e3a8a]/95 to-[#2563eb]/90 shadow-lg backdrop-blur-md 
                                                                                                                                                                                                                    px-5 py-6 mt-20 sm:mt-22 md:mt-20
                                                                                                                                                                                                                    w-full md:max-w-[67rem] 2xl:max-w-[90rem] mx-auto rounded-none md:rounded-2xl overflow-hidden z-30"
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

                <form method="POST" action="{{ route('user.aduan.store') }}" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-10 px-2 sm:px-6 md:px-10 lg:px-12">
                    @csrf

                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <!-- Input Judul -->
                        <div class="flex flex-col leading-none">
                            <input type="text" name="judul" maxlength="150" placeholder="Judul Aduan"
                                class="w-full border rounded-lg px-4 py-3 md:py-4 bg-white text-gray-900" required>
                            <span id="judulCounter" class="text-sm text-white/90 mt-2 block">0/150</span>
                        </div>
                        @error('judul')
                            <div class="text-white text-sm mt-0">{{ $message }}</div>
                        @enderror

                        <!-- Textarea Isi -->
                        <div class="flex flex-col leading-none">
                            <textarea name="isi" placeholder="Aduan Anda" rows="1" maxlength="1000"
                                class="w-full border rounded-lg px-4 py-3 md:py-4 bg-white text-gray-900"
                                required></textarea>
                            <span id="isiCounter" class="text-sm text-white/90 mt-2 block">0/1000</span>
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

                            <!-- Modal Lokasi -->
                            <div id="locationModal"
                                class="fixed inset-0 z-50 flex items-center justify-center transition-opacity duration-300 ease-in-out hidden bg-black/50">

                                <!-- Konten modal -->
                                <div class="relative z-30 w-full max-w-2xl max-h-[100vh] overflow-y-auto p-6 rounded-2xl border border-white/30 shadow-lg 
                                                                                                                                                            bg-cover bg-center"
                                    style="background-image: url('/images/red.jpg');">

                                    <!-- Overlay gelap dalam modal -->
                                    <div class="absolute inset-0 bg-black/30 rounded-2xl"></div>

                                    <!-- Isi modal -->
                                    <div class="relative z-10">
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

                                        <!-- Grid 2 kolom di desktop, 1 kolom di mobile -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <!-- Input Pencarian Lokasi -->
                                                <div class="mb-4 relative">
                                                    <label for="searchLocation"
                                                        class="block text-sm font-medium text-white mb-1">Cari
                                                        Alamat</label>
                                                    <input type="text" id="searchLocation"
                                                        placeholder="Ketik alamat atau tempat..."
                                                        class="w-full bg-transparent border border-white/40 rounded-lg px-4 py-2 text-white font-semibold placeholder-white focus:outline-none focus:ring-2 focus:ring-white/70 hover:bg-white/10 transition" />

                                                    <ul id="searchSuggestions"
                                                        class="absolute z-50 bg-white text-gray-700 w-full mt-1 rounded-lg shadow-lg overflow-hidden hidden max-h-48 overflow-y-auto">
                                                    </ul>
                                                </div>

                                                <!-- Alamat -->
                                                <div class="mb-4">
                                                    <label for="alamatField"
                                                        class="block text-sm font-medium text-white mb-1">Alamat</label>
                                                    <input type="text" id="alamatField" readonly
                                                        class="w-full bg-transparent border border-white/40 rounded-lg px-4 py-2 text-white font-semibold focus:outline-none focus:ring-2 focus:ring-white/70" />
                                                </div>

                                                <!-- Koordinat -->
                                                <div class="grid grid-cols-2 gap-4 mb-4">
                                                    <div>
                                                        <label for="latitudeField"
                                                            class="block text-sm font-medium text-white mb-1">Lintang</label>
                                                        <input type="text" id="latitudeField" readonly
                                                            class="w-full bg-transparent border border-white/40 rounded-lg px-4 py-2 text-white font-semibold focus:outline-none focus:ring-2 focus:ring-white/70" />
                                                    </div>
                                                    <div>
                                                        <label for="longitudeField"
                                                            class="block text-sm font-medium text-white mb-1">Bujur</label>
                                                        <input type="text" id="longitudeField" readonly
                                                            class="w-full bg-transparent border border-white/40 rounded-lg px-4 py-2 text-white font-semibold focus:outline-none focus:ring-2 focus:ring-white/70" />
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Peta -->
                                            <div>
                                                <div class="text-white/90 text-sm mb-3 flex items-center gap-2">
                                                    <i class="fas fa-info-circle"></i>
                                                    Klik pada peta untuk memilih lokasi.
                                                </div>
                                                <div id="map"
                                                    class="w-full h-80 md:h-full rounded-lg border border-white/40 shadow-inner mb-6 overflow-hidden">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Tombol Aksi -->
                                        <div class="flex justify-end gap-3 mt-14">
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
                            <input type="checkbox" required class="mr-2">
                            Dengan mengisi form ini dan mengirimkan Aduan, Anda telah menyetujui
                            <a href="{{ route('ketentuan.layanan') }}"
                                class="text-blue-300 hover:text-blue-400 hover:underline transition">
                                Ketentuan Layanan
                            </a>
                            dan
                            <a href="{{ route('kebijakan.privasi') }}"
                                class="text-blue-300 hover:text-blue-400 hover:underline transition">
                                Kebijakan Privasi
                            </a> kami.
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
    <!-- Mapbox -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/nprogress/0.2.0/nprogress.min.js"></script>
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

        // ==== DATA MANUAL TAMBAHAN (Fallback) ====
        const manualPlaces = [
            { name: "Diskominfo DIY", address: "Jl. Brigjen Katamso No. 3, Yogyakarta", lat: -7.801389, lon: 110.368056 },
            { name: "Diskominfo Bantul", address: "Jl. Lingkar Timur, Manding, Trirenggo, Bantul", lat: -7.912229, lon: 110.335879 },
            { name: "Diskominfo Sleman", address: "Jl. Parasamya, Beran Lor, Tridadi, Sleman", lat: -7.716879, lon: 110.356150 }
        ];

        // ==== FALLBACK MANUAL ====
        function useManualData() {
            jogjaPlaces = manualPlaces;
            jogjaDataLoaded = true;
            console.warn("Menggunakan data manual (Photon gagal / timeout).");
            console.log("Data manual:", jogjaPlaces);
        }

        // ==== HELPER UNTUK SUSUN ALAMAT ====
        function normalizeJoin(parts) {
            return parts
                .map(x => (x || '').toString().trim())
                .filter(Boolean)
                .filter((v, i, a) => a.indexOf(v) === i) // hapus duplikat
                .join(', ');
        }

        function buildAddress(props) {
            const housenumber = props.housenumber || props.house_number || props.houseno;
            const street = [props.street, housenumber].filter(Boolean).join(' ');

            const locality =
                props.suburb || props.neighbourhood || props.neighborhood ||
                props.quarter || props.hamlet || props.village;

            const cityTown = props.city || props.town || props.municipality || props.county;
            const state = props.state;
            const postcode = props.postcode;
            const country = props.country || (props.countrycode ? props.countrycode.toUpperCase() : '');

            const parts = [street, locality, cityTown, state, postcode, country].filter(Boolean);

            return parts.length > 0 ? normalizeJoin(parts) : null;
        }

        // ==== LOAD DATA DARI PHOTON API ====
        async function loadJogjaData() {
            const cached = localStorage.getItem("jogjaPlaces");
            const cacheTime = Number(localStorage.getItem("jogjaPlaces_time"));
            const oneDay = 24 * 60 * 60 * 1000;

            if (cached && cacheTime && (Date.now() - cacheTime) < oneDay) {
                jogjaPlaces = [...JSON.parse(cached), ...manualPlaces];
                jogjaDataLoaded = true;
                console.log(`Loaded ${jogjaPlaces.length} lokasi dari cache + manual`);
                return;
            }

            // Bounding box DIY (SW lon,lat ; NE lon,lat)
            const bbox = "110.002,-8.223,110.867,-7.565";
            const url = `https://photon.komoot.io/api/?q=*&bbox=${bbox}`;

            const timeoutId = setTimeout(() => {
                console.warn("Timeout — menggunakan data manual");
                useManualData();
            }, 15000);

            try {
                const res = await fetch(url);
                clearTimeout(timeoutId);

                const data = await res.json();
                const unique = [];
                const seenCoord = new Set();
                const seenNameAddr = new Set();

                const diyCounties = [
                    "Sleman", "Bantul", "Gunung Kidul", "Gunungkidul", "Kulon Progo", "Yogyakarta"
                ];

                for (let f of data.features) {
                    const [lon, lat] = f.geometry.coordinates;
                    const props = f.properties;

                    // nama wajib
                    const name = props.name || props.street || props.suburb || props.village;
                    if (!name) continue;

                    // alamat wajib
                    const address = buildAddress(props);
                    if (!address) continue;

                    // filter pastikan masih dalam DIY
                    const state = props.state || "";
                    const county = props.county || "";
                    if (!(state.includes("Yogyakarta") || diyCounties.some(c => county.includes(c)))) continue;

                    // dedup koordinat (≈1.1m)
                    const coordKey = `${lat.toFixed(5)},${lon.toFixed(5)}`;
                    const nameAddrKey = `${name.toLowerCase().trim()}|${address.toLowerCase().trim()}`;

                    if (seenCoord.has(coordKey) || seenNameAddr.has(nameAddrKey)) continue;

                    seenCoord.add(coordKey);
                    seenNameAddr.add(nameAddrKey);

                    unique.push({ name, address, lat, lon });
                }

                jogjaPlaces = [...unique, ...manualPlaces];
                jogjaDataLoaded = true;

                localStorage.setItem("jogjaPlaces", JSON.stringify(unique));
                localStorage.setItem("jogjaPlaces_time", Date.now());

                console.log(`Loaded ${jogjaPlaces.length} lokasi (Photon + manual)`);

            } catch (err) {
                clearTimeout(timeoutId);
                console.error("Gagal ambil data dari Photon:", err);
                useManualData();
            }
        }

        // ==== AUTOCOMPLETE DARI PHOTON + MANUAL (DEDUP NAMA & KOORDINAT) ====
        function setupAutocomplete() {
            const searchInput = document.getElementById('searchLocation');
            const suggestionsBox = document.getElementById('searchSuggestions');

            searchInput.addEventListener('input', debounce(async function () {
                const query = this.value.trim().toLowerCase();
                suggestionsBox.innerHTML = '';

                if (query.length < 2) { // minimal 2 huruf baru search
                    suggestionsBox.classList.add('hidden');
                    return;
                }

                let matches = [];

                try {
                    // bounding box DIY: SW lon,lat ; NE lon,lat
                    const bbox = "110.002,-8.223,110.867,-7.565";
                    const url = `https://photon.komoot.io/api/?q=${encodeURIComponent(query)}&bbox=${bbox}&limit=15`;

                    const res = await fetch(url);
                    const data = await res.json();

                    // hasil Photon
                    matches = data.features.map(f => {
                        const [lon, lat] = f.geometry.coordinates;
                        const props = f.properties;
                        const address = buildAddress(props) || props.name || query;

                        return {
                            name: props.name || props.street || props.suburb || props.village || query,
                            address,
                            lat,
                            lon
                        };
                    });
                } catch (err) {
                    console.warn("Photon error, pakai data manual saja", err);
                }

                // tambahkan data manual
                const manualMatches = manualPlaces.filter(p =>
                    (p.name && p.name.toLowerCase().includes(query)) ||
                    (p.address && p.address.toLowerCase().includes(query))
                );

                // gabungkan Photon + manual
                const combinedRaw = [...matches, ...manualMatches];

                // hapus duplikat (nama & koordinat)
                const seenNames = new Map();
                const seenCoords = new Set();
                const combined = [];

                for (let p of combinedRaw) {
                    const nameKey = p.name.toLowerCase().trim();
                    const coordKey = `${p.lat.toFixed(5)},${p.lon.toFixed(5)}`;

                    if (seenCoords.has(coordKey)) continue;

                    if (seenNames.has(nameKey)) {
                        const existing = seenNames.get(nameKey);
                        if ((p.address || '').length > (existing.address || '').length) {
                            seenNames.set(nameKey, p);
                            const idx = combined.findIndex(x => x.name.toLowerCase().trim() === nameKey);
                            if (idx !== -1) combined[idx] = p;
                        }
                        continue;
                    }

                    seenCoords.add(coordKey);
                    seenNames.set(nameKey, p);
                    combined.push(p);
                }

                if (combined.length === 0) {
                    suggestionsBox.classList.add('hidden');
                    return;
                }

                // tampilkan hasil
                suggestionsBox.innerHTML = '';
                combined.forEach(place => {
                    const li = document.createElement('li');
                    li.innerHTML = `<strong>${place.name}</strong><br><small class="text-gray-500">${place.address}</small>`;
                    li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer';

                    li.addEventListener('click', () => {
                        searchInput.value = place.name;
                        document.getElementById('alamatField').value = place.address || place.name;
                        document.getElementById('latitudeField').value = place.lat.toFixed(6);
                        document.getElementById('longitudeField').value = place.lon.toFixed(6);

                        if (map) {
                            map.flyTo({ center: [place.lon, place.lat], zoom: 15 });
                            if (!marker) {
                                marker = new mapboxgl.Marker({ color: "#e02424" })
                                    .setLngLat([place.lon, place.lat])
                                    .addTo(map);
                            } else {
                                marker.setLngLat([place.lon, place.lat]);
                            }
                        }

                        suggestionsBox.classList.add('hidden');
                    });

                    suggestionsBox.appendChild(li);
                });

                suggestionsBox.classList.remove('hidden');
            }, 400));

            document.addEventListener('click', e => {
                if (!suggestionsBox.contains(e.target) && e.target !== searchInput) {
                    suggestionsBox.classList.add('hidden');
                }
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
                            marker = new mapboxgl.Marker({ color: "#e02424" })
                                .setLngLat([lng, lat])
                                .addTo(map);
                        } else {
                            marker.setLngLat([lng, lat]);
                        }

                        document.getElementById('latitudeField').value = lat.toFixed(6);
                        document.getElementById('longitudeField').value = lng.toFixed(6);

                        // Ambil alamat via Photon reverse
                        fetch(`https://photon.komoot.io/reverse?lat=${lat}&lon=${lng}`)
                            .then(res => res.json())
                            .then(data => {
                                const props = data.features?.[0]?.properties || {};
                                const name = props.name || '';
                                const street = props.street || '';
                                const city = props.city || '';
                                const state = props.state || '';
                                const country = props.country || '';

                                const fullAddress = [name, street, city, state, country].filter(Boolean).join(', ');
                                document.getElementById('alamatField').value = fullAddress;
                            })
                            .catch(err => console.error('Reverse geocoding error:', err));
                    });
                }
            };
        }

        // ==== INISIALISASI ====
        document.addEventListener('DOMContentLoaded', function () {
            AOS.init({ offset: 120, easing: 'ease-out-cubic' });
            loadJogjaData();
            setupMapModal();

            // Lokasi user
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    pos => {
                        const lat = pos.coords.latitude;
                        const lon = pos.coords.longitude;
                        console.log("Lokasi user:", lat, lon);
                        setupAutocomplete(lat, lon, 50);
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
        const judulInput = document.querySelector('[name="judul"]');
        const judulCounter = document.getElementById('judulCounter');
        const isiInput = document.querySelector('[name="isi"]');
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

        const fadeOutAndRemove = el => {
            if (!el) return;
            el.classList.remove('opacity-100');
            el.classList.add('opacity-0');
            setTimeout(() => {
                if (el) el.style.display = 'none';
            }, 500);
        };

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
        window.closeLocationModal = closeLocationModal;
        window.saveLocation = saveLocation;
        window.resetMapToDefault = resetMapToDefault;
        window.closeFileModal = closeFileModal;
        window.closeDeleteModal = closeDeleteModal;
    </script>
@endpush