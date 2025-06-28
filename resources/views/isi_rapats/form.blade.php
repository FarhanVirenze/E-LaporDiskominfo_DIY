<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white leading-tight">
            Tambah Isi Rapat
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto py-6">
        <form method="POST"
            action="{{ $isiRapat ? route('isi_rapats.update', $isiRapat->id_rapat) : route('isi_rapats.store') }}">
            @csrf
            @if($isiRapat)
                @method('PUT')
            @endif

            {{-- Pilih Agenda --}}
            @if(!$isiRapat)
                <div class="mb-4">
                    <label for="id_agenda" class="block font-medium mb-1 text-gray-700 dark:text-gray-300">
                        Pilih Agenda
                    </label>
                    <select name="id_agenda" id="id_agenda"
                        class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white" required>
                        <option value="">-- Pilih Agenda --</option>
                        @foreach ($agendas as $agenda)
                            <option value="{{ $agenda->id_agenda }}" {{ old('id_agenda') == $agenda->id_agenda ? 'selected' : '' }}>
                                {{ $agenda->nm_agenda }} - {{ \Carbon\Carbon::parse($agenda->tanggal)->format('d M Y') }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_agenda')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            @endif

            {{-- Pembahasan --}}
            <div class="mb-4">
                <label for="pembahasan" class="block font-medium mb-1 text-gray-700 dark:text-gray-300">
                    Pembahasan
                </label>
                <textarea name="pembahasan" id="pembahasan" rows="4"
                    class="w-full border rounded px-3 py-2 dark:bg-gray-700 dark:text-white"
                    required>{{ old('pembahasan') }}</textarea>
                @error('pembahasan')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
<div class="mt-6 space-x-2">
    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
        Simpan
    </button>
    <a href="{{ route('isi_rapats.index') }}" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded shadow inline-block">
        Batal
    </a>
</div>
        </form>
    </div>
</x-app-layout>