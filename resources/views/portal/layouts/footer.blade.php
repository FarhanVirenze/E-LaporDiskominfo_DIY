<footer class="text-white text-sm">
    <div class="relative border-t border-white/10 backdrop-blur-md shadow-inner overflow-hidden">

        <!-- Background Gambar sebagai layer terpisah -->
        <div class="absolute inset-0 bg-cover bg-center z-10" style="background-image: url('/images/footer1.jpg');">
        </div>

        <!-- Overlay Gelap Transparan -->
        <div class="absolute inset-0 bg-black/70 z-30"></div>

        <div class="absolute inset-0 bg-gradient-to-r from-[#0039CB]/30 to-[#2962FF]/20 z-20"></div>

        <!-- Efek Glow -->
        <div class="absolute top-0 left-0 w-40 h-40 bg-blue-400/20 blur-3xl rounded-full z-40 animate-pulse"></div>
        <div class="absolute bottom-0 right-0 w-40 h-40 bg-indigo-500/20 blur-2xl rounded-full z-40 animate-pulse">
        </div>

        <!-- Konten Footer -->
        <div class="relative z-50 px-6 py-10 max-w-7xl mx-auto space-y-8">

            <!-- Info Kontak -->
            <div class="text-left space-y-3 leading-relaxed text-base">
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
                <!-- Navigasi -->
                <div class="flex flex-wrap justify-center md:justify-start gap-x-6 text-white/90">
                    <a href="{{ route('tentang') }}" class="hover:underline hover:text-white/80 transition">Tentang
                        Kami</a>
                    <a href="#" class="hover:underline hover:text-white/80 transition">Ketentuan Layanan</a>
                    <a href="#" class="hover:underline hover:text-white/80 transition">Kebijakan Privasi</a>
                </div>

                <!-- Hak Cipta -->
                <div class="text-white/90 font-semibold">
                    &copy; {{ date('Y') }} Pemerintah Daerah Istimewa Yogyakarta. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</footer>