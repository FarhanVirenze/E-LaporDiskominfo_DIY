<div class="flex flex-col lg:flex-row gap-4 min-h-screen">
    <!-- Sidebar Navigasi (Desktop) -->
    <div class="hidden lg:block w-1/4 mt-4">
        <div class="space-y-2">
            <!-- Riwayat Aduan -->
            <a href="{{ route('admin.aduan.riwayat') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium transition-colors duration-200
               {{ request()->routeIs('admin.aduan.riwayat')
    ? 'bg-gradient-to-r from-[#ef4444] to-[#b91c1c] text-white'
    : 'bg-gray-100 text-[#ef4444] hover:bg-gray-300 hover:text-[#b91c1c]' }}">
                <i class="fa-solid fa-clock-rotate-left w-5 h-5"></i>
                <span>Riwayat Aduan</span>
            </a>

            <!-- Profil -->
            <a href="{{ route('admin.profile.edit') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium transition-colors duration-200
               {{ request()->routeIs('admin.profile.edit')
    ? 'bg-gradient-to-r from-[#ef4444] to-[#b91c1c] text-white'
    : 'bg-gray-100 text-[#ef4444] hover:bg-gray-300 hover:text-[#b91c1c]' }}">
                <i class="fa-solid fa-user w-5 h-5"></i>
                <span>Profil</span>
            </a>

            <!-- Buat Aduan -->
            <a href="{{ route('admin.beranda') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium transition-colors duration-200
               {{ request()->routeIs('admin.beranda')
    ? 'bg-gradient-to-r from-[#ef4444] to-[#b91c1c] text-white'
    : 'bg-gray-100 text-[#ef4444] hover:bg-gray-300 hover:text-[#b91c1c]' }}">
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
        <!-- Riwayat Aduan -->
        <a href="{{ route('admin.aduan.riwayat') }}" class="flex flex-col items-center justify-center py-2 text-sm font-medium
           {{ request()->routeIs('admin.aduan.riwayat')
    ? 'text-[#B5332A] hover:text-[#B5332A] cursor-default'
    : 'text-gray-500 hover:text-[#8B1E1E]' }}">
            <i class="fa-solid fa-clock-rotate-left text-lg"></i>
            <span>Riwayat</span>
        </a>

        <!-- Tombol Floating Buat Aduan -->
        <a href="{{ route('admin.aduan.create') }}"
            class="absolute -top-5 left-1/2 transform -translate-x-1/2 flex flex-col items-center group">
            <div class="bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] text-white 
                w-14 h-14 rounded-full flex items-center justify-center 
                shadow-lg group-hover:scale-110 transition-all">
                <i class="fa-solid fa-plus text-xl"></i>
            </div>
            <span class="mt-1 text-xs font-medium text-[#B5332A]">Buat Aduan</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('admin.profile.edit') }}" class="flex flex-col items-center justify-center py-2 text-sm font-medium
           {{ request()->routeIs('admin.profile.edit')
    ? 'text-[#B5332A] hover:text-[#B5332A] cursor-default'
    : 'text-gray-500 hover:text-[#8B1E1E]' }}">
            <i class="fa-solid fa-user text-lg"></i>
            <span>Profil</span>
        </a>
    </div>
</div>