<!-- Layout Wrapper -->
<div class="flex min-h-screen bg-gray-100 text-white">

    <!-- Sidebar -->
    <aside id="sidebar" class="bg-white w-72 flex flex-col fixed inset-y-0 left-0 z-50 text-gray-800 
               transform transition-transform duration-300 -translate-x-full">

        <!-- Sidebar Header -->
        <div class="bg-gradient-to-b from-red-700 to-red-800 text-white flex items-center justify-between px-6"
            style="padding-top: 16px; padding-bottom: 20px;">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-diy.png') }}" class="h-14 ml-2" />
                <span class="text-lg font-semibold">E-LAPOR DIY</span>
            </div>
        </div>
        
        <!-- Sidebar Menu -->
        <nav class="flex-1 overflow-y-auto px-4 py-5 text-[15px] space-y-6 shadow-lg scrollbar-hide">
            <!-- MAIN -->
            <div class="space-y-2">
                <p class="text-[11px] uppercase text-red-600 font-bold tracking-wide mb-2">Main</p>

                <a href="{{ route('superadmin.beranda') }}"
                    class="flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
            {{ request()->routeIs('superadmin.beranda') ? 'bg-gradient-to-b from-red-700 to-red-800 text-white' : 'hover:bg-red-100 hover:text-red-700 text-gray-800' }}">
                    <i
                        class="fas fa-home text-[17px] w-5 {{ request()->routeIs('superadmin.beranda') ? 'text-white' : 'hover:text-red-700 text-gray-500' }}"></i>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('wbs_admin.dashboard') }}"
                    class="flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
            {{ request()->routeIs('wbs_admin.dashboard') ? 'bg-gradient-to-b from-red-700 to-red-800 text-white' : 'hover:bg-red-100 hover:text-red-700 text-gray-800' }}">
                    <i
                        class="fas fa-chart-bar text-[17px] w-5 {{ request()->routeIs('wbs_admin.dashboard') ? 'text-white' : 'hover:text-red-700 text-gray-500' }}"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- ADMIN -->
            <div class="space-y-2">
                <p class="text-[11px] uppercase text-red-600 font-bold tracking-wide mb-2">Admin</p>

                @php
                    $menus = [
                        ['route' => 'superadmin.kelola-aduan.*', 'icon' => 'fa-comments', 'label' => 'Kelola Aduan', 'url' => route('wbs_admin.kelola-aduan.index')],
                    ];
                @endphp

                @foreach($menus as $menu)
                    <a href="{{ $menu['url'] }}"
                        class="flex items-center justify-between px-4 py-[10px] rounded-lg transition font-medium
                        {{ request()->routeIs($menu['route']) ? 'bg-gradient-to-b from-red-700 to-red-800 text-white' : 'hover:bg-red-100 hover:text-red-700 text-gray-800' }}">

                        <div class="flex items-center gap-4">
                            <i
                                class="fas {{ $menu['icon'] }} text-[17px] w-5 
                                {{ request()->routeIs($menu['route']) ? 'text-white' : 'hover:text-red-700 text-gray-500' }}"></i>
                            <span>{{ $menu['label'] }}</span>
                        </div>

                        {{-- Badge notifikasi khusus Kelola Aduan --}}
                        @if ($menu['label'] === 'Kelola Aduan' && $newReportsCount > 0)
                            <span class="ml-auto bg-red-600 text-white text-xs font-semibold px-2 py-0.5 rounded-full">
                                {{ $newReportsCount }}
                            </span>
                        @endif
                    </a>
                @endforeach
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div id="mainContent" class="flex-1 lg:ml-72 w-full transition-all duration-300">

        <!-- Navbar Desktop -->
        <nav
            class="bg-gradient-to-b from-red-700 to-red-800 py-4 px-6 flex items-center sticky top-0 z-40 hidden lg:flex">

            <!-- Kiri: Toggle Sidebar + Search -->
            <div class="flex items-center gap-4 w-full">
                <!-- Toggle Sidebar -->
                <button id="toggleSidebar"
                    class="bg-gradient-to-b from-red-700 to-red-800 text-white text-xl p-2 rounded-md shadow-md focus:outline-none">
                    <i class="fas fa-bars"></i>
                </button>

                <!-- Profile -->
                <div class="flex items-center ml-auto">
                    @auth
                                    <x-dropdown align="right" width="56">
                                        <x-slot name="trigger">
                                            <button
                                                class="flex items-center bg-white px-4 py-1 text-sm rounded-md border border-white shadow hover:bg-red-100 transition-all space-x-3">

                                                <!-- Nama + NIK -->
                                                <div class="text-red-700 text-sm font-medium whitespace-nowrap">
                                                    {{ Auth::user()->name }} <span class="mx-1 text-red-700">|</span>
                                                    {{ Auth::user()->nik }}
                                                </div>

                                                <!-- Avatar -->
                                                @if (Auth::user()->foto)
                                                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Avatar"
                                                        class="h-8 w-8 object-cover rounded-full border-2 border-white shadow" />
                                                @else
                                                    <img src="{{ asset('images/avatar.jpg') }}" alt="Avatar"
                                                        class="h-8 w-8 object-cover rounded-full border-2 border-white shadow" />
                                                @endif

                                                <!-- Chevron -->
                                                <i class="fas fa-chevron-down text-xs text-red-700 mr-3"></i>
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <!-- Header Profil -->
                                            <div class="px-4 pt-3 pb-2 text-sm text-gray-700">
                                                <div class="flex flex-col items-center text-center">
                                                    @if (Auth::user()->foto)
                                                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Avatar"
                                                            class="h-14 w-14 rounded-full object-cover border border-gray-300 mb-2 bg-white" />
                                                    @else
                                                        <img src="{{ asset('images/avatar.jpg') }}" alt="Avatar"
                                                            class="h-14 w-14 rounded-full object-cover border border-gray-300 mb-2 bg-white" />
                                                    @endif

                                                    <div class="text-red-700 font-semibold">{{ Auth::user()->name }}</div>
                                                    <div class="text-red-700 text-xs capitalize">{{ Auth::user()->nik }}</div>
                                                </div>
                                            </div>

                                            <!-- Divider -->
                                            <div class="border-t border-gray-100 my-1"></div>

                                            <!-- Menu Profil -->
                                            <a href="{{ route('superadmin.profile.edit') }}" class="flex items-center gap-3 px-4 py-[10px] rounded-lg transition font-medium
                                                                {{ request()->routeIs('superadmin.profile.edit')
                        ? 'bg-gradient-to-b from-red-700 to-red-800 text-white'
                        : 'text-gray-800 hover:bg-red-100 hover:text-red-700' }}">
                                                <i class="fas fa-user text-[16px] w-5 
                                                                {{ request()->routeIs('superadmin.profile.edit')
                        ? 'text-white'
                        : 'text-gray-500 group-hover:text-red-700' }}"></i>
                                                <span>Profil</span>
                                            </a>

                                            <!-- Menu Logout -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-[10px] rounded-lg transition font-medium 
                                                                    text-gray-800 hover:bg-red-100 hover:text-red-700">
                                                    <i
                                                        class="fas fa-sign-out-alt text-[16px] w-5 text-gray-500 group-hover:text-red-700"></i>
                                                    <span>Logout</span>
                                                </button>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                    @endauth
                </div>
        </nav>

        <!-- Navbar Mobile -->
        <nav
            class="bg-gradient-to-b from-red-700 to-red-800 py-4 px-6 flex items-center justify-between sticky top-0 z-50 lg:hidden">

            <!-- Kiri: Logo + Toggle -->
            <div class="flex items-center gap-3">
                <!-- Logo -->
                <img src="{{ asset('images/logo-diy.png') }}" class="h-14" />
                <span class="text-lg font-semibold text-white">E-LAPOR DIY</span>

                <!-- Toggle Sidebar -->
                <button id="toggleSidebarMobile"
                    class="text-white text-xl p-2 ml-3 rounded-md shadow-md focus:outline-none bg-white/20 hover:bg-red-200/30">
                    <i class="fas fa-bars"></i>
                </button>
            </div>

            <!-- Kanan: Foto Profil + Dropdown -->
            @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center bg-white/20 px-1 py-1 text-sm rounded-full border border-white/50 hover:bg-red-200/30 transition-all space-x-3 shadow-sm backdrop-blur-md">
                                @if (Auth::user()->foto)
                                    <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="User Avatar"
                                        class="h-11 w-11 rounded-full object-cover border-2 border-white shadow-sm" />
                                @else
                                    <img src="{{ asset('images/avatar.jpg') }}" alt="Default Avatar"
                                        class="h-11 w-11 rounded-full object-cover border-2 border-white shadow-sm" />
                                @endif
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Header Profil -->
                            <div class="px-4 pt-3 pb-2 text-sm text-gray-700">
                                <div class="flex flex-col items-center text-center">
                                    @if (Auth::user()->foto)
                                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" alt="Avatar"
                                            class="h-14 w-14 rounded-full object-cover border border-gray-300 mb-2 bg-white" />
                                    @else
                                        <img src="{{ asset('images/avatar.jpg') }}" alt="Avatar"
                                            class="h-14 w-14 rounded-full object-cover border border-gray-300 mb-2 bg-white" />
                                    @endif

                                    <div class="text-red-600 font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-red-600 text-xs capitalize">{{ Auth::user()->nik }}</div>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="border-t border-gray-100 my-1"></div>

                            <!-- Menu Profil -->
                            <a href="{{ route('superadmin.profile.edit') }}" class="flex items-center gap-3 px-4 py-[10px] rounded-lg transition font-medium
                                    {{ request()->routeIs('superadmin.profile.edit')
                ? 'bg-gradient-to-b from-red-700 to-red-800 text-white'
                : 'text-gray-800 hover:bg-red-100 hover:text-red-600' }}">
                                <i class="fas fa-user text-[16px] w-5
                                    {{ request()->routeIs('superadmin.profile.edit')
                ? 'text-white'
                : 'text-gray-500 group-hover:text-red-600' }}"></i>
                                <span>Profil</span>
                            </a>

                            <!-- Menu Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left flex items-center gap-3 px-4 py-[10px] rounded-lg transition font-medium 
                                        text-gray-800 hover:bg-red-100 hover:text-red-600">
                                    <i class="fas fa-sign-out-alt text-[16px] w-5 text-gray-500 group-hover:text-red-600"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
            @endauth

        </nav>

        <!-- Page Content -->
        <main class="p-6 bg-gray-50 min-h-screen text-gray-900">
            @yield('content')
        </main>
    </div>
</div>

<!-- Toggle Script -->
<script>
    const toggleSidebar = document.getElementById('toggleSidebar');
    const toggleSidebarMobile = document.getElementById('toggleSidebarMobile');
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        mainContent.classList.add('lg:ml-72');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        mainContent.classList.remove('lg:ml-72');
    }

    function toggleSidebarAction() {
        if (sidebar.classList.contains('-translate-x-full')) {
            openSidebar();
        } else {
            closeSidebar();
        }
    }

    toggleSidebar?.addEventListener('click', toggleSidebarAction);
    toggleSidebarMobile?.addEventListener('click', toggleSidebarAction);

    // Atur default saat load
    window.addEventListener('DOMContentLoaded', () => {
        if (window.innerWidth >= 1024) {
            openSidebar(); // desktop default open
        } else {
            closeSidebar(); // mobile default closed
        }
    });

    // Auto adjust saat resize
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 1024) {
            openSidebar();
        } else {
            closeSidebar();
        }
    });
</script>