<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white leading-tight">
            {{ isset($notif) ? 'Edit Notifikasi' : 'Tambah Notifikasi' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <form action="{{ isset($notif) ? route('notifs.update', $notif->id_notif) : route('notifs.store') }}" method="POST" class="space-y-4">
                @csrf
                @if(isset($notif)) @method('PUT') @endif

                {{-- User --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">User</label>
                    <select name="id_user" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id_user ?? $user->id }}"
                                {{ old('id_user', $notif->id_user ?? '') == ($user->id_user ?? $user->id) ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Jenis Notifikasi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Notifikasi</label>
                    <input type="text" name="jenis_notif"
                           value="{{ old('jenis_notif', $notif->jenis_notif ?? '') }}"
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2" required>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                    <input type="text" name="keterangan"
                           value="{{ old('keterangan', $notif->keterangan ?? '') }}"
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2" required>
                </div>

                {{-- Status --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                    <select name="status" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2" required>
                        <option value="belum terbaca" {{ old('status', $notif->status ?? '') === 'belum terbaca' ? 'selected' : '' }}>Belum Terbaca</option>
                        <option value="terbaca" {{ old('status', $notif->status ?? '') === 'terbaca' ? 'selected' : '' }}>Terbaca</option>
                    </select>
                </div>

                {{-- Tanggal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal</label>
                    <input type="date" name="tanggal"
                           value="{{ old('tanggal', isset($notif) ? \Carbon\Carbon::parse($notif->tanggal)->format('Y-m-d') : '') }}"
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2" required>
                </div>

                {{-- Waktu --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu</label>
                    <input type="time" name="waktu"
                           value="{{ old('waktu', $notif->waktu ?? '') }}"
                           class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded px-3 py-2" required>
                </div>

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded shadow">
                        {{ isset($notif) ? 'Update' : 'Simpan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
