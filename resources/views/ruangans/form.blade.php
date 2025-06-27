<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($ruangan) ? 'Edit Ruangan' : 'Tambah Ruangan' }}
        </h2>
    </x-slot>

    <div class="p-6">
        <form action="{{ isset($ruangan) ? route('ruangans.update', $ruangan->id_ruangan) : route('ruangans.store') }}" method="POST">
            @csrf
            @if(isset($ruangan)) @method('PUT') @endif

            <div class="mb-4">
                <label for="nm_ruangan" class="block text-gray-700 dark:text-gray-300">Nama Ruangan</label>
                <input
                    type="text"
                    name="nm_ruangan"
                    id="nm_ruangan"
                    value="{{ old('nm_ruangan', $ruangan->nm_ruangan ?? '') }}"
                    class="w-full border rounded px-3 py-2 text-gray-800 dark:text-white bg-white dark:bg-gray-800"
                    required
                />
            </div>

            <div class="mb-4">
                <label for="lokasi" class="block text-gray-700 dark:text-gray-300">Lokasi (Opsional)</label>
                <input
                    type="text"
                    name="lokasi"
                    id="lokasi"
                    value="{{ old('lokasi', $ruangan->lokasi ?? '') }}"
                    class="w-full border rounded px-3 py-2 text-gray-800 dark:text-white bg-white dark:bg-gray-800"
                />
            </div>

            <div class="mb-4">
                <label for="kapasitas" class="block text-gray-700 dark:text-gray-300">Kapasitas Ruangan</label>
                <input
                    type="number"
                    name="kapasitas"
                    id="kapasitas"
                    value="{{ old('kapasitas', $ruangan->kapasitas ?? '') }}"
                    min="1"
                    class="w-full border rounded px-3 py-2 text-gray-800 dark:text-white bg-white dark:bg-gray-800"
                    required
                />
            </div>

            <div>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                    {{ isset($ruangan) ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
