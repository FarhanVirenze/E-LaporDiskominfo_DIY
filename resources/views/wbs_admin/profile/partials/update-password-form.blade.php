<section class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
    <header class="mb-1 relative">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-key text-red-500"></i>
                    {{ __('Update Password') }}
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </div>

            @if (session('status') === 'password-updated')
                <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
                    x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                    class="absolute top-1/2 right-0 transform -translate-y-1/2 z-50 max-w-sm w-full bg-blue-100 border border-blue-300 text-blue-800 text-sm rounded-lg shadow-lg px-4 py-3 flex items-start"
                    role="alert">
                    <i class="fas fa-check-circle text-blue-600 mt-0.5 mr-2"></i>
                    <div>
                        <strong class="font-semibold">Success!</strong>
                        <span class="block sm:inline">Password updated successfully.</span>
                    </div>
                </div>
            @endif
        </div>
    </header>

    <form method="post" action="{{ route('wbs_admin.password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition"
                autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <!-- New Password -->
        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input id="update_password_password" name="password" type="password"
                class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 block w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50 transition"
                autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Actions -->
        <div class="flex items-center gap-4">
            <button type="submit"
                class="px-6 py-2 bg-gradient-to-r from-red-600 to-red-800 text-white font-semibold rounded-lg shadow hover:scale-105 transition">
                <i class="fas fa-save mr-2"></i> {{ __('Save') }}
            </button>
        </div>
    </form>
</section>