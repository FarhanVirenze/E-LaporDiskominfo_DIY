<!-- Navbar Admin -->
<nav class="bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] py-3 text-white shadow-md relative z-50">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <!-- Logo dan Judul -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/logo-diy.png') }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
            <span class="text-xl font-bold tracking-wide">E-LAPOR DIY Admin</span>
        </a>

        <!-- Menu Navigasi -->
        <ul class="hidden lg:flex space-x-6 font-semibold tracking-wide">
            <li><a href="{{ route('beranda') }}" class="hover:underline hover:decoration-white">E-Lapor DIY</a></li>
            <li><a href="{{ route('admin.dashboard') }}" class="hover:underline hover:decoration-white">Dashboard</a></li>
            <li><a href="{{ route('admin.kelola-user.index') }}" class="hover:underline hover:decoration-white">Kelola User</a></li>
            <li><a href="{{ route('admin.kelola-aduan.index') }}" class="hover:underline hover:decoration-white">Kelola Aduan</a></li>
            <li><a href="{{ route('admin.kelola-kategori.index') }}" class="hover:underline hover:decoration-white">Kelola Kategori</a></li>
            <li><a href="{{ route('admin.kelola-wilayah.index') }}" class="hover:underline hover:decoration-white">Kelola Wilayah</a></li>

            @guest
                <li><a href="{{ route('login') }}" class="hover:underline hover:decoration-white">LOGIN</a></li>
            @endguest
        </ul>

        <!-- Settings Dropdown (Auth) -->
        @auth
            <div class="relative hidden lg:flex items-center">
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

                        <!-- Logout -->
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

        <!-- Toggle Mobile Menu -->
        <button id="toggle-menu" class="lg:hidden text-white">
            <svg class="fill-current h-6 w-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M4 5h12a1 1 0 010 2H4a1 1 0 010-2zM4 10h12a1 1 0 010 2H4a1 1 0 010-2zM4 15h12a1 1 0 010 2H4a1 1 0 010-2z"
                      clip-rule="evenodd" />
            </svg>
        </button>
    </div>

    <!-- Mobile Sidebar -->
    <div id="mobile-sidebar" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden">
        <div class="bg-[#B5332A] w-64 h-full px-4 py-6">
            <button id="close-menu" class="text-white text-2xl absolute top-4 right-4">×</button>
            <ul class="space-y-6 font-semibold tracking-wide mt-10">
                <li><a href="{{ route('beranda') }}" class="hover:underline hover:decoration-white">E-Lapor DIY</a></li>
                <li><a href="{{ route('admin.dashboard') }}" class="hover:underline hover:decoration-white">Dashboard</a></li>
                <li><a href="{{ route('admin.kelola-user.index') }}" class="hover:underline hover:decoration-white">Kelola User</a></li>
                <li><a href="{{ route('admin.kelola-aduan.index') }}" class="hover:underline hover:decoration-white">Kelola Aduan</a></li>
                <li><a href="{{ route('admin.kelola-kategori.index') }}" class="hover:underline hover:decoration-white">Kelola Kategori</a></li>
                <li><a href="{{ route('admin.kelola-wilayah.index') }}" class="hover:underline hover:decoration-white">Kelola Wilayah</a></li>

                @guest
                    <li><a href="{{ route('login') }}" class="hover:underline hover:decoration-white">LOGIN</a></li>
                @endguest

                @auth
                    <li><a href="{{ route('user.profile.edit') }}" class="hover:underline hover:decoration-white">Profile</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left hover:underline hover:decoration-white">Log Out</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Mobile Menu Script -->
<script>
    const toggleMenuButton = document.getElementById('toggle-menu');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const closeMenuButton = document.getElementById('close-menu');

    toggleMenuButton?.addEventListener('click', () => {
        mobileSidebar.classList.remove('hidden');
    });

    closeMenuButton?.addEventListener('click', () => {
        mobileSidebar.classList.add('hidden');
    });
</script>
