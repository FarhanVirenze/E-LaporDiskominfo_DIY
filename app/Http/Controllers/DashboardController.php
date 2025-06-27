<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Agenda;
use App\Models\Ruangan;
use App\Models\IsiRapat;
use App\Models\Notif;

class DashboardController extends Controller
{
    public function index()
    {
        // Jumlah total data dari setiap tabel
        $jumlah_user        = User::count();
        $jumlah_agenda      = Agenda::count();
        $jumlah_ruangan     = Ruangan::count();
        $jumlah_isi_rapat   = IsiRapat::count();
        $jumlah_notif       = Notif::count();

        // Data notifikasi aktif (misal status = 'belum terbaca')
        $notifs = Notif::with('user')
                    ->where('status', 'belum terbaca')
                    ->latest()
                    ->limit(5)
                    ->get();

        // Semua agenda terbaru
        $semua_agenda = Agenda::with('ruangan')->latest()->limit(5)->get();

        // Top 5 user berdasarkan kontribusi isi rapat terbanyak
        $top_users = User::withCount('isiRapats')
                    ->orderByDesc('isi_rapats_count')
                    ->limit(5)
                    ->get();

        return view('dashboard', compact(
            'jumlah_user',
            'jumlah_agenda',
            'jumlah_ruangan',
            'jumlah_isi_rapat',
            'jumlah_notif',
            'notifs',
            'semua_agenda',
            'top_users'
        ));
    }
}
