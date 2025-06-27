<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($agenda) ? 'Edit Agenda' : 'Tambah Agenda' }}
        </h2>
    </x-slot>

    <div class="p-6">
        <form method="POST" action="{{ isset($agenda) ? route('agendas.update', $agenda->id_agenda) : route('agendas.store') }}">
            @csrf
            @if(isset($agenda)) @method('PUT') @endif

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Nama Agenda</label>
                <input name="nm_agenda" type="text" class="w-full border rounded px-3 py-2"
                    value="{{ old('nm_agenda', $agenda->nm_agenda ?? '') }}" required />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border rounded px-3 py-2"
                    value="{{ old('tanggal', isset($agenda) && $agenda->tanggal ? \Illuminate\Support\Carbon::parse($agenda->tanggal)->format('Y-m-d') : '') }}" required />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Waktu</label>
                <input type="time" name="waktu" class="w-full border rounded px-3 py-2"
                    value="{{ old('waktu', $agenda->waktu ?? '') }}" required />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" class="w-full border rounded px-3 py-2">{{ old('deskripsi', $agenda->deskripsi ?? '') }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300">Ruangan</label>
                <select id="ruangan-select" name="id_ruangan" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($ruangans as $ruangan)
                        <option 
                            value="{{ $ruangan->id_ruangan }}" 
                            data-kapasitas="{{ $ruangan->kapasitas }}"
                            {{ old('id_ruangan', $agenda->id_ruangan ?? '') == $ruangan->id_ruangan ? 'selected' : '' }}>
                            {{ $ruangan->nm_ruangan }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
    <x-input-label for="id_pic" value="Penanggung Jawab (PIC)" />
    <select name="id_pic" id="id_pic" class="block mt-1 w-full rounded-md shadow-sm">
        <option value="">-- Pilih PIC --</option>
        @foreach($pic_users as $user)
            <option value="{{ $user->id_user }}" @if(old('id_pic', $agenda->id_pic ?? '') == $user->id_user) selected @endif>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>
            <div class="mb-4" id="kapasitas-display" style="display:none;">
                <label class="block text-gray-700 dark:text-gray-300">Kapasitas:</label>
                <p class="text-gray-800 dark:text-white font-semibold" id="kapasitas-text">-</p>
            </div>

            <div>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded">
                    {{ isset($agenda) ? 'Update' : 'Simpan' }}
                </button>
            </div>
        </form>
    </div>

    {{-- Script --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const select = document.getElementById('ruangan-select');
            const kapasitasDisplay = document.getElementById('kapasitas-display');
            const kapasitasText = document.getElementById('kapasitas-text');

            function updateKapasitas() {
                const selected = select.options[select.selectedIndex];
                const kapasitas = selected.getAttribute('data-kapasitas');

                if (kapasitas) {
                    kapasitasText.textContent = kapasitas + ' orang';
                    kapasitasDisplay.style.display = 'block';
                } else {
                    kapasitasDisplay.style.display = 'none';
                }
            }

            // Trigger on load (for edit mode)
            updateKapasitas();

            // Trigger on change
            select.addEventListener('change', updateKapasitas);
        });
    </script>
</x-app-layout>
