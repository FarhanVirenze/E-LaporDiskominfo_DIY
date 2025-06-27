<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Agenda Rapat</h2>
    </x-slot>

    <div class="p-6 space-y-6">
        <div class="flex justify-between items-center">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('agendas.create') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow">
                    + Tambah Agenda
                </a>
            @endif
        </div>

        <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow">
            <table
                class="min-w-full text-sm text-left text-gray-800 dark:text-gray-200 border-separate border-spacing-y-2">
                <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-4 py-3">Nama Agenda</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Waktu</th>
                        <th class="px-4 py-3">Ruangan</th>
                        <th class="px-4 py-3">Kapasitas</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3">Oleh</th>
                        @if(auth()->user()->role !== 'user')
                            <th class="px-4 py-3 text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $user = auth()->user(); @endphp
                    @forelse($agendas as $agenda)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                {{-- Data lainnya --}}
                                <td class="px-4 py-2">{{ $agenda->nm_agenda }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($agenda->waktu)->format('H:i') }}</td>
                                <td class="px-4 py-2">{{ $agenda->ruangan->nm_ruangan ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $agenda->ruangan->kapasitas ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <span class="inline-block px-2 py-1 rounded-full text-white text-xs font-semibold
                        @if($agenda->status == 'disetujui') bg-green-600
                        @elseif($agenda->status == 'ditolak') bg-red-600
                        @else bg-yellow-500 @endif">
                                        {{ ucfirst($agenda->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    @if($agenda->approved_by)
                                        <span
                                            title="Disetujui pada {{ \Carbon\Carbon::parse($agenda->approved_at)->format('d M Y H:i') }}">
                                            {{ $agenda->approvedBy->name ?? 'Unknown' }}
                                        </span>
                                    @else
                                        <em class="text-gray-400">Belum disetujui</em>
                                    @endif
                                </td>

                                @if($user->role !== 'user')
                                    <td class="px-4 py-2 text-center space-x-1">
                                        {{-- Tombol admin --}}
                                        @if($user->role === 'admin')
                                            <a href="{{ route('agendas.edit', $agenda->id_agenda) }}"
                                                class="inline-block px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded text-xs font-medium">Edit</a>
                                            <form action="{{ route('agendas.destroy', $agenda->id_agenda) }}" method="POST"
                                                class="inline-block" onsubmit="return confirm('Hapus agenda ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded text-xs font-medium">
                                                    Hapus
                                                </button>
                                            </form>
                                        @endif

                                        {{-- Tombol pimpinan --}}
                                        @if($user->role === 'pimpinan')
                                            <form action="{{ route('agendas.approve', $agenda->id_agenda) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-green-600 hover:bg-green-700 text-white rounded text-xs font-medium">
                                                    Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('agendas.reject', $agenda->id_agenda) }}" method="POST"
                                                class="inline-block">
                                                @csrf
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-600 hover:bg-red-700 text-white rounded text-xs font-medium">
                                                    Tolak
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->role !== 'user' ? 8 : 7 }}"
                                class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                                Tidak ada agenda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>
</x-app-layout>