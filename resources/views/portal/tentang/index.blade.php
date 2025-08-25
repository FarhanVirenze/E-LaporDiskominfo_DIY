@extends('portal.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-16 px-6 text-gray-800">
    <h1 class="text-2xl font-bold text-center mt-12 mb-8 text-gray-900">Tentang Kami</h1>

    <p class="text-lg leading-[1.6rem] text-justify indent-8 mb-4">
        Kami adalah Tim yang menampung aspirasi Anda agar bisa kita wujudkan bersama untuk Indonesia yang maju dan
        sejahtera.
        Melalui aplikasi ini kami ingin berbagi, kami ingin Anda menceritakan, memberitahu kami, memberi kami informasi
        terkini
        mengenai aspirasi yang Anda harapkan. Kami memiliki unit yang akan siap merespon Anda selama 24 jam, kami
        membangun layanan
        untuk memberi kebutuhan untuk Anda, agar bisa lebih dekat, lebih bisa mengontrol kinerja kami dan mampu memberi
        saran dan masukan
        bagi pengembangan kami di masa depan. Terima kasih.
    </p>

    <div class="mb-2">
        <p class="text-m">
            <strong>Alamat:</strong> Jl. Brigjen Katamso, Keparakan, Kec. Mergangsan, Kota Yogyakarta, Daerah Istimewa
            Yogyakarta 55152
        </p>
    </div>
    <div class="mb-2">
        <p class="text-m">
            <strong>Telp./Fax:</strong> (0274) 373444
        </p>
    </div>

    <div class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            Lokasi Dinas Komunikasi dan Informatika DIY
        </h2>

        <div id="map-diskominfo" class="w-full h-[30rem] rounded-lg overflow-hidden shadow-xl ring-1 ring-gray-200">
        </div>
    </div>
    
        <!-- Mapbox CSS & JS -->
        <link href="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v3.3.0/mapbox-gl.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                mapboxgl.accessToken = "pk.eyJ1IjoiZmFkaWxhaDI0OCIsImEiOiJja3dnZXdmMnQwbno1MnRxcXYwdjB3cG9qIn0.v4gAtavpn1GzgtD7f3qapA";

                const map = new mapboxgl.Map({
                    container: "map-diskominfo",
                    style: "mapbox://styles/mapbox/streets-v12", // Bisa diganti: satellite-v9, light-v11, dark-v11
                    center: [110.369336, -7.809218], // [lng, lat]
                    zoom: 17
                });

                // Kontrol zoom/rotate
                map.addControl(new mapboxgl.NavigationControl());

                // Tambah marker
                new mapboxgl.Marker({ color: "red" })
                    .setLngLat([110.369336, -7.809218])
                    .setPopup(new mapboxgl.Popup().setHTML("<b>Dinas Kominfo DIY</b><br>Jl. Brigjen Katamso No.3"))
                    .addTo(map);
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