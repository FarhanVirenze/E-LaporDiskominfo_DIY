<!-- Navbar -->
<nav class="bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] py-4 text-white shadow-md">
    <div class="container mx-auto px-6 flex items-center justify-between">
        <!-- Logo dan Judul -->
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/logo-diy.png') }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
            <span class="text-xl font-bold tracking-wide">E-LAPOR DIY</span>
        </a>

        <!-- Tombol Toggle (Mobile) -->
        <button class="md:hidden text-white" id="navbar-toggler">
            <i class="fas fa-bars" id="navbar-toggler-icon"></i>
        </button>

        <!-- Menu Navigasi (Desktop) -->
        <div class="hidden md:flex space-x-8 font-bold" id="navbar-menu">
            <ul class="flex space-x-8">
                <li><a href="{{ route('daftar-aduan') }}" class="hover:underline">DAFTAR ADUAN</a></li>
                <li><a href="{{ route('wbs.index') }}" class="hover:underline">WBS</a></li>
                <li><a href="{{ route('tentang') }}" class="hover:underline">TENTANG KAMI</a></li>

                <!-- Menampilkan menu Login hanya jika user belum login -->
                @guest
                    <li><a href="{{ route('login') }}" class="hover:underline">LOGIN</a></li>
                @endguest

                @auth
                    @if (Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:underline">KELOLA ADMIN</a></li>
                    @endif
                @endauth

                 @auth
                    @if (Auth::user()->role === 'superadmin')
                        <li><a href="{{ route('superadmin.dashboard') }}" class="hover:underline">KELOLA SUPERADMIN</a></li>
                    @endif
                @endauth
            </ul>
        </div>

        <!-- Settings Dropdown (Auth) - Desktop -->
        @auth
            <div class="relative hidden md:flex items-center">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-white text-sm font-medium rounded-md text-black bg-white hover:text-gray-700 focus:outline-none transition">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('user.profile.edit')" class="text-black">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="text-black">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        @endauth
    </div>

    <!-- Sidebar Menu for Mobile -->
    <div class="md:hidden hidden transition-all duration-300 ease-in-out" id="navbar-sidebar">
        <ul class="bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] p-4 space-y-2">
            <li><a href="{{ route('daftar-aduan') }}" class="block py-2 px-4 text-white rounded-lg hover:bg-blue-700 transition-all">DAFTAR ADUAN</a></li>
            <li><a href="{{ route('wbs.index') }}" class="block py-2 px-4 text-white rounded-lg hover:bg-blue-700 transition-all">WBS</a></li>
            <li><a href="{{ route('tentang') }}" class="block py-2 px-4 text-white rounded-lg hover:bg-blue-700 transition-all">TENTANG KAMI</a></li>

            @guest
                <li><a href="{{ route('login') }}" class="block py-2 px-4 text-white rounded-lg hover:bg-blue-700 transition-all">LOGIN</a></li>
            @endguest

            @auth
                @if (Auth::user()->role === 'admin')
                    <li><a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 text-white rounded-lg hover:bg-blue-700 transition-all">KELOLA ADMIN</a></li>
                @endif
            @endauth

            <!-- Settings Dropdown (Auth) - Mobile -->
            @auth
                <li>
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="ml-4 mt-1 inline-flex items-center px-3 py-2 border border-white text-sm font-medium rounded-md text-black bg-white hover:text-gray-700 focus:outline-none transition">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('user.profile.edit')" class="text-black">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();" class="text-black">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </li>
            @endauth
        </ul>
    </div>
</nav>

<!-- Script Toggle -->
<script>
    document.getElementById("navbar-toggler").addEventListener("click", function () {
        const menu = document.getElementById("navbar-sidebar");
        const icon = document.getElementById("navbar-toggler-icon");

        // Toggle the sidebar menu
        menu.classList.toggle("hidden");

        // Toggle antara bars dan times icon
        if (menu.classList.contains("hidden")) {
            icon.classList.remove("fa-times");
            icon.classList.add("fa-bars");
        } else {
            icon.classList.remove("fa-bars");
            icon.classList.add("fa-times");
        }
    });
</script>
