<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white leading-tight tracking-wide">
            📋 Detail Agenda
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-8 sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6 space-y-6">
            {{-- Nama Agenda --}}
            <div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
                    📌 {{ $agenda->nm_agenda }}
                </h3>
            </div>

            {{-- Informasi Utama --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
                <div>
                    <span class="font-medium">📅 Tanggal:</span>
                    <span class="ml-1">{{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}</span>
                </div>
                <div>
                    <span class="font-medium">⏰ Waktu:</span>
                    <span class="ml-1">{{ $agenda->waktu }}</span>
                </div>
                <div>
                    <span class="font-medium">🏢 Ruangan:</span>
                    <span class="ml-1">{{ $agenda->ruangan->nm_ruangan }}</span>
                </div>
                <div>
                    <span class="font-medium">👤 Dibuat oleh:</span>
                    <span class="ml-1">{{ $agenda->user->name }}</span>
                </div>
                <div>
                    <span class="font-medium">👨‍💼 PIC:</span>
                    <span class="ml-1">{{ $agenda->pic?->name ?? '-' }}</span>
                </div>
                <div>
                    <span class="font-medium">📄 Status:</span>
                    <span class="ml-1 inline-block px-2 py-1 text-xs font-semibold rounded-full
                        {{ $agenda->status === 'disetujui' ? 'bg-green-500 text-white' : ($agenda->status === 'ditolak' ? 'bg-red-500 text-white' : 'bg-yellow-500 text-white') }}">
                        {{ ucfirst($agenda->status) }}
                    </span>
                </div>
            </div>

            <hr class="border-t border-gray-300 dark:border-gray-600">

            {{-- Deskripsi --}}
            <div>
                <h4 class="font-medium text-gray-700 dark:text-gray-300 mb-1">📝 Deskripsi:</h4>
                <p class="text-gray-800 dark:text-gray-100 text-sm">{{ $agenda->deskripsi ?? '-' }}</p>
            </div>

            {{-- Persetujuan (Jika Ada) --}}
            @if($agenda->approvedBy)
                <hr class="border-t border-gray-300 dark:border-gray-600">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <div>
                        <span class="font-medium">✅ Disetujui oleh:</span>
                        <span class="ml-1">{{ $agenda->approvedBy->name }}</span>
                    </div>
                    <div>
                        <span class="font-medium">🕒 Waktu Persetujuan:</span>
                        <span class="ml-1">{{ \Carbon\Carbon::parse($agenda->approved_at)->format('d M Y H:i') }}</span>
                    </div>
                </div>
            @endif

            {{-- Tombol Kembali --}}
            <div class="pt-4">
                <a href="{{ route('agendas.index') }}"
                   class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-semibold px-4 py-2 rounded shadow">
                    ⬅️ Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
