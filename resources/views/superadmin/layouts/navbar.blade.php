<!-- Layout Wrapper -->
<div class="flex min-h-screen bg-gray-100 text-white">

    <!-- Sidebar -->
    <aside id="sidebar"
        class="bg-white w-72 flex flex-col fixed inset-y-0 left-0 z-50 text-gray-800 transition-transform duration-300 sidebar-visible">

        <!-- Sidebar Header -->
        <div class="bg-[#2962FF] text-white flex items-center justify-between px-6"
            style="padding-top: 16px; padding-bottom: 20px;">
            <div class="flex items-center gap-3">
                <img src="{{ asset('images/logo-diy.png') }}" class="h-12" />
                <span class="text-lg font-semibold">E-LAPOR DIY</span>
            </div>
            <button id="toggleSidebar"
                class="bg-[#2962FF] text-white text-xl p-2 rounded-md shadow-md focus:outline-none">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <!-- Sidebar Menu -->
        <nav class="flex-1 overflow-y-auto px-4 py-5 text-sm space-y-6 shadow-lg scrollbar-hide">
            <!-- MAIN -->
            <div class="space-y-2">
                <p class="text-[11px] uppercase text-blue-600 font-bold tracking-wide mb-2">Main</p>

                <a href="{{ route('superadmin.beranda') }}"
                    class="flex items-center gap-4 px-4 py-2 rounded-lg transition font-medium
               {{ request()->routeIs('superadmin.beranda') ? 'bg-blue-600 text-white' : 'hover:bg-blue-100 hover:text-blue-600 text-gray-800' }}">
                    <i
                        class="fas fa-home text-base w-5 {{ request()->routeIs('superadmin.beranda') ? 'text-white' : 'hover:text-blue-600 text-gray-500' }}"></i>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('superadmin.dashboard') }}"
                    class="flex items-center gap-4 px-4 py-2 rounded-lg transition font-medium
               {{ request()->routeIs('superadmin.dashboard') ? 'bg-blue-600 text-white' : 'hover:bg-blue-100 hover:text-blue-600 text-gray-800' }}">
                    <i
                        class="fas fa-chart-bar text-base w-5 {{ request()->routeIs('superadmin.dashboard') ? 'text-white' : 'hover:text-blue-600 text-gray-500' }}"></i>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- ADMIN -->
            <div class="space-y-2">
                <p class="text-[11px] uppercase text-blue-600 font-bold tracking-wide mb-2">Admin</p>

                @php
                    $menus = [
                        ['route' => 'superadmin.kelola-user.*', 'icon' => 'fa-users-cog', 'label' => 'Kelola User', 'url' => route('superadmin.kelola-user.index')],
                        ['route' => 'superadmin.kelola-aduan.*', 'icon' => 'fa-comments', 'label' => 'Kelola Aduan', 'url' => route('superadmin.kelola-aduan.index')],
                        ['route' => 'superadmin.kelola-kategori.*', 'icon' => 'fa-tags', 'label' => 'Kelola Kategori', 'url' => route('superadmin.kelola-kategori.index')],
                        ['route' => 'superadmin.kategori-admin.*', 'icon' => 'fa-user-shield', 'label' => 'Kategori Admin', 'url' => route('superadmin.kategori-admin.index')],
                        ['route' => 'superadmin.kelola-wilayah.*', 'icon' => 'fa-map-marker-alt', 'label' => 'Wilayah', 'url' => route('superadmin.kelola-wilayah.index')],
                    ];
                @endphp

                @foreach($menus as $menu)
                    <a href="{{ $menu['url'] }}"
                        class="flex items-center gap-4 px-4 py-2 rounded-lg transition font-medium
                                                   {{ request()->routeIs($menu['route']) ? 'bg-blue-600 text-white' : 'hover:bg-blue-100 hover:text-blue-600 text-gray-800' }}">
                        <i
                            class="fas {{ $menu['icon'] }} text-base w-5 {{ request()->routeIs($menu['route']) ? 'text-white' : 'hover:text-blue-600 text-gray-500' }}"></i>
                        <span>{{ $menu['label'] }}</span>
                    </a>
                @endforeach
            </div>

            <!-- SETTING -->
            @auth
                <div class="space-y-2">
                    <p class="text-[11px] uppercase text-blue-600 font-bold tracking-wide mt-4 mb-2">Setting</p>

                    <a href="{{ route('superadmin.profile.edit') }}"
                        class="flex items-center gap-4 px-4 py-2 rounded-lg transition font-medium
                                                   {{ request()->routeIs('superadmin.profile.edit') ? 'bg-blue-600 text-white' : 'hover:bg-blue-100 hover:text-blue-600 text-gray-800' }}">
                        <i
                            class="fas fa-user text-base w-5 {{ request()->routeIs('superadmin.profile.edit') ? 'text-white' : 'hover:text-blue-600 text-gray-500' }}"></i>
                        <span>Profil</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full text-left flex items-center gap-4 px-4 py-2 rounded-lg transition font-medium hover:bg-blue-100 hover:text-blue-600 text-gray-800">
                            <i class="fas fa-sign-out-alt text-base w-5 text-gray-500 hover:text-blue-600"></i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            @endauth
        </nav>
    </aside>

    <!-- Toggle Button (outside sidebar, shown when sidebar is hidden) -->
    <button id="toggleSidebarOutside"
        class="fixed top-4 left-8 z-50 bg-[#2962FF] text-white text-xl p-2 rounded-md shadow-md focus:outline-none hidden">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Main Content -->
    <div id="mainContent" class="flex-1 lg:ml-72 w-full transition-all duration-300">

        <!-- Navbar -->
        <nav class="bg-[#2962FF] py-4 px-6 flex items-center justify-between sticky top-0 z-40">

            <!-- Left: Kosong -->
            <div></div>

            <!-- Right: Search & Icons -->
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" placeholder="Search..."
                        class="rounded-full text-sm px-4 py-1 text-gray-900 bg-white focus:outline-none placeholder-gray-400" />
                    <i class="fas fa-search absolute right-3 top-2 text-gray-400 text-sm"></i>
                </div>

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-3 py-2 bg-white text-[#2962FF] text-sm font-medium rounded-md hover:bg-gray-100 transition">
                                <span>{{ Auth::user()->name }}</span>
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <x-dropdown-link :href="route('superadmin.profile.edit')">Profil</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>
        </nav>

        <!-- Page Content -->
        <main class="p-6 bg-gray-50 min-h-screen text-gray-900">
            @yield('content')
        </main>
    </div>
</div>

<!-- Toggle Sidebar -->
<script>
    const toggleSidebar = document.getElementById('toggleSidebar'); // dalam sidebar
    const toggleSidebarOutside = document.getElementById('toggleSidebarOutside'); // luar sidebar
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');

    let isSidebarVisible = true;

    function toggleSidebarAction() {
        if (isSidebarVisible) {
            sidebar.classList.remove('sidebar-visible');
            sidebar.classList.add('sidebar-hidden');
            mainContent.classList.remove('lg:ml-72');
            toggleSidebarOutside.classList.remove('hidden');
        } else {
            sidebar.classList.remove('sidebar-hidden');
            sidebar.classList.add('sidebar-visible');
            mainContent.classList.add('lg:ml-72');
            toggleSidebarOutside.classList.add('hidden');
        }
        isSidebarVisible = !isSidebarVisible;
    }

    toggleSidebar?.addEventListener('click', toggleSidebarAction);
    toggleSidebarOutside?.addEventListener('click', toggleSidebarAction);

    window.addEventListener('DOMContentLoaded', () => {
        sidebar.classList.add('sidebar-visible');
        toggleSidebarOutside.classList.add('hidden');
    });
</script>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">