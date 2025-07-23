<!-- Navbar -->
<nav class="bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] py-4 text-white shadow-md">
    <div class="container mx-auto px-4 flex items-center justify-between">
        <!-- Logo dan Judul -->
        <a href="{{ url('/') }}" class="flex items-center space-x-3">
            <img src="{{ asset('images/logo-diy.png') }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
            <span class="text-xl font-bold tracking-wide">E-LAPOR DIY</span>
        </a>

        <!-- Menu Navigasi -->
        <ul class="flex space-x-6 font-bold">
            <li><a href="{{ route('daftar-aduan') }}" class="hover:underline">DAFTAR ADUAN</a></li>
            <li><a href="{{ route('wbs.index') }}" class="hover:underline">WBS</a></li>
            <li><a href="{{ route('tentang') }}" class="hover:underline">TENTANG KAMI</a></li>

            <!-- Menampilkan menu Login hanya jika user belum login -->
            @guest
                <li><a href="{{ route('login') }}" class="hover:underline">LOGIN</a></li>
            @endguest
        </ul>

        <!-- Settings Dropdown (Auth) -->
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
</nav>
