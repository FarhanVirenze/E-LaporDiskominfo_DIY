<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($isiRapat) ? 'Edit Isi Rapat' : 'Tambah Isi Rapat' }}
        </h2>
    </x-slot>

    <div class="p-6 max-w-3xl mx-auto">
        <form 
            action="{{ isset($isiRapat) ? route('isi_rapats.update', $isiRapat->id_rapat) : route('isi_rapats.store') }}" 
            method="POST" class="space-y-5">
            @csrf
            @if(isset($isiRapat)) @method('PUT') @endif

            {{-- Agenda --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300">Agenda *</label>
                <select name="id_agenda" class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-800 dark:text-white" required>
                    <option value="">-- Pilih Agenda --</option>
                    @foreach($agendas as $agenda)
                        <option value="{{ $agenda->id_agenda }}"
                            {{ (old('id_agenda', $isiRapat->id_agenda ?? '') == $agenda->id_agenda) ? 'selected' : '' }}>
                            {{ $agenda->nm_agenda }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Pembahasan --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300">Pembahasan *</label>
                <input type="text" name="pembahasan"
                       value="{{ old('pembahasan', $isiRapat->pembahasan ?? '') }}"
                       class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-800 dark:text-white" required>
            </div>

            {{-- PIC --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300">PIC *</label>
                <input type="text" name="pic"
                       value="{{ old('pic', $isiRapat->pic ?? '') }}"
                       class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-800 dark:text-white" required>
            </div>

            {{-- Kriteria --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300">Kriteria *</label>
                <input type="text" name="kriteria"
                       value="{{ old('kriteria', $isiRapat->kriteria ?? '') }}"
                       class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-800 dark:text-white" required>
            </div>

            {{-- Status --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300">Status *</label>
                <select name="status" class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-800 dark:text-white" required>
                    <option value="open" {{ old('status', $isiRapat->status ?? '') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="progress" {{ old('status', $isiRapat->status ?? '') == 'progress' ? 'selected' : '' }}>Progress</option>
                    <option value="selesai" {{ old('status', $isiRapat->status ?? '') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            {{-- Dateline --}}
            <div>
                <label class="block font-semibold text-gray-700 dark:text-gray-300">Dateline *</label>
                <input type="date" name="dateline"
                       value="{{ old('dateline', isset($isiRapat) ? \Carbon\Carbon::parse($isiRapat->dateline)->format('Y-m-d') : '') }}"
                       class="w-full px-3 py-2 border rounded bg-white dark:bg-gray-800 dark:text-white" required>
            </div>

            {{-- Submit --}}
            <div>
                <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-5 py-2 rounded shadow">
                    {{ isset($isiRapat) ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
