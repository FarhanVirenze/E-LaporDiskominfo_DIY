<div class="flex flex-col lg:flex-row gap-4 min-h-screen">
    <!-- Sidebar Navigasi (Desktop) -->
    <div class="hidden lg:block w-1/4 mt-4">
        <div class="space-y-2">
            <!-- Riwayat Aduan -->
            <a href="{{ route('wbs_admin.aduan.riwayat') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium transition-colors duration-200
           {{ request()->routeIs('wbs_admin.aduan.riwayat')
    ? 'bg-gradient-to-r from-[#ef4444] to-[#b91c1c] text-white'
    : 'bg-gray-100 text-[#ef4444] hover:bg-gray-300 hover:text-[#b91c1c]' }}">
                <i class="fa-solid fa-clock-rotate-left w-5 h-5"></i>
                <span>Riwayat Aduan</span>
            </a>

              <!-- Riwayat Wbs -->
            <a href="{{ route('wbs_admin.aduan.riwayatwbs') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium transition-colors duration-200
           {{ request()->routeIs('wbs_admin.aduan.riwayatwbs')
    ? 'bg-gradient-to-r from-[#ef4444] to-[#b91c1c] text-white'
    : 'bg-gray-100 text-[#ef4444] hover:bg-gray-300 hover:text-[#b91c1c]' }}">
                <i class="fa-solid fa-folder-open w-5 h-5"></i>
                <span>Riwayat Wbs</span>
            </a>

            <!-- Profil -->
            <a href="{{ route('wbs_admin.profile.edit') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium transition-colors duration-200
           {{ request()->routeIs('wbs_admin.profile.edit')
    ? 'bg-gradient-to-r from-[#ef4444] to-[#b91c1c] text-white'
    : 'bg-gray-100 text-[#ef4444] hover:bg-gray-300 hover:text-[#b91c1c]' }}">
                <i class="fa-solid fa-user w-5 h-5"></i>
                <span>Profil</span>
            </a>

            <!-- Buat Aduan (desktop) -->
            <a href="{{ route('superadmin.beranda') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl font-medium transition-colors duration-200
           {{ request()->routeIs('superadmin.beranda')
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

        <!-- Riwayat dengan Submenu Accordion -->
        <div x-data="{ open: false }" class="relative">
            <!-- Tombol Riwayat -->
            <button @click="open = !open"
                class="flex flex-col items-center justify-center py-2 text-sm font-medium transition-all duration-300"
                :class="open || '{{ request()->routeIs('wbs_admin.aduan.riwayat') }}' 
            ? 'text-[#ef4444]' 
            : 'text-gray-500 hover:text-[#ef4444]'">

                <!-- Icon utama -->
                <i class="fa-solid fa-clock-rotate-left text-lg"></i>

                <!-- Label + panah -->
                <div class="flex items-center space-x-1 mt-1">
                    <span>Riwayat</span>
                    <i :class="open ? 'fa-chevron-up' : 'fa-chevron-down'"
                        class="fa-solid text-xs transition-transform duration-300"></i>
                </div>
            </button>

            <!-- Submenu Accordion -->
            <div x-cloak x-show="open" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                x-collapse
                class="absolute bottom-14 left-1/2 transform -translate-x-1/2 bg-white shadow-lg rounded-xl border border-gray-200 w-48 overflow-hidden">

                <!-- Panah di atas submenu -->
                <div class="absolute -top-2 left-1/2 transform -translate-x-1/2">
                    <div class="w-4 h-4 bg-white border-l border-t border-gray-200 rotate-45"></div>
                </div>

                <!-- Item submenu -->
                <a href="{{ route('wbs_admin.aduan.riwayat') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#ef4444] transition">
                    Riwayat Aduan
                </a>
                <a href="{{ route('wbs_admin.aduan.riwayatwbs') }}"
                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-[#ef4444] transition">
                    Riwayat WBS
                </a>
            </div>
        </div>

        <!-- Tombol Floating Buat Aduan -->
        <a href="{{ route('superadmin.beranda') }}"
            class="absolute -top-5 left-1/2 transform -translate-x-1/2 flex flex-col items-center group">
            <div class="bg-gradient-to-r from-red-600 to-red-500 text-white 
                w-14 h-14 rounded-full flex items-center justify-center 
                shadow-lg group-hover:scale-110 transition-all duration-300">
                <i class="fa-solid fa-plus text-xl"></i>
            </div>
            <span class="mt-1 text-xs font-medium text-[#ef4444]">Buat Aduan</span>
        </a>

        <!-- Profil -->
        <a href="{{ route('wbs_admin.profile.edit') }}" class="flex flex-col items-center justify-center py-2 text-sm font-medium
            {{ request()->routeIs('wbs_admin.profile.edit')
    ? 'text-[#ef4444] hover:text-[#ef4444] cursor-default'
    : 'text-gray-500 hover:text-[#ef4444]' }}">
            <i class="fa-solid fa-user text-lg"></i>
            <span>Profil</span>
        </a>
    </div>
</div>