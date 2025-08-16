@extends('portal.layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto py-16 px-6 text-gray-800">
        <h1 class="text-2xl font-bold text-center mt-14 mb-8 text-gray-900 uppercase">Tentang Kami</h1>

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
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Lokasi Dinas Komunikasi dan Informatika DIY</h2>

            <div class="w-full aspect-w-16 aspect-h-9 rounded-lg overflow-hidden shadow-xl ring-1 ring-gray-200">
                <iframe
                    src="https://www.openstreetmap.org/export/embed.html?bbox=110.3675,-7.8105,110.3710,-7.8075&layer=mapnik&marker=-7.809218,110.369336"
                    class="w-full h-[30rem] border-0" allowfullscreen="" loading="lazy"
                    title="Peta Lokasi Dinas Kominfo DIY">
                </iframe>
            </div>
        </div>

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