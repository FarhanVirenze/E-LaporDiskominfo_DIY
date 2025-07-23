@extends('portal.layouts.error')

@section('content')
    <div
        class="min-h-screen flex flex-col items-center justify-center text-white text-center px-6 space-y-6 relative overflow-hidden">

        {{-- Logo --}}
        <img src="{{ asset('images/logo-diy.png') }}" alt="Logo DIY" class="w-36 h-32 drop-shadow-lg animate-fade-in z-10">

        {{-- Angka 404 --}}
        <div class="text-7xl md:text-9xl font-extrabold text-white animate-horizontal-bounce z-10 drop-shadow-xl">
            404
        </div>

        {{-- Judul --}}
        <h1 class="text-3xl md:text-4xl font-bold z-10 animate-fade-in">
            Oops! Akses Ditolak.
        </h1>

        {{-- Pesan --}}
        <p class="text-base md:text-lg text-white/90 max-w-md z-10 leading-relaxed animate-fade-in">
            Halaman ini tidak dapat Anda akses karena keterbatasan hak akses
        </p>

        {{-- Tombol --}}
        <a href="{{ route('beranda') }}" class="bg-white text-red-700 font-semibold px-6 py-2 rounded-full shadow-lg 
              hover:bg-red-200 hover:text-red-800 hover:scale-105 
              transform transition-all duration-300 z-10 animate-fade-in">
            ← Kembali ke Beranda
        </a>
    </div>
@endsection

@push('scripts')
    <style>
        @keyframes horizontal-bounce {

            0%,
            100% {
                transform: translateX(0);
            }

            50% {
                transform: translateX(20px);
            }
        }

        .animate-horizontal-bounce {
            animation: horizontal-bounce 1.4s infinite ease-in-out;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }
    </style>
@endpush