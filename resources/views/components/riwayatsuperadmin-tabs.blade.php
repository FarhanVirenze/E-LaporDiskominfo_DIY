<div class="flex flex-col lg:flex-row gap-4 min-h-screen">
    <!-- Sidebar Navigasi (Desktop) -->
    <div class="hidden lg:block w-1/4 mt-4">
        <div class="space-y-2">
            <!-- Riwayat Aduan -->
            <a href="{{ route('superadmin.aduan.riwayat') }}" 
               class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium transition-colors duration-200
               {{ request()->routeIs('superadmin.aduan.riwayat')
                    ? 'bg-gradient-to-r from-[#2563eb] to-[#1e40af] text-white'
                    : 'bg-gray-100 text-[#2563eb] hover:bg-gray-300 hover:text-[#1e40af]' }}">
                <i class="fa-solid fa-clock-rotate-left w-5 h-5"></i>
                <span>Riwayat Aduan</span>
            </a>

            <!-- Profil -->
            <a href="{{ route('superadmin.profile.edit') }}" 
               class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium transition-colors duration-200
               {{ request()->routeIs('superadmin.profile.edit')
                    ? 'bg-gradient-to-r from-[#2563eb] to-[#1e40af] text-white'
                    : 'bg-gray-100 text-[#2563eb] hover:bg-gray-300 hover:text-[#1e40af]' }}">
                <i class="fa-solid fa-user w-5 h-5"></i>
                <span>Profil</span>
            </a>

            <!-- Buat Aduan -->
            <a href="{{ route('beranda') }}" 
               class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium transition-colors duration-200
               {{ request()->routeIs('beranda')
                    ? 'bg-gradient-to-r from-[#2563eb] to-[#1e40af] text-white'
                    : 'bg-gray-100 text-[#2563eb] hover:bg-gray-300 hover:text-[#1e40af]' }}">
                <i class="fa-solid fa-plus w-5 h-5"></i>
                <span>Buat Aduan</span>
            </a>
        </div>
    </div>

    <!-- Slot konten -->
    <div class="flex-1 w-full">
        {{ $slot }}
    </div>
</div>

<!-- Bottom Navigation (Mobile) -->
<div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-inner lg:hidden z-50">
    <div class="flex justify-around items-center relative">
        <!-- Riwayat -->
        <a href="{{ route('superadmin.aduan.riwayat') }}" 
           class="flex flex-col items-center justify-center py-2 text-sm font-medium
           {{ request()->routeIs('superadmin.aduan.riwayat')
                ? 'text-[#2563eb] hover:text-[#2563eb] cursor-default'
                : 'text-gray-500 hover:text-[#2563eb]' }}">
            <i class="fa-solid fa-clock-rotate-left text-lg"></i>
            <span>Riwayat</span>
        </a>

        <!-- Tombol Floating Buat Aduan -->
        <a href="{{ route('beranda') }}"
           class="absolute -top-5 left-1/2 transform -translate-x-1/2 flex flex-col items-center group">

            <!-- Icon bulat -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-500 text-white 
                w-14 h-14 rounded-full flex items-center justify-center 
                shadow-lg group-hover:scale-110 transition-all">
                <i class="fa-solid fa-plus text-xl"></i>
            </div>

            <!-- Label -->
            <span class="mt-1 text-xs font-medium text-[#2563eb]">Buat Aduan</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('superadmin.profile.edit') }}" 
           class="flex flex-col items-center justify-center py-2 text-sm font-medium
           {{ request()->routeIs('superadmin.profile.edit')
                ? 'text-[#2563eb] hover:text-[#2563eb] cursor-default'
                : 'text-gray-500 hover:text-[#2563eb]' }}">
            <i class="fa-solid fa-user text-lg"></i>
            <span>Profil</span>
        </a>
    </div>
</div>
