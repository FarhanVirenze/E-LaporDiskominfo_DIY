<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full z-50 bg-white shadow-md text-gray-700">
    <div class="container mx-auto px-4 py-3 relative flex items-center justify-between">

        <!-- Logo (Kiri) -->
        <a href="{{ url('/') }}" class="flex items-center space-x-2">
            <img src="{{ asset('images/logo-diy.png') }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
            <span class="text-xl font-bold tracking-wide text-gray-700">E-LAPOR DIY</span>
        </a>

        <!-- Menu Desktop (Tengah) -->
        <ul class="hidden lg:flex absolute left-1/2 transform -translate-x-1/2 space-x-2 font-bold items-center">

            <!-- Daftar Aduan -->
            <li>
                <a href="{{ route('daftar-aduan') }}" class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                {{ request()->routeIs('daftar-aduan')
    ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white'
    : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                    <i
                        class="fas fa-list text-[17px] w-5 {{ request()->routeIs('daftar-aduan') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                    <span>Daftar Aduan</span>
                </a>
            </li>

            <!-- WBS -->
            <li>
                <a href="{{ route('wbs.index') }}" class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                {{ request()->routeIs('wbs.index')
    ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white'
    : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                    <i
                        class="fas fa-user-secret text-[17px] w-5 {{ request()->routeIs('wbs.index') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                    <span>WBS</span>
                </a>
            </li>

            <!-- Tentang Kami -->
            <li>
                <a href="{{ route('tentang') }}" class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                {{ request()->routeIs('tentang')
    ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white'
    : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                    <i
                        class="fas fa-info-circle text-[17px] w-5 {{ request()->routeIs('tentang') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                    <span>Tentang Kami</span>
                </a>
            </li>

            @guest
                    <!-- Login -->
                    <li>
                        <a href="{{ route('login') }}" class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                                                                                                                                                            {{ request()->routeIs('login')
                ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white'
                : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                            <i
                                class="fas fa-sign-in-alt text-[17px] w-5 {{ request()->routeIs('login') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                            <span>Login</span>
                        </a>
                    </li>
            @endguest

            @auth
                @if (Auth::user()->role === 'admin')
                    <!-- Kelola Admin -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                                                                      {{ request()->routeIs('admin.dashboard')
                    ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white'
                    : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                            <i
                                class="fas fa-tools text-[17px] w-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                            <span
                                class="{{ request()->routeIs('admin.dashboard') ? 'text-white' : 'group-hover:text-red-600' }}">Kelola
                                Admin</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role === 'superadmin')
                    <!-- Kelola Superadmin -->
                    <li>
                        <a href="{{ route('superadmin.dashboard') }}" class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                                                                                                  {{ request()->routeIs('superadmin.dashboard')
                    ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white'
                    : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                            <i
                                class="fas fa-user-cog text-[17px] w-5 {{ request()->routeIs('superadmin.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                            <span
                                class="{{ request()->routeIs('superadmin.dashboard') ? 'text-white' : 'group-hover:text-red-600' }}">Kelola
                                Superadmin</span>
                        </a>
                    </li>
                @endif
            @endauth

        </ul>

        <!-- Avatar / Dropdown Accordion -->
        <div class="hidden lg:flex items-center space-x-3">
            @auth
                    <div x-data="{ open: false }" class="relative">
                        <!-- Trigger -->
                        <button @click="open = !open"
                            class="flex items-center bg-white px-4 py-1 text-sm rounded-md border border-gray-300 shadow hover:bg-gray-100 transition-all space-x-3">
                            <div class="text-gray-800 text-sm font-medium whitespace-nowrap">
                                {{ Auth::user()->name }} <span class="mx-1 text-gray-800">|</span>
                                {{ Auth::user()->nik }}
                            </div>
                            <img src="{{ Auth::user()->foto
                ? asset('storage/' . Auth::user()->foto)
                : (Auth::user()->avatar
                    ? Auth::user()->avatar
                    : asset('images/avatar.jpg')) }}" alt="Avatar"
                                class="h-8 w-8 object-cover rounded-full border border-gray-300 bg-white shadow" />
                            <svg class="w-4 h-4 text-[#0F3D3E] transition-transform" :class="{ 'rotate-180': open }"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Menu Accordion -->
                        <div x-show="open" x-cloak @click.outside="open = false" x-transition
                            class="absolute right-0 mt-2 w-64 bg-white rounded-md shadow-xl border border-gray-200 overflow-hidden z-50">
                            <!-- Tombol Profil -->
                            <a href="{{ route('user.profile.edit') }}" class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                  {{ request()->routeIs('user.profile.edit')
                ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white'
                : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                                <i
                                    class="fas fa-user text-[17px] w-5 {{ request()->routeIs('user.profile.edit') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                                <span>Profil</span>
                            </a>

                            <!-- Tombol Logout -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="group w-full text-left flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                           hover:bg-red-100 hover:text-red-600 text-gray-800">
                                    <i class="fas fa-sign-out-alt text-[17px] w-5 text-gray-500 group-hover:text-red-600"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </div>
                    </div>
            @endauth
        </div>

        <!-- Toggle Mobile (Kanan) -->
        <button class="lg:hidden focus:outline-none" id="navbar-toggler">
            <i class="fas fa-bars text-2xl mr-5 text-gray-700" id="navbar-toggler-icon"></i>
        </button>
    </div>

    <!-- MENU MOBILE -->
    <div id="navbar-sidebar"
        class="lg:hidden overflow-hidden max-h-0 opacity-0 transition-all duration-500 ease-in-out">
        <ul class="bg-white px-2 py-2 space-y-2">
            <li>
                <a href="{{ route('daftar-aduan') }}"
                    class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                {{ request()->routeIs('daftar-aduan') ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white' : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                    <i
                        class="fas fa-list text-[17px] w-5 {{ request()->routeIs('daftar-aduan') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                    <span>Daftar Aduan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('wbs.index') }}"
                    class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                {{ request()->routeIs('wbs.index') ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white' : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                    <i
                        class="fas fa-user-secret text-[17px] w-5 {{ request()->routeIs('wbs.index') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                    <span>Wbs</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tentang') }}"
                    class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                {{ request()->routeIs('tentang') ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white' : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                    <i
                        class="fas fa-info-circle text-[17px] w-5 {{ request()->routeIs('tentang') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                    <span>Tentang Kami</span>
                </a>
            </li>

            @guest
                <li>
                    <a href="{{ route('login') }}"
                        class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                                                                                                                                                        {{ request()->routeIs('login') ? 'bg-gradient-to-b from-[#2962FF] to-[#0039CB] text-white' : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                        <i
                            class="fas fa-sign-in-alt text-[17px] w-5 {{ request()->routeIs('login') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                        <span>Login</span>
                    </a>
                </li>
            @endguest

            @auth
                    @if (Auth::user()->role === 'admin')
                        <li>
                            <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                                                                                                              {{ request()->routeIs('admin.dashboard')
                        ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white'
                        : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                                <i
                                    class="fas fa-tools text-[17px] w-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                                <span
                                    class="{{ request()->routeIs('admin.dashboard') ? 'text-white' : 'group-hover:text-red-600' }}">Kelola
                                    Admin</span>
                            </a>
                        </li>
                    @endif

                    @if (Auth::user()->role === 'superadmin')
                        <li>
                            <a href="{{ route('superadmin.dashboard') }}" class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                                                                                                                                      {{ request()->routeIs('superadmin.dashboard')
                        ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white'
                        : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                                <i
                                    class="fas fa-user-cog text-[17px] w-5 {{ request()->routeIs('superadmin.dashboard') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                                <span
                                    class="{{ request()->routeIs('superadmin.dashboard') ? 'text-white' : 'group-hover:text-red-600' }}">Kelola
                                    Superadmin</span>
                            </a>
                        </li>
                    @endif

                    <!-- Avatar + Profil & Logout di Sidebar (Accordion Style) -->
                    <li class="pt-2 border-t border-gray-200">
                        <div x-data="{ open: false }">
                            <!-- Trigger -->
                            <button @click="open = !open"
                                class="flex items-center gap-3 w-full px-2 py-2 rounded-lg transition
                                                                                                                                                                                           hover:bg-red-100 hover:text-red-600"
                                :class="{ 'bg-red-50 text-red-700 shadow-sm': open }">
                                <img src="{{ Auth::user()->foto
                ? asset('storage/' . Auth::user()->foto)
                : (Auth::user()->avatar
                    ? Auth::user()->avatar
                    : asset('images/avatar.jpg')) }}" alt="Avatar"
                                    class="h-10 w-10 rounded-full object-cover border-2 border-red-800 bg-white shadow" />
                                <div class="flex flex-col text-left flex-1">
                                    <span class="text-gray-700 font-semibold text-md leading-tight"
                                        :class="{ 'text-blue-700': open }">
                                        {{ Auth::user()->name }}
                                    </span>
                                    <span class="text-gray-500 text-sm capitalize leading-tight">
                                        {{ Auth::user()->nik }}
                                    </span>
                                </div>
                                <!-- Icon Chevron -->
                                <i class="fas fa-chevron-down text-gray-500 transition-transform duration-300"
                                    :class="{ 'rotate-180 text-red-700': open }"></i>
                            </button>

                            <!-- Menu Dropdown -->
                            <div x-show="open" x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-40"
                                x-transition:leave="transition ease-in duration-200"
                                x-transition:leave-start="opacity-100 max-h-40" x-transition:leave-end="opacity-0 max-h-0"
                                class="overflow-hidden mt-2 space-y-1">

                                <!-- Tombol Profil -->
                                <a href="{{ route('user.profile.edit') }}" class="group flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                          {{ request()->routeIs('user.profile.edit')
                ? 'bg-gradient-to-b from-[#FF5252] to-[#B71C1C] text-white'
                : 'hover:bg-red-100 hover:text-red-600 text-gray-800' }}">
                                    <i
                                        class="fas fa-user text-[17px] w-5 {{ request()->routeIs('user.profile.edit') ? 'text-white' : 'text-gray-500 group-hover:text-red-600' }}"></i>
                                    <span>Profil</span>
                                </a>

                                <!-- Tombol Logout -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="group w-full text-left flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                                   hover:bg-red-100 hover:text-red-600 text-gray-800">
                                        <i
                                            class="fas fa-sign-out-alt text-[17px] w-5 text-gray-500 group-hover:text-red-600"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </li>
            @endauth
        </ul>
    </div>
</nav>

<!-- Spacer -->
<div class="h-[80px]"></div>

<!-- Script Toggle -->
<script>
    document.getElementById("navbar-toggler").addEventListener("click", function () {
        const menu = document.getElementById("navbar-sidebar");
        const icon = document.getElementById("navbar-toggler-icon");

        if (menu.classList.contains("max-h-0")) {
            // Buka
            menu.classList.remove("max-h-0", "opacity-0");
            menu.classList.add("max-h-screen", "opacity-100");
            icon.classList.remove("fa-bars");
            icon.classList.add("fa-times");
        } else {
            // Tutup
            menu.classList.remove("max-h-screen", "opacity-100");
            menu.classList.add("max-h-0", "opacity-0");
            icon.classList.remove("fa-times");
            icon.classList.add("fa-bars");
        }
    });
</script>