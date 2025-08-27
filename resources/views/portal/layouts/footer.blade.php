<footer class="text-white text-sm">
    <div class="relative border-t border-white/10 backdrop-blur-md shadow-inner overflow-hidden">
        <!-- Background Gambar -->
        <div class="absolute inset-0 bg-cover bg-center z-10" style="background-image: url('/images/red.jpg');"></div>
        <!-- Overlay -->
        <div class="absolute inset-0 bg-black/30 z-30"></div>

        <!-- Konten Footer -->
        <div class="relative z-50 px-6 py-10 max-w-7xl mx-auto space-y-8">
            <!-- Grid: Info Kontak & Peta -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                <!-- Info Kontak -->
                <div class="space-y-3 leading-relaxed text-base">
                    <p class="flex items-center gap-2">
                        <i class="fas fa-map-marker-alt text-white text-lg"></i>
                        Jl. Brigjen Katamso No. 3, Yogyakarta 55161
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fas fa-phone-alt text-white text-lg"></i>
                        (0274) 123456
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fas fa-envelope text-white text-lg"></i>
                        diskominfo@jogjaprov.go.id
                    </p>
                    <p class="flex items-center gap-2">
                        <i class="fas fa-globe text-white text-lg"></i>
                        <a href="https://jogjaprov.go.id" target="_blank"
                            class="hover:underline">www.jogjaprov.go.id</a>
                    </p>
                </div>

                <!-- Mapbox -->
                <div
                    class="w-full md:max-w-sm lg:max-w-sm h-48 sm:h-36 md:h-36 lg:h-40 rounded-lg overflow-hidden shadow-md ring-1 ring-white/20 md:ml-auto">
                    <div id="map-footer" class="w-full h-full"></div>
                </div>
            </div>

            <!-- Sosial Media -->
            <div class="flex justify-start md:justify-center space-x-4 text-white text-xl">
                <a href="#" class="hover:scale-110 hover:text-white/80 transition transform duration-200">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="hover:scale-110 hover:text-white/80 transition transform duration-200">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="hover:scale-110 hover:text-white/80 transition transform duration-200">
                    <i class="fab fa-youtube"></i>
                </a>
                <a href="#" class="hover:scale-110 hover:text-white/80 transition transform duration-200">
                    <i class="fab fa-x-twitter"></i>
                </a>
                <a href="#" class="hover:scale-110 hover:text-white/80 transition transform duration-200">
                    <i class="fab fa-tiktok"></i>
                </a>
            </div>

            <!-- Hak Cipta & Navigasi -->
            <div
                class="border-t border-white/10 pt-4 flex flex-col md:flex-row items-center justify-between gap-2 text-center text-xs font-medium">
                <div class="flex flex-wrap justify-center md:justify-start gap-x-6 text-white/90">
                    <a href="{{ route('tentang') }}" class="hover:underline hover:text-white/80 transition">Tentang
                        Kami</a>
                    <a href="{{ route('ketentuan.layanan') }}" class="hover:underline hover:text-white/80 transition">
                        Ketentuan Layanan
                    </a>
                    <a href="{{ route('kebijakan.privasi') }}"
                        class="hover:underline hover:text-white/80 transition">
                        Kebijakan Privasi
                    </a>

                </div>
                <div class="text-white/90 font-semibold">
                    &copy; {{ date('Y') }} Pemerintah Daerah Istimewa Yogyakarta. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Mapbox CSS & JS -->
<link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        mapboxgl.accessToken = "pk.eyJ1IjoiZmFkaWxhaDI0OCIsImEiOiJja3dnZXdmMnQwbno1MnRxcXYwdjB3cG9qIn0.v4gAtavpn1GzgtD7f3qapA";
        const map = new mapboxgl.Map({
            container: "map-footer",
            style: "mapbox://styles/mapbox/streets-v12",
            center: [110.369336, -7.809218],
            zoom: 16
        });
        map.addControl(new mapboxgl.NavigationControl());
        new mapboxgl.Marker({ color: "red" })
            .setLngLat([110.369336, -7.809218])
            .setPopup(new mapboxgl.Popup().setHTML("<b>Dinas Kominfo DIY</b><br>Jl. Brigjen Katamso No.3"))
            .addTo(map);
    });
</script>