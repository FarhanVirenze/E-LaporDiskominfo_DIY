<x-guest-layout>
    @php
        $inputClasses = 'w-full px-2 text-sm text-black focus:outline-none';
        $iconClasses = 'w-4 h-4 text-gray-700';
        $wrapperClasses = 'flex rounded-md overflow-hidden h-9 bg-white';
        $iconContainer = 'flex items-center justify-center px-2 bg-gray-300';
    @endphp

    <!-- Status -->
    <x-auth-session-status class="mb-4 text-white" :status="session('status')" />

    <!-- Judul -->
    <h1 class="text-3xl font-bold text-white text-center mb-4">Login</h1>

    <!-- Logo (Hanya tampil di Mobile) -->
    <div class="flex justify-center mb-2 block md:hidden">
        <img src="{{ asset('images/logo-diy.png') }}" alt="Logo E-Lapor" class="w-30 h-24 drop-shadow-lg">
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-3">
        @csrf

        <!-- Email -->
        <div>
            <x-login-label for="email" :value="__('Email')" class="text-white text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    <i class="fas fa-envelope {{ $iconClasses }}"></i>
                </div>
                <input id="email" name="email" type="email" placeholder="Masukkan Email" class="{{ $inputClasses }}"
                    value="{{ old('email') }}" required autofocus />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs !text-white" />
        </div>

        <!-- Password -->
        <div>
            <x-login-label for="password" :value="__('Password')" class="text-white text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    <i class="fas fa-lock {{ $iconClasses }}"></i>
                </div>
                <input id="password" name="password" type="password" placeholder="Masukkan Password"
                    class="{{ $inputClasses }}" required />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs !text-white" />
        </div>

        <!-- Remember Me & Lupa Password -->
        <div class="flex items-center justify-between mt-2">
            <label for="remember_me" class="inline-flex items-center text-sm text-white">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-blue-600" name="remember">
                <span class="ml-2">Ingat saya</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-blue-300 hover:text-blue-400">Lupa
                    Password?</a>
            @endif
        </div>

        <!-- Tombol Login -->
        <div class="mt-6">
            <button type="submit" class="w-full justify-center bg-gradient-to-r from-blue-500 to-cyan-500 
                       hover:from-blue-600 hover:to-cyan-600 
                       text-white font-semibold py-2 rounded-lg 
                       shadow-md transition duration-300 ease-in-out 
                       focus:outline-none focus:ring-2 focus:ring-blue-400">
                {{ __('Login') }}
            </button>
        </div>

        <!-- Divider -->
        <div class="flex items-center my-6">
            <div class="flex-grow border-t border-white/20"></div>
            <span class="mx-3 text-white text-sm">atau</span>
            <div class="flex-grow border-t border-white/20"></div>
        </div>

        <!-- Tombol Login dengan Google -->
        <a href="{{ route('google.login') }}"
            class="w-full flex items-center justify-center gap-3 bg-white text-black font-medium py-2 rounded-lg shadow-md hover:bg-gray-200 transition">
            <!-- Icon Google -->
            <img src="https://www.svgrepo.com/show/355037/google.svg" alt="Google" class="w-5 h-5">
            <span>Login dengan Google</span>
        </a>

        <!-- Register -->
        <p class="mt-6 text-center text-white text-sm">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-semibold text-blue-300 hover:text-blue-400">Daftar di sini</a>
        </p>
    </form>
</x-guest-layout>