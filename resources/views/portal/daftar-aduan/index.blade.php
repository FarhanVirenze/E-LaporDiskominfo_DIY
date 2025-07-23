@extends('portal.layouts.app')

@section('include-css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection

@section('content')
    <h2 class="text-3xl font-bold text-gray-800 mb-8 mt-16 text-center">Daftar Aduan</h2>

    <!-- Container untuk memberi margin dan padding -->
    <div class="container mx-auto px-4">
        <!-- Grid yang menampilkan 3 kolom di desktop, 1 kolom di mobile -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @forelse (\App\Models\Report::latest()->take(5)->get() as $report)
                <div
                    class="bg-white border-2 border-gray-300 p-4 shadow-lg rounded-lg hover:shadow-xl transition duration-300 w-full mx-auto">
                    <h3 class="font-semibold text-lg text-gray-800 text-left truncate">
                        {{ Str::limit($report->judul, 28) }}
                    </h3>
                    <p class="text-sm text-gray-600 mt-2 text-left line-clamp-2">
                        {{ $report->isi }}
                    </p>

                    <div class="mt-4">
                        <!-- User Info and Date -->
                        <div class="flex items-center text-xs text-gray-500 space-x-2">
                            <i class="fas fa-user text-blue-500"></i>
                            <span class="font-semibold">{{ $report->nama_pengadu }}</span>
                        </div>

                        <div class="flex items-center text-xs text-gray-500 mt-2 space-x-2">
                            <i class="fas fa-clock text-gray-500"></i>
                            <span>
                                Dikirim pada:
                                {{ $report->created_at->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM YYYY, HH.mm') }}
                                WIB
                            </span>
                        </div>

                        <!-- Category and Status -->
                        <div class="flex items-center text-xs text-gray-500 mt-2 space-x-2">
                            <i class="fas fa-list-alt text-green-500"></i>
                            <span>{{ $report->kategori->nama }}</span>
                        </div>

                        <div class="flex items-center text-xs text-gray-500 mt-2 space-x-2">
                            <i class="fas fa-tasks text-yellow-500"></i>
                            <span class="font-semibold">Status: </span>
                            <span class="status-text 
                                        @if($report->status == 'Diajukan') bg-blue-200 text-blue-800 
                                        @elseif($report->status == 'Dibaca') bg-teal-200 text-teal-800 
                                        @elseif($report->status == 'Direspon') bg-yellow-200 text-yellow-800 
                                        @elseif($report->status == 'Selesai') bg-green-200 text-green-800 
                                        @endif 
                                        rounded-full px-2 py-1 text-xs font-semibold">
                                {{ $report->status }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Jika tidak ada data laporan, tampilkan pesan alert -->
                <div class="alert alert-info col-span-full">
                    Tidak ada aduan terbaru saat ini.
                </div>
            @endforelse
        </div>
    </div>
@endsection