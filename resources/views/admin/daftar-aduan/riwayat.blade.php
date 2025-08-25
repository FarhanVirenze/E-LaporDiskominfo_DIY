@extends('admin.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')

    <!-- Notifikasi Sukses -->
    @if (session('success'))
        <div id="alert-success"
            class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-green-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 opacity-100 animate-fade-in">
            <!-- Icon Wrapper -->
            <div id="success-icon-wrapper" class="transition-all duration-300">
                <!-- Spinner awal -->
                <svg id="success-spinner" class="w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                </svg>

                <!-- Centang, disembunyikan dulu -->
                <svg id="success-check" class="w-6 h-6 text-white hidden" fill="none" viewBox="0 0 24 24">
                    <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                </svg>
            </div>
            <!-- Pesan -->
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div id="alert-error"
            class="fixed top-5 right-5 z-50 flex items-center gap-3 bg-red-500 text-white px-5 py-3 rounded-lg shadow-lg transition-opacity duration-500 opacity-100 animate-fade-in">
            <!-- Icon -->
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24">
                <path stroke="white" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @component('components.riwayatadmin-tabs')
            <div class="mb-4 mt-2 text-left">
                <a href="{{ route('admin.beranda') }}"
                    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    + Buat Aduan Baru
                </a>
            </div>

            <p class="text-sm text-gray-600 mb-3">Total: {{ $aduan->count() }} Aduan</p>

            <!-- RESPONSIVE TABLE -->
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full text-sm hidden md:table">
                    <thead class="bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] text-white">
                        <tr>
                            <th class="px-4 py-3 text-left">No</th>
                            <th class="px-4 py-3 text-left">No. Tiket</th>
                            <th class="px-4 py-3 text-left">Judul</th>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($aduan as $index => $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $item->tracking_id }}</td>
                                <td class="px-4 py-2">{{ $item->judul }}</td>
                                <td class="px-4 py-2">
                                    {{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY') }}
                                </td>
                                <td class="px-4 py-2">
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full
                                                                                @if($item->status == 'Diajukan') bg-red-100 text-red-700
                                                                                @elseif($item->status == 'Dibaca') bg-blue-100 text-blue-700
                                                                                @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                                                @elseif($item->status == 'Selesai') bg-green-100 text-green-700
                                                                                @else bg-gray-200 text-gray-800 @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-2">
                                    <a href="{{ route('admin.reports.show', $item->id) }}" class="text-red-600 hover:text-red-800">
                                        <i class="fas fa-search"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-4 text-center text-gray-500">
                                    Tidak ada aduan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- TABEL MOBILE RESPONSIF -->
                <div class="md:hidden space-y-4">
                    @forelse ($aduan as $index => $item)
                        <div class="rounded-xl shadow-lg overflow-hidden">
                            <!-- Header dengan gradasi -->
                            <div
                                class="bg-gradient-to-r from-[#B5332A] to-[#8B1E1E] p-2 px-4 text-white text-xs flex justify-between">
                                <span>{{ $index + 1 }}. {{ $item->tracking_id }}</span>
                                <span>{{ $item->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            </div>

                            <!-- Konten card -->
                            <div class="bg-white text-gray-800 p-4">
                                <div class="font-bold text-base mb-2">
                                    {{ $item->judul }}
                                </div>

                                <div>
                                    <span class="text-xs font-semibold px-2 py-1 rounded-full
                                                        @if($item->status == 'Diajukan') bg-blue-100 text-blue-800
                                                        @elseif($item->status == 'Dibaca') bg-teal-100 text-teal-800
                                                        @elseif($item->status == 'Direspon') bg-yellow-100 text-yellow-800
                                                        @elseif($item->status == 'Selesai') bg-green-100 text-green-800
                                                        @else bg-gray-200 text-gray-800 @endif">
                                        {{ $item->status }}
                                    </span>
                                </div>

                                <div class="mt-3">
                                    <a href="{{ route('admin.reports.show', $item->id) }}"
                                        class="inline-flex items-center text-sm text-red-700 font-semibold hover:text-[#8B1E1E] transition-colors duration-200">
                                        <i class="fas fa-search mr-1"></i> Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 text-center text-gray-500">
                            Tidak ada aduan.
                        </div>
                    @endforelse
                </div>
            </div>
            @endcomponent
        </div>
    </div>
    @push('scripts')
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const spinner = document.getElementById('success-spinner');
                const check = document.getElementById('success-check');

                setTimeout(() => {
                    if (spinner && check) {
                        spinner.classList.add('hidden');
                        check.classList.remove('hidden');
                        check.classList.add('scale-100');
                    }
                }, 1000);

                const fadeOutAndRemove = el => {
                    if (!el) return;
                    el.classList.remove('opacity-100');
                    el.classList.add('opacity-0');
                    setTimeout(() => el.style.display = 'none', 500);
                };

                setTimeout(() => {
                    fadeOutAndRemove(document.getElementById('alert-success'));
                    fadeOutAndRemove(document.getElementById('alert-error'));
                }, 3000);
            });
        </script>
    @endpush
@endsection