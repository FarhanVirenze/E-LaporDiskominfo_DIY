<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white leading-tight tracking-wide">
            🔔 Detail Notifikasi
        </h2>
    </x-slot>

    <div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                    📢 {{ $notif->jenis_notif }}
                </h3>
                <span class="px-3 py-1 text-sm font-medium rounded-full text-white
                    {{ $notif->status === 'terbaca' ? 'bg-green-500' : 'bg-yellow-500' }}">
                    {{ ucfirst($notif->status) }}
                </span>
            </div>

            <div class="space-y-2 text-gray-700 dark:text-gray-300">
                <div>
                    <span class="font-semibold">📝 Keterangan:</span>
                    <p class="mt-1 text-gray-800 dark:text-gray-200">{{ $notif->keterangan }}</p>
                </div>

                <div class="flex items-center gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <div>
                        <span class="font-semibold">📅 Tanggal:</span>
                        {{ \Carbon\Carbon::parse($notif->tanggal)->format('d M Y') }}
                    </div>
                    <div>
                        <span class="font-semibold">⏰ Waktu:</span>
                        {{ $notif->waktu }}
                    </div>
                </div>
            </div>

            <div class="pt-4">
                <a href="{{ route('notifs.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold px-4 py-2 rounded shadow">
                    ⬅️ Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
