<footer class="text-white text-sm">
    <div class="relative bg-gradient-to-br from-[#1e3a8a]/95 to-[#2563eb]/90 border-t border-white/10 backdrop-blur-md shadow-lg rounded-t-xl overflow-hidden">
        <!-- Overlay Gelap 30% -->
        <div class="absolute inset-0 bg-black/30 z-0"></div>

        <!-- Konten Footer -->
        <div class="relative z-10 px-5 py-6 max-w-7xl mx-auto">
            <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 text-center md:text-left">
                <!-- Link Navigasi -->
                <div class="flex flex-wrap justify-center md:justify-start space-x-4 text-sm font-medium">
                    <a href="{{ route('tentang') }}" class="hover:underline hover:text-white/80 transition">Tentang Kami</a>
                    <a href="#" class="hover:underline hover:text-white/80 transition">Ketentuan Layanan</a>
                    <a href="#" class="hover:underline hover:text-white/80 transition">Kebijakan Privasi</a>
                </div>

                <!-- Hak Cipta -->
                <div class="text-sm font-semibold">
                    &copy; {{ date('Y') }} Pemerintah Daerah Daerah Istimewa Yogyakarta. Hak Cipta Dilindungi.
                </div>
            </div>
        </div>
    </div>
</footer>
