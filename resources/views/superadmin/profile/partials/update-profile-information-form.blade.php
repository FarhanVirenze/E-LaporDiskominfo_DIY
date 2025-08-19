<section>
    <header>
        <h2 class="text-lg font-medium text-black">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-black">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <!-- Form Verifikasi Email -->
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <!-- Form Update Profile -->
    <form method="post" action="{{ route('superadmin.profile.update') }}" enctype="multipart/form-data"
        class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <!-- Foto Profil -->
        <div class="flex flex-col items-center">
            <img src="{{ $user->foto ? asset('storage/' . $user->foto) : asset('images/avatar.jpg') }}"
                alt="Foto Profil" class="w-24 h-24 rounded-full object-cover mb-2">

            <!-- Ganti Foto -->
            <label class="cursor-pointer text-sm text-blue-600 hover:underline">
                <span>Ganti Foto</span>
                <input type="file" name="foto" class="hidden" accept="image/*">
            </label>

            @error('foto')
                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <!-- NIK -->
        <div>
            <x-input-label for="nik" :value="__('NIK')" />
            <x-text-input id="nik" name="nik" type="text" class="mt-1 block w-full" :value="old('nik', $user->nik)"
                autocomplete="nik" />
            <x-input-error class="mt-2" :messages="$errors->get('nik')" />
        </div>

        <!-- Nomor Telepon -->
        <div>
            <x-input-label for="nomor_telepon" :value="__('Phone Number')" />
            <x-text-input id="nomor_telepon" name="nomor_telepon" type="text" class="mt-1 block w-full"
                :value="old('nomor_telepon', $user->nomor_telepon)" autocomplete="tel" />
            <x-input-error class="mt-2" :messages="$errors->get('nomor_telepon')" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2 text-sm text-black">
                    {{ __('Your email address is unverified.') }}
                    <button form="send-verification"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </div>

                @if (session('status') === 'verification-link-sent')
                    <p class="mt-2 font-medium text-sm text-green-600">
                        {{ __('A new verification link has been sent to your email address.') }}
                    </p>
                @endif
            @endif
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <x-profile-button>{{ __('Save') }}</x-profile-button>

            @if (session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                    class="fixed bottom-6 right-6 z-50 max-w-sm w-full bg-green-100 border border-green-400 text-green-800 text-sm rounded-lg shadow-lg px-4 py-3"
                    role="alert">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5 text-green-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <strong class="font-semibold">Success!</strong>
                            <span class="block sm:inline">Profile updated successfully.</span>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </form>

    <!-- Form Reset Foto (DI LUAR form update!) -->
    @if ($user->foto)
        <form method="POST" action="{{ route('superadmin.profile.resetFoto') }}"
            onsubmit="return confirm('Yakin ingin menghapus foto dan kembali ke default?')"
            class="flex justify-center mt-4">
            @csrf
            @method('PATCH')
            <button type="submit" class="text-red-600 hover:underline text-sm">
                Defaultkan Foto
            </button>
        </form>
    @endif
</section>