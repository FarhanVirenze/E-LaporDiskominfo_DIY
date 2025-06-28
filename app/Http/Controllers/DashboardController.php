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
        $authRole = auth()->user()->role;

        // Hitung jumlah user hanya untuk role non-user
        $jumlah_user = in_array($authRole, ['admin', 'pimpinan'])
            ? User::count()
            : null;

        $jumlah_agenda = Agenda::count();
        $jumlah_ruangan = Ruangan::count();
        $jumlah_isi_rapat = IsiRapat::count();
        $jumlah_notif = Notif::count();

        $notifs = Notif::with('user')
            ->where('status', 'belum terbaca')
            ->latest()
            ->limit(5)
            ->get();

        $semua_agenda = Agenda::with('ruangan')
            ->latest()
            ->limit(5)
            ->get();

        // Ambil top 5 user role 'user' berdasarkan jumlah isi rapat
        $top_users = User::where('role', 'user')
            ->withCount('isiRapats')
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
