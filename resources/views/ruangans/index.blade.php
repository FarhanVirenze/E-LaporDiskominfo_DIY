<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white leading-tight">
            Data Ruangan
        </h2>
    </x-slot>

    <div class="p-6 max-w-7xl mx-auto">
        @if(auth()->user()->role === 'admin')
            <div class="mb-4">
                <a href="{{ route('ruangans.create') }}"
                   class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20"
                         fill="currentColor">
                        <path fill-rule="evenodd"
                              d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                              clip-rule="evenodd" />
                    </svg>
                    Tambah Ruangan
                </a>
            </div>
        @endif

        <div class="overflow-x-auto bg-white dark:bg-gray-800 shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">Nama Ruangan</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Lokasi</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Kapasitas</th>
                        @if(auth()->user()->role === 'admin')
                            <th class="px-6 py-3 text-left text-sm font-medium">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($ruangans as $ruangan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-800 dark:text-gray-100">
                            <td class="px-6 py-4">{{ $ruangan->nm_ruangan }}</td>
                            <td class="px-6 py-4">{{ $ruangan->lokasi ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $ruangan->kapasitas ?? '-' }}</td>
                            @if(auth()->user()->role === 'admin')
                                <td class="px-6 py-4 space-x-2">
                                    <a href="{{ route('ruangans.edit', $ruangan->id_ruangan) }}"
                                       class="inline-flex items-center text-blue-600 hover:text-blue-800 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1"
                                             viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                                            <path fill-rule="evenodd"
                                                  d="M5 18a1 1 0 100-2h10a1 1 0 100 2H5z"
                                                  clip-rule="evenodd" />
                                        </svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('ruangans.destroy', $ruangan->id_ruangan) }}" method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Hapus ruangan ini?')"
                                                class="inline-flex items-center text-red-600 hover:text-red-800 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1"
                                                 viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd"
                                                      d="M6 4a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V6a2 2 0 00-2-2H6zm2 4a1 1 0 012 0v6a1 1 0 11-2 0V8zm4 0a1 1 0 10-2 0v6a1 1 0 102 0V8z"
                                                      clip-rule="evenodd" />
                                            </svg>
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'admin' ? 4 : 3 }}"
                                class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data ruangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
