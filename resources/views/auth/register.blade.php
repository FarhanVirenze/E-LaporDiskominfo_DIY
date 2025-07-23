<x-guest-layout>
    <!-- Logo dan Teks Selamat Datang -->
    <div class="flex flex-col items-center mb-2">
        <img src="{{ asset('images/logo-diy.png') }}" alt="Logo E-Lapor" class="w-28 h-24 mb-4">
        <h1 class="text-xl font-semibold text-white">Selamat Datang di</h1>
        <h2 class="text-xl font-semibold text-white mt-1">E-Lapor DIY</h2>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-3">
        @csrf

        @php
            $inputClasses = 'w-full px-2 text-sm text-black focus:outline-none';
            $iconClasses = 'w-4 h-4 text-gray-700';
            $wrapperClasses = 'flex rounded-md overflow-hidden h-9 bg-white';
            $iconContainer = 'flex items-center justify-center px-2 bg-gray-300';
        @endphp

        <!-- Name -->
        <div>
            <x-login-label for="name" :value="__('Name')" class="text-white text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    <svg class="{{ $iconClasses }}" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A9 9 0 0112 15a9 9 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <input id="name" name="name" type="text" class="{{ $inputClasses }}" placeholder="Masukkan Nama"
                    value="{{ old('name') }}" required autofocus autocomplete="name" />
            </div>
            <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs !text-white" />
        </div>

        <!-- NIK -->
        <div>
            <x-login-label for="nik" :value="__('NIK (opsional)')" class="text-white text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    {{-- Icon ID Card --}}
                    <svg class="{{ $iconClasses }}" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5 7h14M5 11h14M7 15h4m-6 4h10a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <input id="nik" name="nik" type="text" class="{{ $inputClasses }}" placeholder="Masukkan NIK"
                    value="{{ old('nik') }}" autocomplete="nik" />
            </div>
            <x-input-error :messages="$errors->get('nik')" class="mt-1 text-xs !text-white" />
        </div>

        <!-- Nomor Telepon -->
        <div>
            <x-login-label for="nomor_telepon" :value="__('Nomor Telepon (opsional)')" class="text-white text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    {{-- Icon Phone --}}
                    <svg class="{{ $iconClasses }}" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 5a2 2 0 012-2h2a2 2 0 012 2v1a2 2 0 01-.586 1.414l-.828.828a2 2 0 000 2.828l5.657 5.657a2 2 0 002.828 0l.828-.828A2 2 0 0118 14h1a2 2 0 012 2v2a2 2 0 01-2 2h-1c-7.18 0-13-5.82-13-13V5z" />
                    </svg>
                </div>
                <input id="nomor_telepon" name="nomor_telepon" type="text" class="{{ $inputClasses }}"
                    placeholder="Masukkan Nomor Telepon" value="{{ old('nomor_telepon') }}" autocomplete="tel" />
            </div>
            <x-input-error :messages="$errors->get('nomor_telepon')" class="mt-1 text-xs !text-white" />
        </div>

        <!-- Email -->
        <div>
            <x-login-label for="email" :value="__('Email')" class="text-white text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    <svg class="{{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12H8m8 4H8m8-8H8m-2 8V8a2 2 0 012-2h8a2 2 0 012 2v8a2 2 0 01-2 2H8a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <input id="email" name="email" type="email" class="{{ $inputClasses }}" placeholder="Masukkan Email"
                    value="{{ old('email') }}" required autocomplete="username" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs !text-white" />
        </div>

        <!-- Password -->
        <div>
            <x-login-label for="password" :value="__('Password')" class="text-white !text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    {{-- Icon Lock Closed --}}
                    <svg class="{{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v3h-6v-3zM5 20h14a2 2 0 002-2v-7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2z" />
                    </svg>
                </div>
                <input id="password" name="password" type="password" class="{{ $inputClasses }}"
                    placeholder="Masukkan Password" required autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs !text-white" />
        </div>

        <!-- Konfirmasi Password -->
        <div>
            <x-login-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-white !text-sm" />
            <div class="{{ $wrapperClasses }}">
                <div class="{{ $iconContainer }}">
                    {{-- Icon Lock with Check --}}
                    <svg class="{{ $iconClasses }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3v1M5 20h14a2 2 0 002-2v-5a2 2 0 00-2-2H5a2 2 0 00-2 2v5a2 2 0 002 2zM9 14l2 2 4-4" />
                    </svg>
                </div>
                <input id="password_confirmation" name="password_confirmation" type="password"
                    class="{{ $inputClasses }}" placeholder="Konfirmasi Password" required
                    autocomplete="new-password" />
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs !text-white" />
        </div>

        <!-- Link Masuk -->
        <div class="mt-6 text-left">
            <a class="text-sm text-white hover:underline" href="{{ route('login') }}">
                Sudah punya akun? Masuk di sini
            </a>
        </div>

        <!-- Tombol Register -->
        <div class="mt-10">
            <x-primary-button
                class="w-full justify-center bg-red-700 hover:bg-red-800 text-white font-semibold py-2 rounded-md transition duration-200">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>