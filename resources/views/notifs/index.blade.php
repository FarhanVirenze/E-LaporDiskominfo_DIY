<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white leading-tight">
            Daftar Notifikasi
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        {{-- Tombol Tambah --}}
        <div class="mb-4">
            <a href="{{ route('notifs.create') }}"
               class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow">
                + Tambah Notifikasi
            </a>
        </div>

        {{-- Tabel Notifikasi --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 uppercase text-sm">
                    <tr>
                        <th class="py-3 px-6 text-left">User</th>
                        <th class="py-3 px-6 text-left">Jenis Notif</th>
                        <th class="py-3 px-6 text-left">Status</th>
                        <th class="py-3 px-6 text-left">Tanggal</th>
                        <th class="py-3 px-6 text-left">Waktu</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-200 text-sm">
                    @forelse($notifs as $notif)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="py-3 px-6">{{ $notif->user->name }}</td>
                            <td class="py-3 px-6">{{ $notif->jenis_notif }}</td>
                            <td class="py-3 px-6">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                    {{ $notif->status === 'selesai' ? 'bg-green-500 text-white' :
                                       ($notif->status === 'terkirim' ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white') }}">
                                    {{ ucfirst($notif->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($notif->tanggal)->format('d M Y') }}</td>
                            <td class="py-3 px-6">{{ $notif->waktu }}</td>
                            <td class="py-3 px-6 text-center space-x-2">
                                <a href="{{ route('notifs.edit', $notif->id_notif) }}"
                                   class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                    Edit
                                </a>
                                <form action="{{ route('notifs.destroy', $notif->id_notif) }}" method="POST" class="inline-block"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-400 dark:text-gray-500">
                                Tidak ada data notifikasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
