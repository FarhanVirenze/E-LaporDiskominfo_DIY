@extends('portal.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection

@section('content')
    <div
        class="w-full max-w-full 
                                                                                                                                                                                                                md:max-w-3xl lg:max-w-5xl xl:max-w-6xl 2xl:max-w-screen-2xl 
                                                                                                                                                                                                                mx-auto px-4 sm:px-6 lg:px-8 py-6 mt-20 mb-5">

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

        {{-- Tombol Kembali --}}
        <div class="sticky top-0 bg-white z-10 py-2">
            <a href="{{ route('daftar-aduan') }}"
                class="flex items-center text-red-500 hover:text-red-700 transition-colors duration-200 text-sm">
                <i class="fas fa-arrow-left mr-1"></i> Kembali
            </a>
        </div>

        {{-- Grid Utama: Timeline Kiri & Detail Kanan --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-1">

            {{-- Timeline Aduan (KIRI) --}}
            <div class="md:col-span-1 hidden md:block">
                <div x-data="{ openTimeline: window.innerWidth >= 768 }"
                    x-init="window.addEventListener('resize', () => { openTimeline = window.innerWidth >= 768; });">

                    <h2 class="flex items-center text-lg justify-between gap-2 px-6 py-2 rounded-full 
                                                                                                                                                                                                                                   bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-700 hover:to-rose-600 text-white font-semibold 
                                                                                                                                                                                                                                   shadow-lg hover:shadow-xl transition mb-5 mt-5 cursor-pointer md:cursor-default"
                        @click="if (window.innerWidth < 768) openTimeline = !openTimeline">
                        <span>Timeline Aduan</span>
                        <!-- Icon hanya tampil di mobile -->
                        <span class="md:hidden">
                            <i :class="openTimeline ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                        </span>
                    </h2>

                    <div class="relative border-l-4 border-red-400 ml-3" x-show="openTimeline" x-transition.duration.300ms>
                        @foreach($timeline as $item)
                            <div class="mb-4 ml-6">
                                {{-- Bulatan status --}}
                                <div
                                    class="absolute -left-5 flex items-center justify-center w-8 h-8 rounded-full
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
                                    <span class="text-sm text-gray-600">
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
            </div>

            {{-- Detail Aduan (KANAN) --}}
            <div class="md:col-span-2">
                {{-- Card Utama --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden mt-4 p-4 sm:p-6 md:p-8">

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
                                    {{-- Like --}}
                                    <form action="{{ route('report.like', $report->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center text-sm transition-all duration-200
                                                                                                                                                                                                                                                                                                                                                                    {{ $report->likedBy(auth()->id()) ? 'text-blue-600 font-bold' : 'text-gray-400 hover:text-blue-500' }}">
                                            <i class="fas fa-thumbs-up mr-1"></i> {{ $report->likes }}
                                        </button>
                                    </form>

                                    {{-- Dislike --}}
                                    <form action="{{ route('report.dislike', $report->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center text-sm transition-all duration-200
                                                                                                                                                                                                                                                                                                                                                                    {{ $report->dislikedBy(auth()->id()) ? 'text-red-600 font-bold' : 'text-gray-400 hover:text-red-500' }}">
                                            <i class="fas fa-thumbs-down mr-1"></i> {{ $report->dislikes }}
                                        </button>
                                    </form>
                                @else
                                    <div class="flex items-center gap-5 text-sm"
                                        x-data="{ showLike: false, showDislike: false }">
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
                                        <div class="relative" @mouseenter="showDislike = true"
                                            @mouseleave="showDislike = false">
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
                            class="w-full h-64 md:h-80 lg:h-96 object-cover transition duration-300 group-hover:brightness-75 rounded-t-2xl">

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

                        <div class="grid grid-cols-1 lg:grid-cols-2">
                            <!-- Pelapor -->
                            <div class="flex items-start gap-3 mb-3">
                                <!-- Avatar User -->
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl bg-gray-100"
                                    :class="{ 'bg-blue-50 text-blue-700 shadow-sm': open }">

                                    @if ($report->is_anonim)
                                        {{-- Anonim -> pakai avatar default --}}
                                        <img src="{{ asset('images/avatar.jpg') }}" alt="Anonim"
                                            class="h-8 w-8 rounded-full object-cover bg-white shadow" />
                                    @else
                                        <img src="{{ $report->pelapor && $report->pelapor->foto
                                                                                                                                                                                                                                                                                                                                                                                            ? asset('storage/' . $report->pelapor->foto)  {{-- Prioritas: foto upload --}}
                                                                                                                                                                                                                                                                                                                                                                                            : ($report->pelapor && $report->pelapor->avatar
                                                                                                                                                                                                                                                                                                                                                                                                ? $report->pelapor->avatar                {{-- Kedua: avatar Google --}}
                                                                                                                                                                                                                                                                                                                                                                                                : asset('images/avatar.jpg')) }}"
                                            {{-- Fallback default --}} alt="Avatar {{ $report->nama_pengadu }}"
                                            class="h-8 w-8 rounded-full object-cover bg-white shadow" />
                                    @endif
                                </div>

                                <!-- Content -->
                                <div>
                                    <div class="text-gray-600 text-sm font-semibold">Pelapor</div>
                                    <div class="flex items-center flex-wrap gap-2">
                                        <span class="text-gray-600 text-sm">
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
                                        <span
                                            class="px-2 py-0.5 border border-red-500 text-red-500 rounded-full text-xs font-medium">
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
                                    <div class="text-gray-600 text-sm">
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
                                    <div class="text-gray-600 text-sm">{{ $report->wilayah->nama }}</div>
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                border border-transparent bg-gradient-to-r from-red-500 to-rose-500 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                text-white shadow-md hover:shadow-lg">
                                                {{ $report->admin->name }}
                                            </span>
                                        @else
                                            <span class="italic text-gray-500 text-sm">Belum didisposisikan</span>
                                        @endif
                                    </div>
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

                        {{-- Timeline Aduan (hanya muncul di mobile) --}}
                        <div x-data="{ openTimeline: false }" class="md:hidden">
                            <h2 class="flex items-center text-lg justify-between gap-2 px-6 py-2 rounded-full 
                                                                                                                                                                                                                           bg-gradient-to-r from-red-500 to-rose-500 hover:from-red-700 hover:to-rose-600 text-white font-semibold 
                                                                                                                                                                                                                           shadow-lg hover:shadow-xl transition mb-5 mt-5 cursor-pointer"
                                @click="openTimeline = !openTimeline">
                                <span>Timeline Aduan</span>
                                <!-- Icon toggle -->
                                <span>
                                    <i :class="openTimeline ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
                                </span>
                            </h2>

                            <div class="relative border-l-4 border-red-400 ml-3" x-show="openTimeline"
                                x-transition.duration.300ms>
                                @foreach($timeline as $item)
                                    <div class="mb-4 ml-6">
                                        {{-- Bulatan status --}}
                                        <div
                                            class="absolute -left-5 flex items-center justify-center w-8 h-8 rounded-full
                                                                                                                                                                                                                                                                                                            @if($item['type'] === 'created') bg-red-500 text-white
                                                                                                                                                                                                                                                                                                            @elseif($item['type'] === 'assigned') bg-orange-500 text-white
                                                                                                                                                                                                                                                                                                            @elseif($item['type'] === 'reassigned') bg-amber-500 text-white
                                                                                                                                                                                                                                                                                                            @elseif($item['type'] === 'read') bg-blue-500 text-white
                                                                                                                                                                                                                                                                                                            @elseif($item['type'] === 'followup') bg-purple-500 text-white
                                                                                                                                                                                                                                                                                                            @elseif($item['type'] === 'comment') bg-yellow-500 text-white
                                                                                                                                                                                                                                                                                                            @elseif($item['type'] === 'done') bg-green-500 text-white
                                                                                                                                                                                                                                                                                                            @else bg-gray-400 text-white @endif">

                                            @if($item['type'] === 'created')
                                                <i class="fas fa-edit"></i>
                                            @elseif($item['type'] === 'assigned')
                                                <i class="fas fa-share-square"></i>
                                            @elseif($item['type'] === 'reassigned')
                                                <i class="fas fa-random"></i>
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
                                            <span class="text-sm text-gray-600">
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

                        <div class="border-b px-1 pt-2 md:pt-5 flex space-x-8 text-sm font-semibold text-gray-600">
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
                                    <button type="button"
                                        class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400"
                                        onclick="closeDeleteModal()">Batal</button>
                                </form>
                            </div>
                        </div>

                        {{-- Tab Konten --}}
                        <div class="p-2">
                            {{-- Tindak Lanjut --}}
                            <div class="tab-pane opacity-100 translate-y-0 transition-all duration-300" data-tab="tindak">
                                <div class="max-h-96 overflow-y-auto pr-2 space-y-4">
                                    @forelse ($followUps as $item)
                                        <div
                                            class="relative group bg-gray-50 rounded-md p-7 border shadow-sm flex gap-3 items-start">

                                            {{-- Avatar User --}}
                                            <div class="flex items-center justify-center mt-4 rounded-xl">
                                                @if ($item->user && $item->user->is_anonim)
                                                    <img src="{{ asset('images/avatar.jpg') }}" alt="Anonim"
                                                        class="h-8 w-8 rounded-full object-cover bg-white shadow" />
                                                @else
                                                                                <img src="{{ $item->user && $item->user->foto
                                                    ? asset('storage/' . $item->user->foto)
                                                    : ($item->user && $item->user->avatar
                                                        ? $item->user->avatar
                                                        : asset('images/avatar.jpg')) }}"
                                                                                    alt="Avatar {{ $item->user->name ?? $item->nama_pengadu }}"
                                                                                    class="h-8 w-8 rounded-full object-cover bg-white shadow" />
                                                @endif
                                            </div>

                                            {{-- Konten tindak lanjut --}}
                                            <div class="flex-1 space-y-2">

                                                {{-- Tombol Rating & Lihat Detail --}}
                                                <div class="flex items-center gap-2">
                                                    @php
                                                        $isGuest = !auth()->check();
                                                        $userRating = !$isGuest ? $item->ratings->where('user_id', auth()->id())->first() : null;
                                                    @endphp

                                                    {{-- Tombol Nilai / Edit --}}
                                                    @if ($isGuest)
                                                        <button
                                                            class="relative flex items-center gap-1 px-2 py-1 text-xs rounded bg-gray-400 text-white cursor-not-allowed">
                                                            <i class="fas fa-star"></i> Nilai
                                                            {{-- Tooltip login dulu --}}
                                                            <span
                                                                class="absolute -top-7 left-1/2 -translate-x-1/2 
                                                                    px-2 py-1 text-[10px] rounded bg-gray-800 text-white 
                                                                    whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                                Silakan login dulu
                                                                <span class="absolute left-1/2 -bottom-[3px] -translate-x-1/2 
                                                                        w-0 h-0 border-l-[4px] border-r-[4px] border-t-[4px] 
                                                                        border-transparent border-t-gray-800"></span>
                                                            </span>
                                                        </button>
                                                    @else
                                                        @if ($userRating)
                                                            <div class="flex gap-2">
                                                                {{-- Tombol Edit --}}
                                                                <button
                                                                    onclick="openRatingModal({{ $item->id }}, true, {{ $userRating->rating }}, '{{ $userRating->komentar }}')"
                                                                    class="flex items-center gap-1 px-2 py-1 text-xs rounded bg-blue-600 text-white hover:bg-blue-700">
                                                                    <i class="fas fa-edit"></i> Edit
                                                                </button>

                                                                {{-- Tombol Hapus --}}
                                                                <form action="{{ route('user.followups.rating.delete', $item->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Yakin ingin menghapus rating ini?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="flex items-center gap-1 px-2 py-1 text-xs rounded bg-red-600 text-white hover:bg-red-700">
                                                                        <i class="fas fa-trash"></i> Hapus
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        @else
                                                            <button onclick="openRatingModal({{ $item->id }})"
                                                                class="flex items-center gap-1 px-2 py-1 text-xs rounded bg-blue-600 text-white hover:bg-blue-700">
                                                                <i class="fas fa-star"></i> Nilai
                                                            </button>
                                                        @endif
                                                    @endif

                                                    {{-- Rating Bintang --}}
                                                    @php
                                                        $avg = round($item->ratings_avg_rating ?? 0, 1);
                                                        $count = $item->ratings_count ?? 0;

                                                        $fullStars = floor($avg);
                                                        $halfStar = ($avg - $fullStars) >= 0.5 ? 1 : 0;
                                                        $emptyStars = 5 - ($fullStars + $halfStar);
                                                    @endphp

                                                    @if ($isGuest)
                                                        <button
                                                            class="relative flex items-center gap-1 group cursor-not-allowed text-gray-400">
                                                            <div class="flex items-center gap-0.5">
                                                                @for ($i = 0; $i < 5; $i++)
                                                                    <i class="far fa-star text-sm text-gray-300"></i>
                                                                @endfor
                                                                <span class="ml-1 text-xs text-gray-400">({{ $count }})
                                                                    ulasan</span>
                                                            </div>
                                                            {{-- Tooltip login dulu --}}
                                                            <span
                                                                class="absolute -top-7 left-1/2 -translate-x-1/2 
                                                                    px-2 py-1 text-[10px] rounded bg-gray-800 text-white 
                                                                    whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                                Silakan login dulu
                                                                <span class="absolute left-1/2 -bottom-[3px] -translate-x-1/2 
                                                                        w-0 h-0 border-l-[4px] border-r-[4px] border-t-[4px] 
                                                                        border-transparent border-t-gray-800"></span>
                                                            </span>
                                                        </button>
                                                    @else
                                                        <button onclick="openRatingDetailModal({{ $item->id }})"
                                                            class="relative flex items-center gap-1 group">

                                                            <div class="flex items-center gap-0.5">
                                                                {{-- Bintang penuh --}}
                                                                @for ($i = 0; $i < $fullStars; $i++)
                                                                    <i class="fas fa-star text-sm text-yellow-400"></i>
                                                                @endfor

                                                                {{-- Bintang setengah --}}
                                                                @if ($halfStar)
                                                                    <i class="fas fa-star-half-alt text-sm text-yellow-400"></i>
                                                                @endif

                                                                {{-- Bintang kosong --}}
                                                                @for ($i = 0; $i < $emptyStars; $i++)
                                                                    <i class="far fa-star text-sm text-gray-300"></i>
                                                                @endfor

                                                                <span class="ml-1 text-xs text-gray-600">({{ $count }})
                                                                    ulasan</span>
                                                            </div>

                                                            <!-- Custom Tooltip -->
                                                            <span class="absolute -top-7 left-1/2 -translate-x-[90%] 
                                                                    px-1 py-[2px] text-[9px] rounded bg-gray-800 text-white 
                                                                    whitespace-nowrap opacity-0 group-hover:opacity-100 
                                                                    transition-opacity duration-300">
                                                                Lihat selengkapnya
                                                                <span class="absolute left-1/2 -bottom-[3px] -translate-x-1/2 
                                                                        w-0 h-0 border-l-[2.5px] border-r-[2.5px] border-t-[2.5px] 
                                                                        border-transparent border-t-gray-800"></span>
                                                            </span>
                                                        </button>
                                                    @endif


                                                </div>

                                                {{-- Meta info --}}
                                                <div class="flex items-center gap-3 text-xs text-gray-500">
                                                    <span>{{ $item->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                                                </div>

                                                {{-- Isi pesan tindak lanjut --}}
                                                <p class="text-sm text-gray-700 leading-relaxed">
                                                    {{ Str::limit($item->pesan, 200) }}
                                                </p>
                                            </div>

                                            {{-- Lampiran File --}}
                                            @if ($item->file)
                                                @php
                                                    $filePath = asset('storage/' . $item->file);
                                                    $fileExtension = pathinfo($item->file, PATHINFO_EXTENSION);
                                                @endphp

                                                @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ $filePath }}"
                                                        class="w-32 h-auto rounded shadow mt-2 cursor-pointer hover:opacity-80 transition-opacity"
                                                        onclick="openModal('{{ $filePath }}')" alt="Lampiran Tindak Lanjut">
                                                @elseif ($fileExtension === 'pdf')
                                                    <a href="{{ $filePath }}" target="_blank"
                                                        class="flex items-center gap-2 text-red-600 hover:bg-red-100 hover:text-red-700 p-2 rounded mt-2">
                                                        <i class="fas fa-file-pdf"></i> PDF File
                                                    </a>
                                                @elseif (in_array(strtolower($fileExtension), ['doc', 'docx']))
                                                    <a href="{{ $filePath }}" target="_blank"
                                                        class="flex items-center gap-2 text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded mt-2">
                                                        <i class="fas fa-file-word"></i> Word Document
                                                    </a>
                                                @elseif ($fileExtension === 'zip')
                                                    <a href="{{ $filePath }}" target="_blank"
                                                        class="flex items-center gap-2 text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 p-2 rounded mt-2">
                                                        <i class="fas fa-file-archive"></i> ZIP Archive
                                                    </a>
                                                @elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx']))
                                                    <a href="{{ $filePath }}" target="_blank"
                                                        class="flex items-center gap-2 text-green-600 hover:bg-green-100 hover:text-green-700 p-2 rounded mt-2">
                                                        <i class="fas fa-file-excel"></i> Excel File
                                                    </a>
                                                @else
                                                    <a href="{{ $filePath }}" target="_blank"
                                                        class="flex items-center gap-2 text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded mt-2">
                                                        <i class="fas fa-file"></i> Lihat File
                                                    </a>
                                                @endif
                                            @endif
                                        </div>

                                        {{-- Tombol hapus tindak lanjut --}}
                                        @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                            <button
                                                onclick="openDeleteModal('{{ route('reports.followup.delete', [$report->id, $item->id]) }}')"
                                                class="absolute top-2 right-2 text-red-600 text-xs hover:text-red-800 border border-red-600 rounded-full p-1 z-10">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        @endif
                                    @empty
                                        <p class="mt-4 text-gray-500">Belum ada tindak lanjut.</p>
                                    @endforelse
                                </div>

                                {{-- Form tambah tindak lanjut --}}
                                @if (auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']))
                                    <form action="{{ route('reports.followup', ['id' => $report->id]) }}" method="POST"
                                        enctype="multipart/form-data" class="mt-4 space-y-4">
                                        @csrf
                                        <textarea name="pesan" class="w-full border rounded p-2" rows="4"
                                            placeholder="Tindak lanjut..." required></textarea>
                                        <input type="file" name="file" class="block w-full border rounded p-1">
                                        <button type="submit"
                                            class="flex items-center gap-3 px-6 py-3 rounded-full bg-gradient-to-r from-red-500 to-rose-500 text-white font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition group">
                                            <i class="fas fa-paper-plane text-white"></i>
                                            <span>Kirim Tindak Lanjut</span>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        <!-- Modal Detail Rating -->
                        <div id="ratingDetailModal"
                            class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                                <h3 class="text-lg font-semibold mb-4">Detail Rating Tindak Lanjut</h3>

                                {{-- Rata-rata --}}
                                <div class="text-center mb-6">
                                    <div class="text-4xl font-bold">{{ number_format($averageRating, 1) }}</div>
                                    <div class="flex justify-center text-yellow-400">
                                        @php
                                            $fullStars = floor($averageRating);
                                            $halfStar = ($averageRating - $fullStars) >= 0.5;
                                            $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                                        @endphp

                                        {{-- Full Stars --}}
                                        @for ($i = 1; $i <= $fullStars; $i++)
                                            <i class="fas fa-star text-yellow-400"></i>
                                        @endfor

                                        {{-- Half Star --}}
                                        @if ($halfStar)
                                            <i class="fas fa-star-half-alt text-yellow-400"></i>
                                        @endif

                                        {{-- Empty Stars --}}
                                        @for ($i = 1; $i <= $emptyStars; $i++)
                                            <i class="far fa-star text-gray-300"></i>
                                        @endfor
                                    </div>
                                    <p class="text-gray-500">{{ $totalReviews }} reviews</p>
                                </div>


                                {{-- Breakdown --}}
                                <div class="space-y-2 mb-6">
                                    @foreach($ratingStats as $star => $count)
                                        @php
                                            $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                                        @endphp
                                        <div class="flex items-center gap-2">
                                            <span class="w-6 text-sm">{{ $star }}★</span>
                                            <div class="w-full bg-gray-200 rounded h-3">
                                                <div class="bg-blue-500 h-3 rounded" style="width: {{ $percentage }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-600">{{ $count }} Reviews</span>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- Daftar Review --}}
                                <div class="space-y -4">
                                    <h4 class="font-semibold">Daftar Penilaian:</h4>
                                    @forelse($ratings as $r)
                                        <div class="border p-3 rounded-md">
                                            <div class="flex justify-between items-center">
                                                <span class="font-semibold">{{ $r->user->name ?? 'Anonim' }}</span>
                                                <span class="text-xs text-gray-500">{{ $r->created_at->diffForHumans() }}</span>
                                            </div>
                                            <div class="flex text-yellow-400">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i
                                                        class="fas fa-star {{ $i <= $r->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                            <p class="text-gray-600 text-sm italic">
                                                {{ $r->komentar ?: 'Tidak ada komentar.' }}
                                            </p>
                                        </div>
                                    @empty
                                        <p class="text-gray-500">Belum ada penilaian.</p>
                                    @endforelse
                                </div>

                                <div class="flex justify-end mt-6">
                                    <button onclick="closeRatingDetailModal()"
                                        class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Rating -->
                        <div id="ratingModal"
                            class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
                            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md">
                                <h3 class="text-lg font-semibold mb-4">Beri Rating Tindak Lanjut</h3>

                                <!-- Form -->
                                <form id="ratingForm" method="POST">
                                    @csrf
                                    <div id="starContainer" class="flex justify-center gap-1 mb-4 cursor-pointer">
                                        <!-- 5 Bintang -->
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg data-value="{{ $i }}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor"
                                                class="star w-10 h-10 text-gray-300 transition-colors duration-200">
                                                <path fill-rule="evenodd"
                                                    d="M12 17.27l5.18 3.73-1.64-6.81 5.46-4.73-7.19-.61L12 2 10.19 8.85l-7.19.61 5.46 4.73-1.64 6.81L12 17.27z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        @endfor
                                    </div>

                                    <!-- Hidden input untuk simpan nilai rating -->
                                    <input type="hidden" name="rating" id="ratingValue">

                                    <textarea name="komentar" rows="3" placeholder="Tulis komentar (opsional)"
                                        class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-300"></textarea>

                                    <div class="flex justify-end gap-2 mt-4">
                                        <button type="button" onclick="closeRatingModal()"
                                            class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300">Batal</button>
                                        <button type="submit"
                                            class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">Kirim</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            const stars = document.querySelectorAll("#starContainer .star");
                            const ratingValue = document.getElementById("ratingValue");
                            let selectedRating = 0;

                            stars.forEach(star => {
                                star.addEventListener("mouseover", function () {
                                    const val = this.getAttribute("data-value");
                                    highlightStars(val);
                                });

                                star.addEventListener("mouseout", function () {
                                    highlightStars(selectedRating); // kembali ke pilihan terakhir
                                });

                                star.addEventListener("click", function () {
                                    selectedRating = this.getAttribute("data-value");
                                    ratingValue.value = selectedRating;
                                    highlightStars(selectedRating);
                                });
                            });

                            function highlightStars(count) {
                                stars.forEach(star => {
                                    if (star.getAttribute("data-value") <= count) {
                                        star.classList.remove("text-gray-300");
                                        star.classList.add("text-yellow-400");
                                    } else {
                                        star.classList.remove("text-yellow-400");
                                        star.classList.add("text-gray-300");
                                    }
                                });
                            }
                            function openRatingModal(followupId, isEdit = false, rating = 0, komentar = '') {
                                let url;
                                if (isEdit) {
                                    url = "{{ route('user.followups.rating.update', ['followupId' => '__id__']) }}";
                                } else {
                                    url = "{{ route('user.followups.rating.store', ['followupId' => '__id__']) }}";
                                }
                                url = url.replace('__id__', followupId);

                                document.getElementById('ratingForm').action = url;

                                // Prefill rating kalau edit
                                if (isEdit) {
                                    selectedRating = rating;
                                    ratingValue.value = rating;
                                    highlightStars(rating);
                                    document.querySelector('#ratingForm textarea[name="komentar"]').value = komentar;
                                } else {
                                    selectedRating = 0;
                                    ratingValue.value = '';
                                    highlightStars(0);
                                    document.querySelector('#ratingForm textarea[name="komentar"]').value = '';
                                }

                                document.getElementById('ratingModal').classList.remove('hidden');
                            }

                            function closeRatingModal() {
                                document.getElementById('ratingModal').classList.add('hidden');
                            }

                            function openRatingDetailModal(followupId) {
                                // Bisa pakai AJAX kalau mau ambil rating per followup
                                document.getElementById('ratingDetailModal').classList.remove('hidden');
                            }

                            function closeRatingDetailModal() {
                                document.getElementById('ratingDetailModal').classList.add('hidden');
                            }
                        </script>

                        {{-- Komentar --}}
                        <div class="tab-pane opacity-0 translate-y-4 transition-all duration-300 hidden"
                            data-tab="komentar">
                            <div class="max-h-96 overflow-y-auto pr-2">
                                @forelse ($comments as $item)
                                    <div class="relative group mb-4 bg-gray-50 rounded-md p-3 border shadow-sm flex gap-3">

                                        {{-- Avatar User --}}
                                        <div class="flex items-center justify-center rounded-xl">
                                            @if ($item->user && $item->user->is_anonim)
                                                {{-- Anonim -> pakai avatar default --}}
                                                <img src="{{ asset('images/avatar.jpg') }}" alt="Anonim"
                                                    class="h-8 w-8 rounded-full object-cover bg-white shadow" />
                                            @else
                                                <img src="{{ $item->user && $item->user->foto
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    ? asset('storage/' . $item->user->foto)   {{-- Prioritas: foto upload --}}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    : ($item->user && $item->user->avatar
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ? $item->user->avatar                 {{-- Kedua: avatar Google --}}
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        : asset('images/avatar.jpg')) }}"
                                                    {{-- Fallback default --}}
                                                    alt="Avatar {{ $item->user->name ?? $item->nama_pengadu }}"
                                                    class="h-8 w-8 rounded-full object-cover bg-white shadow" />
                                            @endif
                                        </div>

                                        {{-- Isi Komentar --}}
                                        <div class="flex-1">
                                            <div
                                                class="flex flex-col md:flex-row md:items-center md:gap-2 text-xs text-gray-600">
                                                <strong>{{ $item->user->name ?? $item->nama_pengadu }}</strong>
                                                <span class="text-gray-500">
                                                    ({{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }})
                                                </span>
                                            </div>
                                            <p class="text-gray-800 mb-2">{{ $item->pesan }}</p>

                                            {{-- Lampiran File --}}
                                            @if ($item->file)
                                                @php
                                                    $filePath = asset('storage/' . $item->file);
                                                    $fileExtension = pathinfo($item->file, PATHINFO_EXTENSION);
                                                @endphp

                                                @if (in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif']))
                                                    <img src="{{ $filePath }}"
                                                        class="w-32 h-auto rounded shadow cursor-pointer hover:opacity-80 transition-opacity"
                                                        onclick="openModal('{{ $filePath }}')" alt="Lampiran Komentar">
                                                @elseif ($fileExtension === 'pdf')
                                                    <a href="{{ $filePath }}"
                                                        class="text-red-600 hover:bg-red-100 hover:text-red-700 p-2 rounded transition-all flex items-center"
                                                        target="_blank">
                                                        <i class="fas fa-file-pdf mr-2"></i> PDF File
                                                    </a>
                                                @elseif (in_array(strtolower($fileExtension), ['doc', 'docx']))
                                                    <a href="{{ $filePath }}"
                                                        class="text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded transition-all flex items-center"
                                                        target="_blank">
                                                        <i class="fas fa-file-word mr-2"></i> Word Document
                                                    </a>
                                                @elseif ($fileExtension === 'zip')
                                                    <a href="{{ $filePath }}"
                                                        class="text-yellow-600 hover:bg-yellow-100 hover:text-yellow-700 p-2 rounded transition-all flex items-center"
                                                        target="_blank">
                                                        <i class="fas fa-file-archive mr-2"></i> ZIP Archive
                                                    </a>
                                                @elseif (in_array(strtolower($fileExtension), ['xls', 'xlsx']))
                                                    <a href="{{ $filePath }}"
                                                        class="text-green-600 hover:bg-green-100 hover:text-green-700 p-2 rounded transition-all flex items-center"
                                                        target="_blank">
                                                        <i class="fas fa-file-excel mr-2"></i> Excel File
                                                    </a>
                                                @else
                                                    <a href="{{ $filePath }}"
                                                        class="text-blue-600 hover:bg-blue-100 hover:text-blue-700 p-2 rounded transition-all flex items-center"
                                                        target="_blank">
                                                        <i class="fas fa-file mr-2"></i> Lihat File
                                                    </a>
                                                @endif
                                            @endif
                                        </div>

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

                            {{-- Form Tambah Komentar --}}
                            @if (auth()->check() && in_array(auth()->user()->role, ['user', 'admin', 'superadmin']))
                                <form action="{{ route('reports.comment', ['id' => $report->id]) }}" method="POST"
                                    enctype="multipart/form-data" class="mt-2 space-y-4">
                                    @csrf
                                    <textarea name="pesan" class="w-full border rounded p-2" rows="4"
                                        placeholder="Tulis komentar..." required></textarea>
                                    <input type="file" name="file" class="block w-full border rounded p-1">
                                    <button type="submit"
                                        class="flex items-center gap-3 px-6 py-3 rounded-full bg-gradient-to-r from-red-500 to-rose-500 text-white font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition group">
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
                        <div class="tab-pane opacity-0 translate-y-4 transition-all duration-300 hidden"
                            data-tab="lampiran">
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
                                <p class="text-sm text-gray-700 mt-4 mb-2"><strong>Alamat:</strong> {{ $report->lokasi }}
                                </p>
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
    <!-- Mapbox CSS & JS -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.1/mapbox-gl-geocoder.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Tampilkan tab default
            showTab('tindak');

            const lat = {{ $report->latitude ?? 0 }};
            const lng = {{ $report->longitude ?? 0 }};
            const mapElement = document.getElementById('map');

            if (lat && lng) {
                // ==== GLOBAL KONFIGURASI PETA ====
                mapboxgl.accessToken = "pk.eyJ1IjoiZmFkaWxhaDI0OCIsImEiOiJja3dnZXdmMnQwbno1MnRxcXYwdjB3cG9qIn0.v4gAtavpn1GzgtD7f3qapA";

                // Inisialisasi peta
                const map = new mapboxgl.Map({
                    container: mapElement,
                    style: "mapbox://styles/mapbox/streets-v12", // bisa diganti "satellite-v9" dll
                    center: [lng, lat],
                    zoom: 17
                });

                // Tambahkan kontrol navigasi (zoom & rotate)
                map.addControl(new mapboxgl.NavigationControl());

                // Tambahkan marker di lokasi
                new mapboxgl.Marker({ color: "red" })
                    .setLngLat([lng, lat])
                    .setPopup(new mapboxgl.Popup().setHTML(`<b>{{ $report->lokasi }}</b>`)) // popup alamat
                    .addTo(map);

                // Fungsi untuk resize map
                function resizeMap() {
                    map.resize();
                }

                // Resize saat halaman selesai load
                window.addEventListener('load', () => {
                    setTimeout(resizeMap, 500);
                });

                // Resize saat layar berubah ukuran
                window.addEventListener('resize', () => {
                    setTimeout(resizeMap, 200);
                });

                // Resize saat tab lokasi diklik
                const tabLokasi = document.getElementById('tab-lokasi');
                if (tabLokasi) {
                    tabLokasi.addEventListener('click', () => {
                        setTimeout(resizeMap, 300);
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
            activeBtn.classList.remove('text-blue-600', 'border-transparent');
            activeBtn.classList.add('border-blue-600', 'text-blue-600');

            const activePane = document.querySelector(`.tab-pane[data-tab="${tab}"]`);
            activePane.classList.remove('hidden');
            void activePane.offsetWidth;
            activePane.classList.add('opacity-100', 'translate-y-0');
            activePane.classList.remove('opacity-0', 'translate-y-4');
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