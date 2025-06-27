<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white leading-tight">
            Daftar Isi Rapat
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        {{-- Tombol tambah hanya untuk user --}}
        @if (auth()->user()->role === 'user')
            <div class="mb-4">
                <a href="{{ route('isi_rapats.create') }}"
                   class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow">
                    + Tambah Isi Rapat
                </a>
            </div>
        @endif

        {{-- Tabel --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <table class="min-w-full table-auto">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200 uppercase text-sm leading-normal">
                    <tr>
                        <th class="py-3 px-6 text-left">Agenda</th>
                        <th class="py-3 px-6 text-left">Pembahasan</th>
                        <th class="py-3 px-6 text-left">PIC</th>
                        <th class="py-3 px-6 text-left">Status</th>
                         @if(auth()->user()->role === 'admin')
            <th class="py-3 px-6 text-center">Aksi</th>
        @endif
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-300 text-sm font-light">
                    @forelse($isiRapats as $isi)
                        <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <td class="py-3 px-6">{{ $isi->agenda->nm_agenda ?? '-' }}</td>
                            <td class="py-3 px-6">{{ $isi->pembahasan }}</td>
                            <td class="py-3 px-6">{{ $isi->agenda->pic->name ?? '-' }}</td>
                            <td class="py-3 px-6">
                                <span class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                    @if($isi->status === 'open')
                                        bg-green-500
                                    @elseif($isi->status === 'close')
                                        bg-red-600
                                    @else
                                        bg-gray-500
                                    @endif">
                                    {{ ucfirst($isi->status) }}
                                </span>
                            </td>
                            @if(auth()->user()->role === 'admin')
                            <td class="py-3 px-6 text-center space-y-1">
                                    {{-- Tombol Hapus --}}
                                    <form action="{{ route('isi_rapats.destroy', $isi->id_rapat) }}" method="POST" class="inline-block"
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm shadow">
                                            Hapus
                                        </button>
                                    </form>

                                    {{-- Tombol Buka / Tutup --}}
                                    @if($isi->status === 'close')
                                        <form action="{{ route('isi_rapats.reopen', $isi->id_rapat) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                    class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm shadow">
                                                Buka
                                            </button>
                                        </form>
                                    @elseif($isi->status === 'open')
                                        <form action="{{ route('isi_rapats.close', $isi->id_rapat) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit"
                                                    class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm shadow">
                                                Tutup
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-6 text-gray-400 dark:text-gray-500">
                                Belum ada data isi rapat.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
