<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white leading-tight tracking-wide">
            {{ isset($agenda) ? 'Edit Agenda' : 'Tambah Agenda' }}
        </h2>
    </x-slot>

    <div class="mt-4 p-6 max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-lg shadow-md space-y-6">
        <form method="POST" action="{{ isset($agenda) ? route('agendas.update', $agenda->id_agenda) : route('agendas.store') }}">
            @csrf
            @if(isset($agenda)) @method('PUT') @endif

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📌 Nama Agenda</label>
                <input name="nm_agenda" type="text" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm px-4 py-2"
                    value="{{ old('nm_agenda', $agenda->nm_agenda ?? '') }}" required />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📅 Tanggal</label>
                    <input type="date" name="tanggal" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm px-4 py-2"
                        value="{{ old('tanggal', isset($agenda) && $agenda->tanggal ? \Illuminate\Support\Carbon::parse($agenda->tanggal)->format('Y-m-d') : '') }}" required />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">⏰ Waktu</label>
                    <input type="time" name="waktu" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm px-4 py-2"
                        value="{{ old('waktu', $agenda->waktu ?? '') }}" required />
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">📝 Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="3" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm px-4 py-2">{{ old('deskripsi', $agenda->deskripsi ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">🏢 Ruangan</label>
                <select id="ruangan-select" name="id_ruangan" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm px-4 py-2" required>
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

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">👤 Penanggung Jawab (PIC)</label>
                <select name="id_pic" id="id_pic" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white rounded-md shadow-sm px-4 py-2">
                    <option value="">-- Pilih PIC --</option>
                    @foreach($pic_users as $user)
                        <option value="{{ $user->id_user }}" @if(old('id_pic', $agenda->id_pic ?? '') == $user->id_user) selected @endif>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="bg-gray-100 dark:bg-gray-700 px-4 py-2 rounded-md" id="kapasitas-display" style="display:none;">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">👥 Kapasitas:</label>
                <p class="text-lg font-semibold text-gray-800 dark:text-white" id="kapasitas-text">-</p>
            </div>

            <div class="pt-4">
                <button type="submit"
                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-md shadow">
                    {{ isset($agenda) ? '💾 Update' : '✅ Simpan' }}
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

            updateKapasitas();
            select.addEventListener('change', updateKapasitas);
        });
    </script>
</x-app-layout>
