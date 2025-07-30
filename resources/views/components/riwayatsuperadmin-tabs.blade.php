<div class="flex flex-col lg:flex-row gap-4">
    <!-- Sidebar Navigasi -->
    <div class="w-full lg:w-1/4">
        <div class="space-y-2">
            <a href="{{ route('superadmin.aduan.riwayat') }}" class="block px-4 py-2 rounded font-medium transition-colors duration-200
          {{ request()->routeIs('superadmin.aduan.riwayat')
    ? 'bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] text-white'
    : 'bg-gray-100 text-[#b13c3c] hover:bg-gray-300 hover:text-[#8B1E1E]' }}">
                Riwayat Aduan
            </a>

            <a href="{{ route('superadmin.aduan.riwayatWbs') }}" class="block px-4 py-2 rounded font-medium transition-colors duration-200
          {{ request()->routeIs('superadmin.aduan.riwayatWbs')
    ? 'bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] text-white'
    : 'bg-gray-100 text-[#b13c3c] hover:bg-gray-300 hover:text-[#8B1E1E]' }}">
                Riwayat Aduan WBS
            </a>
        </div>
    </div>

    <!-- Slot konten akan tampil di sini -->
    <div class="w-full lg:w-3/4">
        {{ $slot }}
    </div>
</div>