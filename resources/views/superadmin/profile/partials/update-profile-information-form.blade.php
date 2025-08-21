<section>
    <!-- Header Section -->
    <header class="mb-1 relative">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-red-700 flex items-center gap-2">
                    <i class="fa-solid fa-user-circle"></i>
                    {{ __('Profile Information') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600">
                    {{ __("Update your account's profile information and email address.") }}
                </p>
            </div>

            @if (session('status') === 'profile-updated')
                <!-- Toast Notifikasi di kanan header -->
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                    class="absolute top-1/2 right-0 transform -translate-y-1/2 z-50 max-w-sm w-full bg-white border-l-4 border-blue-600 text-gray-800 text-sm rounded-lg shadow-lg px-4 py-3"
                    role="alert">
                    <div class="flex items-start">
                        <i class="fa-solid fa-circle-check text-blue-600 text-lg mr-2"></i>
                        <div>
                            <strong class="font-semibold">Success!</strong>
                            <span class="block sm:inline"> Profile updated successfully.</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </header>

    <!-- Form Verifikasi Email -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Form Update Profile -->
    <form method="post" action="{{ route('superadmin.profile.update') }}" enctype="multipart/form-data"
        class="bg-white shadow-md rounded-xl p-6 space-y-6 border border-gray-100 hover:shadow-xl transition">
        @csrf
        @method('patch')

        <!-- Foto Profil -->
        <div class="flex flex-col items-center">
            <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('images/avatar.jpg') }}" 
                 alt="Foto Profil"
                 class="w-28 h-28 rounded-full object-cover mb-3 ring-4 ring-red-200 shadow">

            <!-- Ganti Foto -->
            <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-lg border border-red-200 hover:bg-red-100 hover:text-red-800 transition">
                <i class="fa-solid fa-camera mr-2"></i> Ganti Foto
                <input type="file" name="foto" class="hidden" accept="image/*">
            </label>

            @error('foto')
                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text"
                class="mt-1 block w-full border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500"
                :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- NIK -->
        <div>
            <x-input-label for="nik" :value="__('NIK')" />
            <x-text-input id="nik" name="nik" type="text"
                class="mt-1 block w-full border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500"
                :value="old('nik', $user->nik)" autocomplete="nik" />
            <x-input-error class="mt-2" :messages="$errors->get('nik')" />
        </div>

        <!-- Nomor Telepon -->
        <div>
            <x-input-label for="nomor_telepon" :value="__('Phone Number')" />
            <x-text-input id="nomor_telepon" name="nomor_telepon" type="text"
                class="mt-1 block w-full border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500"
                :value="old('nomor_telepon', $user->nomor_telepon)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('nomor_telepon')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full border-gray-300 rounded-lg focus:border-red-500 focus:ring-red-500"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-gray-600 flex items-center gap-1">
                    <i class="fa-solid fa-circle-exclamation text-yellow-500"></i>
                    <span>{{ __('Your email address is unverified.') }}</span>
                    <button form="send-verification"
                        class="underline text-red-600 hover:text-red-800 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 ml-1">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600 flex items-center gap-1">
                        <i class="fa-solid fa-envelope-circle-check"></i>
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-800 text-white font-semibold rounded-lg shadow hover:scale-105 transition">
                <i class="fa-solid fa-save mr-2"></i> {{ __('Save') }}
            </button>
        </div>
    </form>

    <!-- Reset Foto -->
    @if ($user->foto)
        <form method="POST" action="{{ route('superadmin.profile.resetFoto') }}"
            onsubmit="return confirm('Yakin ingin menghapus foto dan kembali ke default?')"
            class="flex justify-center mt-6">
            @csrf
            @method('PATCH')
            <button type="submit" class="text-red-600 hover:text-red-800 font-medium flex items-center gap-1 text-sm">
                <i class="fa-solid fa-rotate-left"></i> Defaultkan Foto
            </button>
        </form>
    @endif
</section>
