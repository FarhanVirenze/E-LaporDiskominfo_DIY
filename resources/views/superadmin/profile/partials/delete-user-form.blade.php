<section class="bg-white rounded-2xl shadow-lg border border-white p-6 max-w-3xl mx-auto space-y-6">
    <!-- Header -->
    <header class="mb-4">
        <h2 class="text-2xl font-semibold text-gray-900 flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-2 text-gray-600 text-sm leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Trigger Button -->
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-superadmin-deletion')"
        class="w-full md:w-auto px-6 py-3 bg-gradient-to-r from-red-600 to-red-800 text-white font-semibold rounded-lg shadow hover:scale-105 transition flex items-center justify-center gap-2">
        <i class="fas fa-user-slash"></i>
        {{ __('Delete Account') }}
    </x-danger-button>

    <!-- Modal -->
    <x-modal name="confirm-superadmin-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('superadmin.profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <div class="flex items-center gap-3 mt-10">
                <div class="text-red-500 text-3xl">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-900">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>
            </div>

            <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                {{ __('This action is irreversible. Please enter your password to confirm deletion.') }}
            </p>

            <!-- Password Input -->
            <div class="mb-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input 
                    id="password" 
                    name="password" 
                    type="password" 
                    placeholder="{{ __('Enter your password') }}"
                    class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-500 transition"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-500 text-sm" />
            </div>

            <!-- Actions -->
            <div class="flex flex-col md:flex-row justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    <i class="fas fa-times"></i> {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button type="submit" class="ms-3 flex items-center gap-2">
                    <i class="fas fa-trash-alt"></i> {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
