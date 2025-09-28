@extends('portal.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection

@section('content')

    <div class="font-bold text-gray-800 mb-5 mt-20">
        {{-- Accordion Header --}}
        <button type="button" class="flex justify-between items-center w-full px-6 py-4 bg-gradient-to-r from-red-600 to-rose-500 text-white font-semibold text-xl shadow-lg hover:from-red-700 hover:to-rose-600
                                                                       lg:cursor-default lg:pointer-events-none"
            onclick="toggleFilterAccordion()" aria-expanded="false" aria-controls="filterAccordionContent"
            id="filterAccordionButton">
            <span class="flex items-center gap-3">
                <i class="fas fa-sliders-h"></i>
                Filter Aduan
            </span>
            <svg id="accordion-icon" class="w-5 h-5 transition-transform duration-300 lg:hidden" fill="none"
                stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        {{-- Accordion Content --}}
        <div id="filterAccordionContent" class="max-h-0 overflow-hidden transition-all duration-500 ease-in-out
                                                                   lg:max-h-[1000px] lg:overflow-visible">
            <div class="relative overflow-hidden w-full"
                style="background-image: url('/images/red.jpg'); background-size: cover; background-position: center;">
                {{-- Overlay Gelap 30% --}}
                <div class="absolute inset-0 bg-black/10 z-20"></div>

                {{-- Konten Form --}}
                <form method="GET" action="{{ route('daftar-aduan') }}"
                    class="relative z-30 p-8 md:p-12 grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-7 gap-8 items-center shadow-lg">

                    {{-- Status --}}
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-white text-sm sm:text-xs flex items-center h-full">
                            <i class="fas fa-tasks"></i>
                        </span>
                        <select name="status"
                            class="w-full pl-10 pr-10 py-3 rounded-xl border border-white text-white bg-transparent font-semibold text-sm sm:text-xs shadow-lg focus:outline-none focus:ring-2 focus:ring-white/50 transition appearance-none bg-no-repeat bg-[length:1rem] bg-[right_0.75rem_center]"
                            style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'white\' xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' width=\'20\' height=\'20\'><path d=\'M7 10l5 5 5-5z\'/></svg>');">
                            <option value="" class="text-gray-800" {{ request('status') == '' ? 'selected' : '' }}>Status
                            </option>
                            <option value="Diajukan" class="text-gray-800" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="Dibaca" class="text-gray-800" {{ request('status') == 'Dibaca' ? 'selected' : '' }}>Dibaca</option>
                            <option value="Direspon" class="text-gray-800" {{ request('status') == 'Direspon' ? 'selected' : '' }}>Direspon</option>
                            <option value="Selesai" class="text-gray-800" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    {{-- Kategori --}}
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-white text-sm sm:text-xs flex items-center h-full">
                            <i class="fas fa-tags"></i>
                        </span>
                        <select name="kategori"
                            class="w-full pl-10 pr-10 py-3 rounded-xl border border-white text-white bg-transparent font-semibold text-sm sm:text-xs
                                                                                                           placeholder-gray-200 shadow-lg focus:outline-none focus:ring-2 focus:ring-white/50 transition appearance-none
                                                                                                           bg-no-repeat bg-[right_0.75rem_center] bg-[length:1rem]"
                            style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'white\' xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' width=\'20\' height=\'20\'><path d=\'M7 10l5 5 5-5z\'/></svg>');">
                            <option value="" class="bg-white text-gray-800">Kategori</option>
                            @foreach ($kategoriList as $kategori)
                                <option value="{{ $kategori->id }}" class="bg-white text-gray-800" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Wilayah --}}
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-white text-sm sm:text-xs flex items-center h-full">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                        <select name="wilayah"
                            class="w-full pl-10 pr-10 py-3 rounded-xl border border-white text-white bg-transparent font-semibold text-sm sm:text-xs
                                                                                                       placeholder-gray-200 shadow-lg focus:outline-none focus:ring-2 focus:ring-white/50 transition appearance-none
                                                                                                       bg-no-repeat bg-[right_0.75rem_center] bg-[length:1rem]"
                            style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'white\' xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' width=\'20\' height=\'20\'><path d=\'M7 10l5 5 5-5z\'/></svg>');">
                            <option value="" class="bg-white text-gray-800">Wilayah</option>
                            @foreach ($wilayahList as $wilayah)
                                <option value="{{ $wilayah->id }}" class="bg-white text-gray-800" {{ request('wilayah') == $wilayah->id ? 'selected' : '' }}>
                                    {{ $wilayah->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Urutkan --}}
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-white text-sm sm:text-xs flex items-center h-full">
                            <i class="fas fa-sort"></i>
                        </span>
                        <select name="sort"
                            class="w-full pl-10 pr-10 py-3 rounded-xl border border-white text-white bg-transparent font-semibold text-sm sm:text-xs
                                                                                                   placeholder-gray-200 shadow-lg focus:outline-none focus:ring-2 focus:ring-white/50 transition appearance-none
                                                                                                   bg-no-repeat bg-[right_0.75rem_center] bg-[length:1rem]"
                            style="background-image: url('data:image/svg+xml;utf8,<svg fill=\'white\' xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' width=\'20\' height=\'20\'><path d=\'M7 10l5 5 5-5z\'/></svg>');">
                            <option value="" class="bg-white text-gray-800">Urutkan</option>
                            <option value="terbaru" class="bg-white text-gray-800" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="terlama" class="bg-white text-gray-800" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                            <option value="likes" class="bg-white text-gray-800" {{ request('sort') == 'likes' ? 'selected' : '' }}>Paling Disukai</option>
                            <option value="views" class="bg-white text-gray-800" {{ request('sort') == 'views' ? 'selected' : '' }}>Paling Banyak Dilihat</option>
                        </select>
                    </div>

                    {{-- Tanggal --}}
                    <div class="relative flex items-center">
                        <span class="absolute left-3 text-white text-sm sm:text-xs flex items-center h-full">
                            <i class="fas fa-calendar-alt"></i>
                        </span>
                        <input type="text" id="tanggal" name="tanggal" placeholder="Tanggal"
                            value="{{ request('tanggal') }}" class="w-full pl-10 pr-3 py-3 rounded-xl border border-white text-white bg-transparent font-semibold text-sm sm:text-xs
                   placeholder-white shadow-lg focus:outline-none focus:ring-2 focus:ring-white/50 transition">
                    </div>

                    {{-- Tombol --}}
                    <div
                        class="flex items-center gap-3 col-span-1 sm:col-span-3 lg:col-span-2 justify-center lg:justify-center">
                        <button type="submit"
                            class="flex items-center gap-2 px-6 py-3 rounded-full bg-gradient-to-r from-red-600 to-rose-500 text-white font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition leading-none">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <a href="{{ route('daftar-aduan') }}"
                            class="flex items-center gap-2 px-6 py-3 rounded-full bg-white/10 border border-white/30 text-white font-semibold shadow-lg hover:bg-white/20 transition leading-none">
                            <i class="fas fa-undo"></i> Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Judul Semua Pengaduan --}}
    <h2 class="text-2xl font-bold text-gray-800 mb-6 mt-2 text-left pl-6 md:pl-10">
        Semua Aduan
    </h2>

    {{-- Daftar Aduan --}}
    <div class="mx-auto px-4 2xl:px-6 max-w-full 2xl:max-w-full mb-10">
        @forelse ($reports as $report)
            @php
                $defaultImage = asset('images/image.jpg');
                $thumbnail = $defaultImage;

                if (!empty($report->file)) {
                    $files = is_array($report->file) ? $report->file : json_decode($report->file, true);

                    if (is_array($files)) {
                        foreach ($files as $f) {
                            $ext = strtolower(pathinfo($f, PATHINFO_EXTENSION));

                            if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                                $thumbnail = asset($f); // langsung dari public/report_files
                                break;
                            }
                        }
                    }
                }
            @endphp

            {{-- Grid Container --}}
            @if ($loop->first)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4 gap-6">
            @endif

                {{-- Card --}}
                <div
                    class="bg-white rounded-2xl border border-gray-200 shadow-md hover:shadow-lg transition overflow-hidden flex flex-col">
                    <div class="w-full h-52 relative overflow-hidden">
                        <img src="{{ $thumbnail }}" alt="Thumbnail Aduan"
                            class="w-full h-full object-cover transform hover:scale-105 transition duration-500 ease-in-out">

                        {{-- Status --}}
                        <span
                            class="absolute top-2 left-2 px-4 py-1.5 rounded-full text-sm font-semibold shadow-lg
                                                                                        @if($report->status === 'Diajukan') bg-red-200 text-red-800
                                                                                        @elseif($report->status === 'Dibaca') bg-blue-200 text-blue-800
                                                                                        @elseif($report->status === 'Direspon') bg-yellow-200 text-yellow-800
                                                                                        @elseif($report->status === 'Selesai') bg-green-200 text-green-800
                                                                                        @else bg-gray-200 text-gray-700 @endif">
                            {{ $report->status }}
                        </span>

                        {{-- Nama Pengadu / Anonim --}}
                        <span
                            class="absolute bottom-3 left-1/2 transform -translate-x-1/2
                                                                                        bg-zinc-900/60 text-white text-xs px-3 py-[2px] rounded-full backdrop-blur-sm
                                                                                        tracking-wider italic font-semibold shadow-md shadow-black/30 ring-1 ring-white/10">
                            {{ $report->is_anonim ? 'Anonim' : $report->nama_pengadu }}
                        </span>
                    </div>

                    <div class="p-4 flex flex-col justify-between flex-grow">
                        <h3 class="font-semibold text-lg text-gray-800 truncate">
                            <a href="{{ route('reports.show', ['id' => $report->id]) }}" class="hover:text-blue-600">
                                {{ Str::limit($report->judul, 50) }}
                            </a>
                        </h3>

                        <div class="flex items-center gap-3 text-xs text-gray-600 mt-1">
                            <span>
                                <i class="fa-solid fa-calendar-alt text-[12px] text-zinc-500"></i>
                                {{ $report->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}
                                WIB
                            </span>
                            <span><i class="fa-solid fa-thumbs-up text-gray-500"></i> {{ $report->likes ?? 0 }}</span>
                            <span><i class="fa-solid fa-eye text-gray-500"></i> {{ $report->views ?? 0 }}</span>
                        </div>

                        <p class="text-sm text-gray-700 mt-2 line-clamp-2">
                            <a href="{{ route('reports.show', ['id' => $report->id]) }}" class="hover:text-blue-600">
                                {{ Str::limit($report->isi, 100) }}
                            </a>
                        </p>
                    </div>
                </div>

                @if ($loop->last)
                    </div>
                @endif
        @empty
            <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 p-4 rounded-lg">
                Tidak ada aduan ditemukan.
            </div>
        @endforelse
    </div>

    {{-- Pagination + perPage JS --}}
    @if ($reports->hasPages())
        <div class="mt-4 mb-10 flex justify-center">
            {{-- Desktop --}}
            <div class="hidden sm:block">
                {{ $reports->appends(request()->query())->onEachSide(1)->links('pagination::tailwind') }}
            </div>

            {{-- Mobile --}}
            <div class="block sm:hidden">
                <div class="flex justify-center w-full px-2 text-sm">
                    {{ $reports->appends(request()->query())->onEachSide(1)->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    @endif

    {{-- Script Accordion --}}
    <script>
        function toggleFilterAccordion() {
            const content = document.getElementById('filterAccordionContent');
            const icon = document.getElementById('accordion-icon');
            content.style.maxHeight = content.style.maxHeight ? null : content.scrollHeight + 'px';
            icon.classList.toggle('rotate-180');
        }
    </script>

    {{-- Flatpickr --}}
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        flatpickr("#tanggal", {
            altInput: true,
            altFormat: "d F Y",
            dateFormat: "Y-m-d",
            locale: "id",
            allowInput: false,
            position: "below"
        });
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