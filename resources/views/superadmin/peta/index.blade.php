@extends('superadmin.layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-2xl font-semibold mb-4 text-[#37474F]">Peta Sebaran Aduan</h1>

        <!-- Filter -->
        <div class="flex flex-wrap gap-4 mb-4 items-center">
            <select id="filterStatus" class="border rounded p-2">
                <option value="">Semua Status</option>
                <option value="Diajukan">Diajukan</option>
                <option value="Dibaca">Dibaca</option>
                <option value="Direspon">Direspon</option>
                <option value="Selesai">Selesai</option>
                <option value="Arsip">Arsip</option>
            </select>

            <select id="filterWilayah" class="border rounded p-2">
                <option value="">Semua Wilayah</option>
                @foreach($wilayah as $w)
                    <option value="{{ $w->id }}">{{ $w->nama }}</option>
                @endforeach
            </select>

            <select id="filterKategori" class="border rounded p-2">
                <option value="">Semua Kategori</option>
                @foreach($kategori as $k)
                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                @endforeach
            </select>

            <!-- Tombol Reset -->
            <button id="resetFilter" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow">
                Reset
            </button>
        </div>

        <!-- Map -->
        <div id="map-diskominfo" class="w-full h-[700px] rounded-lg shadow-lg"></div>
    </div>

    <!-- Modal Gambar -->
    <div id="imageModal" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-50">
        <div class="relative max-w-3xl w-full mx-4">
            <button id="closeModal"
                class="absolute top-2 right-2 text-white text-3xl z-50 hover:text-red-500 transition">&times;</button>
            <img id="modalImage" src=""
                class="w-full h-auto rounded-lg shadow-lg transform scale-90 opacity-0 transition-all duration-300">
        </div>
    </div>

    <!-- Mapbox -->
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>

    <script>
        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modalImg.src = src;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => modalImg.classList.remove('scale-90', 'opacity-0'), 50);
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modalImg.classList.add('scale-90', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }
        document.getElementById('closeModal').addEventListener('click', closeImageModal);
        document.getElementById('imageModal').addEventListener('click', (e) => {
            if (e.target.id === 'imageModal') closeImageModal();
        });

        document.addEventListener("DOMContentLoaded", () => {
            mapboxgl.accessToken = "pk.eyJ1IjoiZmFkaWxhaDI0OCIsImEiOiJja3dnZXdmMnQwbno1MnRxcXYwdjB3cG9qIn0.v4gAtavpn1GzgtD7f3qapA";

            const map = new mapboxgl.Map({
                container: "map-diskominfo",
                style: "mapbox://styles/mapbox/streets-v12",
                center: [110.369336, -7.809218],
                zoom: 12
            });

            map.addControl(new mapboxgl.NavigationControl());

            const reports = @json($reports);

            const statusColors = {
                "Diajukan": "red",
                "Dibaca": "orange",
                "Direspon": "blue",
                "Selesai": "green",
                "Arsip": "stone"
            };

            const statusBadge = {
                "Diajukan": "bg-red-200 text-red-800",
                "Dibaca": "bg-blue-200 text-blue-800",
                "Direspon": "bg-yellow-200 text-yellow-800",
                "Selesai": "bg-green-200 text-green-800",
                "Arsip": "bg-stone-700 text-white"
            };

            let markers = [];

            function renderMarkers(filterStatus = "", filterWilayah = "", filterKategori = "") {
                markers.forEach(m => m.remove());
                markers = [];

                reports.forEach(report => {
                    if (!report.latitude || !report.longitude) return;

                    if (filterStatus && report.status !== filterStatus) return;
                    if (filterWilayah && report.wilayah?.id != filterWilayah) return;
                    if (filterKategori && report.kategori?.id != filterKategori) return;

                    found = true;

                    let imagesHtml = "";
                    if (Array.isArray(report.file) && report.file.length > 0) {
                        const imageFiles = report.file.filter(f => /\.(jpg|jpeg|png|gif)$/i.test(f));
                        imageFiles.forEach(img => {
                            // langsung ambil dari public
                            const imgUrl = img.startsWith('http') ? img : "{{ asset('') }}" + img;

                            imagesHtml += `
                <div class="relative group cursor-pointer overflow-hidden rounded-lg w-full mb-2"
                     onclick="openImageModal('${imgUrl}')">
                    <img src="${imgUrl}" alt="Foto Aduan" class="w-full h-32 object-cover transition duration-300 group-hover:brightness-75 rounded">
                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition duration-300 z-10"></div>
                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 z-20">
                        <i class="fas fa-search-plus text-white text-2xl"></i>
                    </div>
                    <span class="absolute top-2 right-2 px-2 py-1 text-xs font-semibold rounded-full ${statusBadge[report.status] || 'bg-gray-200 text-gray-800'}">
                        ${report.status}
                    </span>
                </div>`;
                        });
                    }

                    const popupHtml = `
                            <div class="flex flex-col">
                                <b class="mb-1">${report.judul}</b>
                                ${imagesHtml}
                                <div class="text-xs text-gray-700 mt-1">${report.lokasi}</div>
                                <div class="text-xs mt-1"><b>Kategori:</b> ${report.kategori?.nama || "-"}</div>
                                <div class="text-xs"><b>Wilayah:</b> ${report.wilayah?.nama || "-"}</div>
                            </div>
                        `;


                    const marker = new mapboxgl.Marker({ color: statusColors[report.status] || "gray" })
                        .setLngLat([parseFloat(report.longitude), parseFloat(report.latitude)])
                        .setPopup(new mapboxgl.Popup({ maxWidth: '300px' }).setHTML(popupHtml))
                        .addTo(map);

                    markers.push(marker);
                });

                if (!found) {
                    alert("Tidak ada aduan yang sesuai dengan filter!");
                }
            }

            renderMarkers();

            // Event filter langsung jalan
            const statusEl = document.getElementById("filterStatus");
            const wilayahEl = document.getElementById("filterWilayah");
            const kategoriEl = document.getElementById("filterKategori");
            const resetBtn = document.getElementById("resetFilter");

            function applyFilter() {
                renderMarkers(statusEl.value, wilayahEl.value, kategoriEl.value);
            }

            statusEl.addEventListener("change", applyFilter);
            wilayahEl.addEventListener("change", applyFilter);
            kategoriEl.addEventListener("change", applyFilter);

            // Reset Filter
            resetBtn.addEventListener("click", () => {
                statusEl.value = "";
                wilayahEl.value = "";
                kategoriEl.value = "";
                renderMarkers();
            });
        });
    </script>
@endsection