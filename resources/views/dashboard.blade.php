<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-10">

        {{-- Ringkasan Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-6">
            <div class="bg-indigo-600 text-white p-5 rounded-lg shadow">
                <p class="text-sm">Users</p>
                <p class="text-3xl font-bold">{{ $jumlah_user }}</p>
            </div>
            <div class="bg-blue-600 text-white p-5 rounded-lg shadow">
                <p class="text-sm">Agenda</p>
                <p class="text-3xl font-bold">{{ $jumlah_agenda }}</p>
            </div>
            <div class="bg-cyan-600 text-white p-5 rounded-lg shadow">
                <p class="text-sm">Ruangan</p>
                <p class="text-3xl font-bold">{{ $jumlah_ruangan }}</p>
            </div>
            <div class="bg-green-600 text-white p-5 rounded-lg shadow">
                <p class="text-sm">Isi Rapat</p>
                <p class="text-3xl font-bold">{{ $jumlah_isi_rapat }}</p>
            </div>
            <div class="bg-red-600 text-white p-5 rounded-lg shadow">
                <p class="text-sm">Notifikasi</p>
                <p class="text-3xl font-bold">{{ $jumlah_notif }}</p>
            </div>
        </div>

        {{-- Jadwal Rapat --}}
<div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Jadwal Rapat</h3>

    @php
        // Filter hanya agenda yang disetujui
        $agendaDisetujui = $semua_agenda->where('status', 'disetujui');
    @endphp

    @if($agendaDisetujui->isEmpty())
        <p class="text-gray-500 dark:text-gray-400">Belum ada agenda yang disetujui.</p>
    @else
        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-gray-200 dark:border-gray-700">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">Nama Agenda</th>
                        <th class="px-4 py-2 border">Ruangan</th>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Waktu</th>
                        <th class="px-4 py-2 border">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 dark:text-gray-300">
                    @foreach($agendaDisetujui as $agenda)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                            <td class="px-4 py-2 border">{{ $agenda->nm_agenda }}</td>
                            <td class="px-4 py-2 border">{{ $agenda->ruangan->nm_ruangan ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($agenda->waktu)->format('H:i') }}</td>
                            <td class="px-4 py-2 border">{{ $agenda->deskripsi ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

        {{-- Notifikasi Aktif --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Notifikasi Aktif Terbaru</h3>
            @if($notifs->isEmpty())
                <p class="text-gray-500 dark:text-gray-400">Tidak ada notifikasi aktif.</p>
            @else
                <ul class="space-y-2 text-gray-700 dark:text-gray-200 list-disc list-inside">
                    @foreach($notifs as $notif)
                        <li>
                            <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $notif->jenis_notif }}</span> -
                            {{ $notif->keterangan }}
                            <span class="text-sm text-gray-500">({{ $notif->user->name ?? 'User' }})</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Top Kontributor --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">Top 5 Kontributor Isi Rapat</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-200 dark:border-gray-700">
                    <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                        <tr>
                            <th class="px-4 py-2 border">Nama</th>
                            <th class="px-4 py-2 border">Jumlah Isi Rapat</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 dark:text-gray-300">
                        @foreach($top_users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                <td class="px-4 py-2 border">{{ $user->name }}</td>
                                <td class="px-4 py-2 border">{{ $user->isi_rapats_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>
