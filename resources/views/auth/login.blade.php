<x-guest-layout>
    <!-- Logo dan Teks Selamat Datang -->
    <div class="flex flex-col items-center mb-2">
        <img src="{{ asset('images/logo-diy.png') }}" alt="Logo E-Lapor" class="w-32 h-28 mb-6">
        <h1 class="text-2xl font-semibold text-white">Selamat Datang di</h1>
        <h2 class="text-2xl font-semibold text-white mt-2">E-Lapor DIY</h2>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-white" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mt-4">
            <x-login-label for="email" :value="__('Email')" class="!text-white" />
            <div class="flex rounded-md overflow-hidden h-10 bg-white">
                <!-- Icon -->
                <div class="flex items-center justify-center px-3 bg-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12H8m8 4H8m8-8H8m-2 8V8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H8a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <!-- Input -->
                <input id="email" name="email" type="email" class="w-full px-3 text-black focus:outline-none"
                    placeholder="Masukkan Email" value="{{ old('email') }}" required autofocus
                    autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 !text-white" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-login-label for="password" :value="__('Password')" class="!text-white" />
            <div class="flex rounded-md overflow-hidden h-10 bg-white">
                <!-- Icon -->
                <div class="flex items-center justify-center px-3 bg-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-700" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v3h-6v-3zM5 20h14a2 2 0 002-2v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2z" />
                    </svg>
                </div>
                <!-- Input -->
                <input id="password" name="password" type="password" class="w-full px-3 text-black focus:outline-none"
                    placeholder="Masukkan Password" required autocomplete="current-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 !text-white" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-white bg-white text-red-700 focus:ring-white" name="remember">
                <span class="ms-2 text-sm text-white">Remember me</span>
            </label>
        </div>

        <!-- Link Daftar & Lupa Password -->
        <div class="flex flex-col sm:flex-row sm:justify-between mt-4 space-y-2 sm:space-y-0 sm:space-x-4">
            <a href="{{ route('register') }}" class="text-sm text-white hover:underline">
                Belum punya akun? Daftar di sini
            </a>

            @if (Route::has('password.request'))
                <a class="text-sm text-white hover:underline" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            @endif
        </div>

         <!-- Login Button -->
        <div class="mt-6">
            <x-primary-button class="w-full justify-center bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-md transition duration-200">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>