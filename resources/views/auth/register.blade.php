<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="space-y-2 sm:space-y-3">
        @csrf
        @php
            $inputClasses = 'w-full px-2 text-xs sm:text-sm text-black focus:outline-none';
            $iconClasses = 'w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-700';
            $wrapperClasses = 'flex rounded-md overflow-hidden h-8 sm:h-9 bg-white';
            $iconContainer = 'flex items-center justify-center px-2 bg-gray-300';
        @endphp

        <!-- Judul -->
        <h2 class="text-2xl sm:text-3xl font-bold text-center text-white mb-2 sm:mb-4">Register</h2>

        <!-- Logo (Hanya tampil di Mobile) -->
        <div class="flex justify-center mb-2 block md:hidden">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/logo-diy.png') }}" alt="Logo E-Lapor"
                    class="w-20 h-16 sm:w-28 sm:h-24 drop-shadow-lg hover:scale-105 transition-transform duration-200">
            </a>
        </div>

        <!-- Name -->
        <div>
            <x-login-label for="name" :value="__('Name')" class="text-white text-xs sm:text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    <i class="fas fa-user {{ $iconClasses }}"></i>
                </div>
                <input id="name" name="name" type="text" class="{{ $inputClasses }}" placeholder="Masukkan Nama"
                    value="{{ old('name') }}" required autofocus />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-[10px] sm:text-xs !text-white" />
        </div>

        <!-- NIK -->
        <div>
            <x-login-label for="nik" :value="__('NIK (opsional)')" class="text-white text-xs sm:text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    <i class="fas fa-id-card {{ $iconClasses }}"></i>
                </div>
                <input id="nik" name="nik" type="text" class="{{ $inputClasses }}" placeholder="Masukkan NIK"
                    value="{{ old('nik') }}" />
            </div>
            <x-input-error :messages="$errors->get('nik')" class="mt-1 text-[10px] sm:text-xs !text-white" />
        </div>

        <!-- Nomor Telepon -->
        <div>
            <x-login-label for="nomor_telepon" :value="__('Nomor Telepon (opsional)')"
                class="text-white text-xs sm:text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    <i class="fas fa-phone {{ $iconClasses }}"></i>
                </div>
                <input id="nomor_telepon" name="nomor_telepon" type="text" class="{{ $inputClasses }}"
                    placeholder="Masukkan Nomor Telepon" value="{{ old('nomor_telepon') }}" />
            </div>
            <x-input-error :messages="$errors->get('nomor_telepon')" class="mt-1 text-[10px] sm:text-xs !text-white" />
        </div>

        <!-- Email -->
        <div>
            <x-login-label for="email" :value="__('Email')" class="text-white text-xs sm:text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    <i class="fas fa-envelope {{ $iconClasses }}"></i>
                </div>
                <input id="email" name="email" type="email" class="{{ $inputClasses }}" placeholder="Masukkan Email"
                    value="{{ old('email') }}" required />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-[10px] sm:text-xs !text-white" />
        </div>

        <!-- Password -->
        <div>
            <x-login-label for="password" :value="__('Password')" class="text-white text-xs sm:text-sm" />
            <div class="{{ $wrapperClasses }} relative">
                <div class="{{ $iconContainer }}">
                    <i class="fas fa-lock {{ $iconClasses }}"></i>
                </div>
                <input id="password" name="password" type="password" class="{{ $inputClasses }} pr-8"
                    placeholder="Masukkan Password" required />

                <!-- Tombol Toggle Password -->
                <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-600 hover:text-gray-800">
                    <i id="eyeIcon1" class="fas fa-eye"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-[10px] sm:text-xs !text-white" />
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <x-login-label for="password_confirmation" :value="__('Konfirmasi Password')"
                class="text-white text-xs sm:text-sm" />
            <div class="{{ $wrapperClasses }} relative">
                <div class="{{ $iconContainer }}">
                    <i class="fas fa-check {{ $iconClasses }}"></i>
                </div>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="{{ $inputClasses }} pr-8" placeholder="Konfirmasi Password" required />

                <!-- Tombol Toggle Password Konfirmasi -->
                <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                    class="absolute right-2 top-1/2 -translate-y-1/2 text-gray-600 hover:text-gray-800">
                    <i id="eyeIcon2" class="fas fa-eye"></i>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')"
                class="mt-1 text-[10px] sm:text-xs !text-white" />
        </div>

        <!-- Tombol Register -->
        <div class="mt-4 sm:mt-6">
            <button type="submit" class="w-full justify-center bg-gradient-to-r from-red-500 to-rose-500 
                       hover:from-red-600 hover:to-rose-600 
                       text-white font-semibold py-1.5 sm:py-2 rounded-lg 
                       shadow-md transition duration-300 ease-in-out 
                       focus:outline-none focus:ring-2 focus:ring-blue-400 text-sm sm:text-base">
                {{ __('Register') }}
            </button>
        </div>

        <!-- Login -->
        <p class="mt-4 sm:mt-6 text-center text-white text-xs sm:text-sm">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-semibold text-blue-300 hover:text-blue-400">Masuk di sini</a>
        </p>
    </form>
    <!-- Script toggle password -->
    <script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>
</x-guest-layout>