@extends('portal.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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

    <div class="text-center py-16 px-4 sm:px-6 lg:px-8 animate__animated animate__fadeInUp">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl sm:text-5xl font-bold text-gray-800 mb-4">
                Selamat Datang di Portal E-Lapor DIY
            </h1>
            <p class="text-black text-lg leading-relaxed mb-10">
                Layanan pengaduan masyarakat berbasis digital untuk wilayah Daerah Istimewa Yogyakarta. Laporkan aduan Anda
                secara cepat, mudah, dan transparan.
            </p>

            <!-- Fitur -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                @php
                    $fitur = [
                        ['icon' => 'fas fa-edit', 'title' => 'Buat Aduan', 'desc' => 'Isi formulir pengaduan secara online kapan saja dan di mana saja.'],
                        ['icon' => 'fas fa-shield-alt', 'title' => 'WBS (Whistleblower System)', 'desc' => 'Laporkan pelanggaran KKN secara anonim dan terlindungi.'],
                        ['icon' => 'fas fa-chart-line', 'title' => 'Pantau Status', 'desc' => 'Lacak perkembangan pengaduan Anda secara real-time.']
                    ];
                @endphp
                @foreach ($fitur as $index => $item)
                    <div class="p-6 rounded-lg shadow-lg border border-[#C0392B] hover:shadow-xl transition duration-300 animate__animated animate__fadeInUp"
                        style="animation-delay: {{ $index * 0.3 }}s;">
                        <div class="text-[#C0392B] mb-4">
                            <i class="{{ $item['icon'] }} fa-2x"></i>
                        </div>
                        <h3 class="text-lg font-semibold mb-2">{{ $item['title'] }}</h3>
                        <p class="text-gray-600 text-sm">{{ $item['desc'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Form Aduan Cepat -->
            <div class="relative bg-white border shadow-md rounded-lg p-8 w-full max-w-7xl mx-auto animate__animated animate__fadeInUp"
                id="aduanCepatBox">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center border-b pb-2">ADUAN CEPAT</h2>

                {{-- Overlay jika belum login --}}
                @guest
                    <div id="form-overlay"
                        class="absolute inset-0 z-10 bg-white bg-opacity-80 flex items-center justify-center rounded-lg animate__animated animate__fadeIn hidden">
                        <div class="text-red-700 text-center font-semibold animate__animated animate__fadeIn px-4">
                            <i class="fas fa-exclamation-triangle text-3xl mb-2"></i><br>
                            Untuk dapat mengisi formulir <strong>Aduan Cepat</strong>, silakan terlebih dahulu melakukan
                            <a href="{{ route('login') }}" class="text-blue-600 underline hover:text-blue-800 font-semibold">
                                Login
                            </a> ke akun Anda.
                        </div>
                    </div>
                @endguest

                <form method="POST" action="{{ route('user.aduan.store') }}" enctype="multipart/form-data"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf

                    <!-- Kolom Kiri -->
                    <div class="space-y-4">
                        <input type="text" name="judul" placeholder="Judul Aduan"
                            class="w-full border rounded px-4 py-2 bg-gray-100 @error('judul') border-red-500 @enderror"
                            required>
                        @error('judul')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <textarea name="isi" placeholder="Aduan Anda" rows="4"
                            class="w-full border rounded px-4 py-2 bg-gray-100 @error('isi') border-red-500 @enderror"
                            required></textarea>
                        @error('isi')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <select name="wilayah_id"
                            class="w-full border rounded px-4 py-2 bg-gray-100 @error('wilayah_id') border-red-500 @enderror"
                            required>
                            <option value="">- Pilih Wilayah -</option>
                            @forelse(App\Models\WilayahUmum::all() as $wilayah)
                                <option value="{{ $wilayah->id }}">{{ $wilayah->nama }}</option>
                            @empty
                                <option value="">Tidak ada wilayah tersedia</option>
                            @endforelse
                        </select>
                        @error('wilayah_id')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                        <div class="flex gap-2">
                            <!-- Dropdown Kategori -->
                            <select name="kategori_id"
                                class="w-full border rounded px-4 py-2 bg-gray-100 @error('kategori_id') border-red-500 @enderror"
                                required>
                                <option value="">- Pilih Kategori -</option>
                                @forelse(App\Models\KategoriUmum::all() as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                                @empty
                                    <option value="">Tidak ada kategori tersedia</option>
                                @endforelse
                            </select>
                            @error('kategori_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror

                            <label
                                class="bg-[#c0392b] hover:bg-[#922b21] text-white px-4 py-2 rounded cursor-pointer flex items-center">
                                <i class="fas fa-image mr-1"></i> File
                                <input type="file" name="file" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.zip" class="hidden">
                            </label>

                            <label onclick="openLocationModal()"
                                class="bg-[#c0392b] hover:bg-[#922b21] text-white px-4 py-2 rounded cursor-pointer flex items-center">
                                <i class="fas fa-map-marker-alt mr-1"></i> Lokasi
                            </label>

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
                        <label class="flex items-center space-x-2">
                            <input type="checkbox" name="is_anonim" id="anonimCheckbox" class="form-checkbox" value="1">
                            <span class="text-sm">Anonim</span>
                        </label>

                        <div class="identitas-group space-y-4">
                            <input type="text" name="nama_pengadu" placeholder="Nama Anda"
                                value="{{ $user && $user->role === 'user' ? $user->name : '' }}"
                                class="w-full border rounded px-4 py-2 bg-gray-100" readonly>
                            <input type="email" name="email_pengadu" placeholder="Alamat email Anda"
                                value="{{ $user && $user->role === 'user' ? $user->email : '' }}"
                                class="w-full border rounded px-4 py-2 bg-gray-100" readonly>
                            <input type="text" name="telepon_pengadu" placeholder="Nomor telepon"
                                value="{{ $user && $user->role === 'user' ? $user->nomor_telepon : '' }}"
                                class="w-full border rounded px-4 py-2 bg-gray-100" readonly>
                            <input type="text" name="nik" placeholder="NIK"
                                value="{{ $user && $user->role === 'user' ? $user->nik : '' }}"
                                class="w-full border rounded px-4 py-2 bg-gray-100" readonly>
                        </div>

                        <label class="text-sm text-gray-500 mt-4 block">
                            <input type="checkbox" required>
                            Dengan mengisi form ini Anda menyetujui
                            <a href="#" class="text-blue-600 hover:underline">Ketentuan Layanan</a> dan
                            <a href="#" class="text-blue-600 hover:underline">Kebijakan Privasi</a> .
                        </label>

                        <button type="submit"
                            class="w-full bg-[#c0392b] hover:bg-[#922b21] text-white py-3 rounded font-bold text-lg">
                            ADUKAN
                        </button>
                    </div>
                </form>
            </div>

            <!-- Aduan Terbaru -->
            <div
                class="relative bg-white border shadow-md rounded-lg p-8 w-full max-w-7xl mx-auto mt-16 animate__animated animate__fadeInUp">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 text-center border-b pb-2">DAFTAR ADUAN</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    @forelse (\App\Models\Report::latest()->take(5)->get() as $report)
                        <div
                            class="bg-white border-2 border-gray-300 p-4 shadow-lg rounded-lg hover:shadow-xl transition duration-300 w-full mx-auto">
                            <h3 class="font-semibold text-lg text-gray-800 text-left truncate">
                                <a href="{{ route('reports.show', ['id' => $report->id]) }}"
                                    class="hover:text-blue-600 transition-all">
                                    {{ Str::limit($report->judul, 27) }}
                                </a>
                            </h3>

                            <p class="text-sm text-gray-600 mt-2 text-left line-clamp-2">
                                <a href="{{ route('reports.show', ['id' => $report->id]) }}"
                                    class="hover:text-blue-600 transition-all">
                                    {{ Str::limit($report->isi, 100) }}
                                </a>
                            </p>

                            <div class="mt-4">
                                <!-- User Info and Date -->
                                <div class="flex items-center text-xs text-gray-500 space-x-2">
                                    <i class="fas fa-user text-blue-500"></i>
                                    <span class="font-semibold">{{ $report->nama_pengadu }}</span>
                                </div>

                                <div class="flex items-center text-xs text-gray-500 mt-2 space-x-2">
                                    <i class="fas fa-clock text-gray-500"></i>
                                    <span>
                                        Dikirim pada:
                                        {{ $report->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}
                                        WIB
                                    </span>
                                </div>

                                <!-- Category and Status -->
                                <div class="flex items-center text-xs text-gray-500 mt-2 space-x-2">
                                    <i class="fas fa-list-alt text-green-500"></i>
                                    <span>{{ $report->kategori->nama }}</span>
                                </div>

                                <div class="flex items-center text-xs text-gray-500 mt-2 space-x-2">
                                    <i class="fas fa-tasks text-yellow-500"></i>
                                    <span class="font-semibold">Status: </span>
                                    <span
                                        class="status-text 
                                                                                                                                                                                                                                                                                                                                        @if($report->status == 'Diajukan') bg-blue-200 text-blue-800 
                                                                                                                                                                                                                                                                                                                                        @elseif($report->status == 'Dibaca') bg-teal-200 text-teal-800 
                                                                                                                                                                                                                                                                                                                                        @elseif($report->status == 'Direspon') bg-yellow-200 text-yellow-800 
                                                                                                                                                                                                                                                                                                                                        @elseif($report->status == 'Selesai') bg-green-200 text-green-800 
                                                                                                                                                                                                                                                                                                                                        @endif 
                                                                                                                                                                                                                                                                                                                                        rounded-full px-2 py-1 text-xs font-semibold">
                                        {{ $report->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <!-- Jika tidak ada data laporan, tampilkan pesan alert -->
                        <div class="alert alert-info col-span-full">
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
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // === Fokus Input: Hapus Error ===
                document.querySelectorAll('input, textarea, select').forEach((element) => {
                    element.addEventListener('focus', () => {
                        element.classList.remove('border-red-500');
                        const errorMessage = element.parentElement.querySelector('.text-red-500');
                        if (errorMessage) {
                            errorMessage.remove();
                        }
                    });
                });

                // === Checkbox Anonim: Sembunyikan Identitas ===
                const anonimCheckbox = document.getElementById('anonimCheckbox');
                const identitasGroup = document.querySelector('.identitas-group');
                if (anonimCheckbox && identitasGroup) {
                    anonimCheckbox.addEventListener('change', function () {
                        identitasGroup.style.display = this.checked ? 'none' : 'block';
                    });
                }

                // === Overlay Login Jika Belum Login ===
                const formContainer = document.getElementById('aduanCepatBox');
                const overlay = document.getElementById('form-overlay');
                if (overlay && formContainer) {
                    formContainer.addEventListener('mouseenter', () => overlay.classList.remove('hidden'));
                    formContainer.addEventListener('mouseleave', () => overlay.classList.add('hidden'));
                    const form = formContainer.querySelector('form');
                    if (form) {
                        form.addEventListener('submit', function (e) {
                            e.preventDefault(); // Tidak kirim form
                        });
                    }
                }

                const spinner = document.getElementById('success-spinner');
                const check = document.getElementById('success-check');

                setTimeout(() => {
                    if (spinner && check) {
                        spinner.classList.add('hidden');
                        check.classList.remove('hidden');
                        check.classList.add('scale-100');
                    }
                }, 1000); // ganti spinner ke check setelah 1 detik

                // Fade-out seluruh alert setelah 3 detik
                const fadeOutAndRemove = (el) => {
                    if (!el) return;
                    el.classList.remove('opacity-100');
                    el.classList.add('opacity-0');
                    setTimeout(() => {
                        el.style.display = 'none';
                    }, 500); // durasi sama dengan transition
                };


                setTimeout(() => {
                    fadeOutAndRemove(document.getElementById('alert-success'));
                    fadeOutAndRemove(document.getElementById('alert-error'));
                }, 3000);
            });

            // === Leaflet Map & Lokasi Modal ===
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
                        const lat = e.latlng.lat;
                        const lng = e.latlng.lng;

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
                    content.classList.remove('modal-animate-out'); // reset
                }, 250); // match anim duration
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

            // Tambahkan di sini ⬇️
            function resetMapToDefault() {
                const defaultLatLng = [-7.797068, 110.370529];
                map.setView(defaultLatLng, 13);

                // Hapus marker jika ada
                if (marker) {
                    map.removeLayer(marker);
                    marker = null;
                }

                // Kosongkan input koordinat dan alamat
                document.getElementById('latitudeField').value = '';
                document.getElementById('longitudeField').value = '';
                document.getElementById('alamatField').value = '';
            }
        </script>
    @endpush