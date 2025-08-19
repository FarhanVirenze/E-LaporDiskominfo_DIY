<section class="bg-white rounded-2xl shadow-lg border border-white p-6 max-w-3xl mx-auto">
    <!-- Header -->
    <header class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900 flex items-center gap-3">
            <i class="fas fa-exclamation-triangle text-red-500 text-2xl"></i>
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-2 text-gray-600 text-sm leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <!-- Trigger Button -->
    <button
        onclick="openModal()"
        class="w-full md:w-auto px-6 py-3 bg-red-600 text-white font-semibold rounded-xl shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 flex items-center justify-center gap-2 transition">
        <i class="fas fa-user-slash"></i>
        {{ __('Delete Account') }}
    </button>

    <!-- Custom Confirmation Modal -->
    <div id="confirmDeletionModal" 
         class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-300 p-4">

        <!-- Modal Container -->
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md md:max-w-lg mx-auto transform scale-95 opacity-0 transition-all duration-300 ease-out overflow-auto">
            
            <!-- Form -->
            <form method="post" action="{{ route('user.profile.destroy') }}" class="p-6">
                @csrf
                @method('delete')

                <!-- Header -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="text-red-500 text-3xl">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900">
                        {{ __('Are you sure you want to delete your account?') }}
                    </h2>
                </div>

                <!-- Body -->
                <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                    {{ __('Once your account is deleted, all resources and data will be permanently removed. Please enter your password to confirm deletion.') }}
                </p>

                <!-- Password Input -->
                <div class="mb-6">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        placeholder="{{ __('Enter your password') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-red-400 focus:border-red-500 transition"
                    />
                    <p class="mt-2 text-red-500 text-sm">
                        @error('password') {{ $message }} @enderror
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex flex-col md:flex-row justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                        class="w-full md:w-auto px-5 py-2.5 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition flex items-center justify-center gap-2">
                        <i class="fas fa-times"></i> {{ __('Cancel') }}
                    </button>

                    <button type="submit"
                        class="w-full md:w-auto px-6 py-2.5 bg-red-600 text-white font-semibold rounded-xl shadow-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-400 flex items-center justify-center gap-2 transition">
                        <i class="fas fa-trash-alt"></i> {{ __('Delete Account') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Script untuk buka/tutup modal -->
<script>
function openModal() {
    const modal = document.getElementById('confirmDeletionModal');
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.querySelector('div').classList.remove('scale-95', 'opacity-0');
    }, 10);
}

function closeModal() {
    const modal = document.getElementById('confirmDeletionModal');
    const modalContent = modal.querySelector('div');
    modalContent.classList.add('scale-95', 'opacity-0');
    setTimeout(() => modal.classList.add('hidden'), 200);
}
</script>
