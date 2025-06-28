<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            Data Ruangan
        </h2>
    </x-slot>

    <div class="p-6">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('ruangans.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                + Tambah Ruangan
            </a>
        @endif

        <div class="overflow-x-auto mt-4">
            <table class="table-auto w-full border-collapse text-sm">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                        <th class="px-4 py-2 border">Nama Ruangan</th>
                        <th class="px-4 py-2 border">Lokasi</th>
                        <th class="px-4 py-2 border">Kapasitas</th>
                        @if(auth()->user()->role === 'admin')
                            <th class="px-4 py-2 border">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($ruangans as $ruangan)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-800 dark:text-gray-200">
                            <td class="px-4 py-2 border">{{ $ruangan->nm_ruangan }}</td>
                            <td class="px-4 py-2 border">{{ $ruangan->lokasi ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $ruangan->kapasitas ?? '-' }}</td>
                            @if(auth()->user()->role === 'admin')
                                <td class="px-4 py-2 border">
                                    <a href="{{ route('ruangans.edit', $ruangan->id_ruangan) }}"
                                       class="text-blue-600 hover:underline dark:text-blue-400">Edit</a>
                                    <form action="{{ route('ruangans.destroy', $ruangan->id_ruangan) }}"
                                          method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Hapus ruangan ini?')"
                                                class="text-red-600 hover:underline dark:text-red-400 ml-2">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role === 'admin' ? 4 : 3 }}"
                                class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">
                                Belum ada data ruangan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
