@extends('portal.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection

@section('content')
    <div class="max-w-4xl mx-auto px-4 py-8">

        @if (session('success'))
            <div id="successMessage" class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Meta --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p><strong>Oleh</strong> {{ $report->is_anonim ? 'Anonim' : $report->nama_pengadu }}</p>
                <p><strong>Kategori</strong> {{ $report->kategori->nama }}</p>
                <p><strong>Wilayah</strong> {{ $report->wilayah->nama }}</p>
                <p><strong>Status Aduan</strong>
                    <span
                        class="px-2 py-1 text-sm rounded font-semibold
                                                                                        @if($report->status == 'Diajukan') bg-blue-100 text-blue-700
                                                                                        @elseif($report->status == 'Dibaca') bg-teal-100 text-teal-700
                                                                                        @elseif($report->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                                        @elseif($report->status == 'Selesai') bg-green-100 text-green-700 @endif">
                        {{ $report->status }}
                    </span>
                </p>
            </div>
            <div>
                <p><strong>Diadukan pada</strong>
                    {{ $report->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}
                </p>
            </div>
        </div>

        {{-- Judul & Isi --}}
        <div class="mb-6">
            <h2 class="text-3xl font-bold text-red-700 mb-2">{{ $report->judul }}</h2>
            <div class="bg-white border rounded-lg shadow-sm p-6 max-h-96 overflow-y-scroll">
                <p class="text-gray-800 whitespace-pre-line">{{ $report->isi }}</p>
            </div>
        </div>

        {{-- Tabs --}}
        @php
            $badges = [
                'tindak' => $followUps->count(),
                'komentar' => $comments->count(),
                'lampiran' => $report->file ? 1 : 0,
            ];
            $tabs = [
                'tindak' => ['label' => 'Tindak Lanjut', 'icon' => 'fa-clipboard-check'],
                'komentar' => ['label' => 'Komentar', 'icon' => 'fa-comments'],
                'lampiran' => ['label' => 'Lampiran', 'icon' => 'fa-paperclip'],
                'lokasi' => ['label' => 'Lokasi', 'icon' => 'fa-map-marker-alt'],
            ];
        @endphp

        <div class="border-b px-6 pt-4 flex space-x-6 text-sm font-semibold text-gray-600">
            @foreach ($tabs as $key => $tab)
                <button onclick="showTab('{{ $key }}')" id="tab-{{ $key }}"
                    class="tab-button py-2 border-b-2 border-transparent text-gray-600 hover:text-blue-600 relative transition duration-300">
                    <i class="fas {{ $tab['icon'] }} mr-1"></i>
                    {{ $tab['label'] }}
                    @if (!empty($badges[$key]))
                        <span class="absolute -top-1 -right-3 bg-blue-600 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                            {{ $badges[$key] }}
                        </span>
                    @endif
                </button>
            @endforeach
        </div>

        {{-- Tab Konten --}}
        <div class="p-6">
            {{-- Tindak Lanjut --}}
            <div class="tab-pane opacity-100 translate-y-0 transition-all duration-300" data-tab="tindak">
                @forelse ($followUps as $item)
                    <div class="mb-6 relative group bg-gray-50 rounded-md p-3 border shadow-sm">
                        <!-- Menambahkan kelas yang sama seperti komentar -->
                        <p class="text-sm text-gray-600">
                            <strong>{{ $item->user->name }}</strong>
                            <span class="text-gray-500"> ({{ $item->created_at->diffForHumans() }})</span>
                        </p>
                        <p class="text-gray-800 mb-2">{{ $item->pesan }}</p>
                        @if ($item->file)
                            <img src="{{ asset('storage/' . $item->file) }}" class="max-w-xs rounded shadow">
                        @endif

                        {{-- Tombol hapus tindak lanjut --}}
                        @if (auth()->check() && auth()->user()->role === 'admin')
                            <form method="POST" action="{{ route('reports.followup.delete', [$report->id, $item->id]) }}"
                                class="absolute top-2 right-2 hidden group-hover:block"
                                onsubmit="return confirm('Yakin ingin menghapus tindak lanjut ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 text-xs hover:text-red-800">
                                    <i class="fas fa-trash-alt"></i> Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada tindak lanjut.</p>
                @endforelse

                @if (auth()->check() && in_array(auth()->user()->role, ['admin']))
                    <form action="{{ route('reports.followup', ['id' => $report->id]) }}" method="POST"
                        enctype="multipart/form-data" class="mt-6 space-y-4">
                        @csrf
                        <textarea name="pesan" class="w-full border rounded p-2" rows="4" placeholder="Tindak lanjut..."
                            required></textarea>
                        <input type="file" name="file" class="block w-full border rounded p-1">
                        <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">Kirim Tindak
                            Lanjut</button>
                    </form>
                @endif
            </div>

            {{-- Komentar --}}
            <div class="tab-pane opacity-0 translate-y-4 transition-all duration-300 hidden" data-tab="komentar">
                <div class="max-h-96 overflow-y-auto pr-2">
                    @forelse ($comments as $item)
                        <div class="relative group mb-6 bg-gray-50 rounded-md p-3 border shadow-sm">
                            <p class="text-sm text-gray-600">
                                <strong>{{ $item->user->name }}</strong>
                                <span class="text-gray-500">({{ $item->created_at->diffForHumans() }})</span>
                            </p>
                            <p class="text-gray-800 mb-2">{{ $item->pesan }}</p>

                            @if ($item->file)
                                <img src="{{ asset('storage/' . $item->file) }}" class="w-32 h-auto rounded shadow cursor-pointer"
                                    onclick="openModal('{{ asset('storage/' . $item->file) }}')" alt="Lampiran Komentar">
                            @endif

                            {{-- Tombol hapus komentar --}}
                            @if (auth()->check() && (auth()->id() === $item->user_id || auth()->user()->role === 'admin'))
                                <form method="POST" action="{{ route('reports.comment.delete', $item->id) }}"
                                    class="absolute top-2 right-2 hidden group-hover:block"
                                    onsubmit="return confirm('Yakin ingin menghapus komentar ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 text-xs hover:text-red-800">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada komentar.</p>
                    @endforelse
                </div>

                @if (auth()->check() && in_array(auth()->user()->role, ['user', 'admin']))
                    <form action="{{ route('reports.comment', ['id' => $report->id]) }}" method="POST"
                        enctype="multipart/form-data" class="mt-6 space-y-4">
                        @csrf
                        <textarea name="pesan" class="w-full border rounded p-2" rows="4" placeholder="Tulis komentar..."
                            required></textarea>
                        <input type="file" name="file" class="block w-full border rounded p-1">
                        <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded hover:bg-red-800">Kirim
                            Komentar</button>
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
                @if ($report->file)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $report->file) }}" class="w-32 h-auto rounded shadow cursor-pointer"
                            onclick="openModal('{{ asset('storage/' . $report->file) }}')" alt="Lampiran">
                    </div>
                @else
                    <p class="text-gray-500">Tidak ada lampiran.</p>
                @endif
            </div>

            {{-- Lokasi --}}
            <div class="tab-pane opacity-0 translate-y-4 transition-all duration-300 hidden" data-tab="lokasi">
                @if ($report->lokasi && $report->latitude && $report->longitude)
                    <p class="text-sm text-gray-700 mb-2"><strong>Alamat:</strong> {{ $report->lokasi }}</p>
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

    {{-- Modal Gambar --}}
    <div id="imgModal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center hidden z-50">
        <span class="absolute top-4 right-6 text-white text-3xl cursor-pointer" onclick="closeModal()">&times;</span>
        <img id="modalImage" class="max-w-3xl max-h-[90vh] rounded shadow-xl">
    </div>
@endsection

@section('include-js')
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

        function openModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imgModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('imgModal').classList.add('hidden');
        }
    </script>
@endsection