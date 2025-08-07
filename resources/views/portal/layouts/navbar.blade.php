<!-- Navbar -->
<nav class="fixed top-0 left-0 w-full z-50 bg-white shadow-md text-gray-700">
    <div class="container mx-auto px-6 py-4 flex items-center justify-between">

        <!-- KIRI (Logo + Toggle Mobile) -->
        <div class="flex items-center space-x-4">
            <a href="{{ url('/') }}" class="flex items-center space-x-2">
                <img src="{{ asset('images/logo-diy.png') }}" alt="Logo" class="h-12 w-auto drop-shadow-md">
                <span class="text-xl font-bold tracking-wide text-gray-700">E-LAPOR DIY</span>
            </a>

            <!-- Toggle Mobile -->
            <button class="lg:hidden focus:outline-none" id="navbar-toggler">
                <i class="fas fa-bars text-xl text-gray-700" id="navbar-toggler-icon"></i>
            </button>
        </div>

        <!-- TENGAH (Menu Desktop) -->
        <div class="hidden lg:flex flex-1 justify-center">
            <ul class="flex space-x-8 font-bold items-center">
                <li><a href="{{ route('daftar-aduan') }}" class="hover:text-blue-700 transition">DAFTAR ADUAN</a></li>
                <li><a href="{{ route('wbs.index') }}" class="hover:text-blue-700 transition">WBS</a></li>
                <li><a href="{{ route('tentang') }}" class="hover:text-blue-700 transition">TENTANG KAMI</a></li>

                @guest
                    <li><a href=" {{ route('login') }}" class="hover:text-blue-700 transition">LOGIN</a></li>
                @endguest

                @auth
                    @if (Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-blue-500 transition">KELOLA ADMIN</a>
                        </li>
                    @endif
                    @if (Auth::user()->role === 'superadmin')
                        <li><a href="{{ route('superadmin.dashboard') }}" class="hover:text-blue-500 transition">KELOLA
                                SUPERADMIN</a></li>
                    @endif
                @endauth
            </ul>
        </div>

        <!-- KANAN (Dropdown Avatar Mobile) -->
        <div class="flex items-center space-x-3">
            @auth
                <!-- MOBILE DROPDOWN -->
                <div class="block lg:hidden">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="rounded-full border-2 border-blue-800 shadow bg-white">
                                <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/avatar.jpg') }}"
                                    alt="Avatar" class="h-10 w-10 rounded-full object-cover" />
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 pt-3 pb-2 text-sm text-gray-700">
                                <div class="flex flex-col items-center text-center">
                                    <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/avatar.jpg') }}"
                                        alt="Avatar"
                                        class="h-14 w-14 rounded-full object-cover border-2 border-blue-800 mb-2 bg-white" />
                                    <div class="text-gray-700 font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-gray-700 text-xs capitalize">{{ Auth::user()->nik }}</div>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 my-1"></div>

                            <a href="{{ route('user.profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-[10px] rounded-lg transition font-medium
                                                                                                            {{ request()->routeIs('user.profile.edit') ? 'bg-gradient-to-b from-[#FFD700] to-[#E6C200] text-white' : 'text-gray-800 hover:bg-yellow-100 hover:text-[#0F3D3E]' }}">
                                <i class="fas fa-user text-[16px] w-5"></i>
                                <span>Profil</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left flex items-center gap-3 px-4 py-[10px] rounded-lg transition font-medium text-gray-800 hover:bg-yellow-100 hover:text-[#0F3D3E]">
                                    <i class="fas fa-sign-out-alt text-[16px] w-5"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- DESKTOP DROPDOWN -->
                <div class="hidden lg:block">
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center bg-white px-4 py-1 text-sm rounded-md border-2 border-white shadow hover:bg-gray-100 transition-all space-x-3">
                                <div class="text-[#0F3D3E] text-sm font-medium whitespace-nowrap">
                                    {{ Auth::user()->name }} <span class="mx-1 text-[#0F3D3E]">|</span>
                                    {{ Auth::user()->nik }}
                                </div>
                                <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/avatar.jpg') }}"
                                    alt="Avatar"
                                    class="h-8 w-8 object-cover rounded-full border-2 border-gray-300 bg-white shadow" />
                                <svg class="w-4 h-4 text-[#0F3D3E]" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 pt-3 pb-2 text-sm text-gray-700">
                                <div class="flex flex-col items-center text-center">
                                    <img src="{{ Auth::user()->foto ? asset('storage/' . Auth::user()->foto) : asset('images/avatar.jpg') }}"
                                        alt="Avatar"
                                        class="h-14 w-14 rounded-full object-cover border border-gray-300 mb-2 bg-white" />
                                    <div class="text-[#14B8A6] font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-[#14B8A6] text-xs capitalize">{{ Auth::user()->nik }}</div>
                                </div>
                            </div>
                            <div class="border-t border-gray-100 my-1"></div>

                            <a href="{{ route('user.profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-[10px] rounded-lg transition font-medium
                                                                                                            {{ request()->routeIs('user.profile.edit') ? 'bg-gradient-to-b from-[#FFD700] to-[#E6C200] text-white' : 'text-gray-800 hover:bg-yellow-100 hover:text-[#0F3D3E]' }}">
                                <i class="fas fa-user text-[16px] w-5"></i>
                                <span>Profil</span>
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left flex items-center gap-3 px-4 py-[10px] rounded-lg transition font-medium text-gray-800 hover:bg-yellow-100 hover:text-[#0F3D3E]">
                                    <i class="fas fa-sign-out-alt text-[16px] w-5"></i>
                                    <span>Logout</span>
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            @endauth
        </div>
    </div>

    <!-- MENU MOBILE -->
    <div class="lg:hidden hidden transition-all duration-300 ease-in-out" id="navbar-sidebar">
        <ul class="bg-white px-2 py-2 space-y-2">
            <li>
                <a href="{{ route('daftar-aduan') }}"
                    class="flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
        {{ request()->routeIs('daftar-aduan') ? 'bg-gradient-to-b from-[#2962FF] to-[#0039CB] text-white' : 'hover:bg-blue-100 hover:text-blue-600 text-gray-800' }}">
                    <i
                        class="fas fa-list text-[17px] w-5 {{ request()->routeIs('daftar-aduan') ? 'text-white' : 'text-gray-500 hover:text-blue-600' }}"></i>
                    <span>DAFTAR ADUAN</span>
                </a>
            </li>
            <li>
                <a href="{{ route('wbs.index') }}"
                    class="flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
        {{ request()->routeIs('wbs.index') ? 'bg-gradient-to-b from-[#2962FF] to-[#0039CB] text-white' : 'hover:bg-blue-100 hover:text-blue-600 text-gray-800' }}">
                    <i
                        class="fas fa-user-secret text-[17px] w-5 {{ request()->routeIs('wbs.index') ? 'text-white' : 'text-gray-500 hover:text-blue-600' }}"></i>
                    <span>WBS</span>
                </a>
            </li>
            <li>
                <a href="{{ route('tentang') }}"
                    class="flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
        {{ request()->routeIs('tentang') ? 'bg-gradient-to-b from-[#2962FF] to-[#0039CB] text-white' : 'hover:bg-blue-100 hover:text-blue-600 text-gray-800' }}">
                    <i
                        class="fas fa-info-circle text-[17px] w-5 {{ request()->routeIs('tentang') ? 'text-white' : 'text-gray-500 hover:text-blue-600' }}"></i>
                    <span>TENTANG KAMI</span>
                </a>
            </li>


            @guest
                <li>
                    <a href="{{ route('login') }}"
                        class="flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                {{ request()->routeIs('login') ? 'bg-gradient-to-b from-[#2962FF] to-[#0039CB] text-white' : 'hover:bg-blue-100 hover:text-blue-600 text-gray-800' }}">
                        <i
                            class="fas fa-sign-in-alt text-[17px] w-5 {{ request()->routeIs('login') ? 'text-white' : 'text-gray-500 hover:text-blue-600' }}"></i>
                        <span>LOGIN</span>
                    </a>
                </li>
            @endguest

            @auth
                @if (Auth::user()->role === 'admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                        {{ request()->routeIs('admin.dashboard') ? 'bg-gradient-to-b from-[#2962FF] to-[#0039CB] text-white' : 'hover:bg-blue-100 hover:text-blue-600 text-gray-800' }}">
                            <i
                                class="fas fa-tools text-[17px] w-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-gray-500 hover:text-blue-600' }}"></i>
                            <span>KELOLA ADMIN</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role === 'superadmin')
                    <li>
                        <a href="{{ route('superadmin.dashboard') }}"
                            class="flex items-center gap-4 px-4 py-[10px] rounded-lg transition font-medium
                        {{ request()->routeIs('superadmin.dashboard') ? 'bg-gradient-to-b from-[#2962FF] to-[#0039CB] text-white' : 'hover:bg-blue-100 hover:text-blue-600 text-gray-800' }}">
                            <i
                                class="fas fa-user-cog text-[17px] w-5 {{ request()->routeIs('superadmin.dashboard') ? 'text-white' : 'text-gray-500 hover:text-blue-600' }}"></i>
                            <span>KELOLA SUPERADMIN</span>
                        </a>
                    </li>
                @endif
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

        menu.classList.toggle("hidden");

        if (menu.classList.contains("hidden")) {
            icon.classList.remove("fa-times");
            icon.classList.add("fa-bars");
        } else {
            icon.classList.remove("fa-bars");
            icon.classList.add("fa-times");
        }
    });
</script>