<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardSuperadminController extends Controller
{
    public function index(Request $request)
    {
        // Hitung user dan admin
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();
        $totalUsers = $adminCount + $userCount;

        // Hitung status laporan
        $pendingCount = Report::where('status', 'Diajukan')->count();
        $readCount = Report::where('status', 'Dibaca')->count();
        $respondedCount = Report::where('status', 'Direspon')->count();
        $completedCount = Report::where('status', 'Selesai')->count();
        $totalReports = $pendingCount + $readCount + $respondedCount + $completedCount;

        $topAdmins = Report::whereNotNull('admin_id')
            ->selectRaw('admin_id, COUNT(*) as jumlah')
            ->groupBy('admin_id')
            ->orderByDesc('jumlah')
            ->take(10) // ambil 5 admin teratas
            ->get()
            ->map(function ($item) {
                $admin = User::find($item->admin_id);
                return [
                    'nama' => $admin ? $admin->name : 'Tidak diketahui',
                    'jumlah' => $item->jumlah,
                ];
            });

        $adminLabels = $topAdmins->pluck('nama');
        $adminCounts = $topAdmins->pluck('jumlah');

        // Anonim vs Terdaftar
        $anonimCount = Report::where('is_anonim', true)->count();
        $registeredCount = Report::where('is_anonim', false)->count();

        // Distribusi wilayah
        $wilayahData = Report::selectRaw('wilayah_id, COUNT(*) as total')
            ->groupBy('wilayah_id')
            ->with('wilayah')
            ->get();
        $wilayahLabels = $wilayahData->pluck('wilayah.nama');
        $wilayahCounts = $wilayahData->pluck('total');

        // Statistik kategori aduan
        $kategoriData = Report::selectRaw('kategori_id, COUNT(*) as total')
            ->groupBy('kategori_id')
            ->with('kategori')
            ->orderByDesc('total') // Tambahkan ini
            ->take(10) // Tambahkan ini
            ->get();
        $kategoriLabels = $kategoriData->pluck('kategori.nama');
        $kategoriCounts = $kategoriData->pluck('total');

        // Kategori berdasarkan admin (Top 5 admin + kategorinya)
        $kategoriPerAdmin = Report::selectRaw('admin_id, kategori_id, COUNT(*) as total')
            ->whereNotNull('admin_id')
            ->groupBy('admin_id', 'kategori_id')
            ->with(['admin', 'kategori'])
            ->get()
            ->groupBy('admin_id');

        // Urutkan dan ambil top 10 admin dengan total aduan terbanyak
        $kategoriAdminData = $kategoriPerAdmin->map(function ($reports, $adminId) {
            $admin = $reports->first()->admin;
            $kategori = $reports->mapWithKeys(function ($item) {
                return [$item->kategori->nama ?? 'Tidak diketahui' => $item->total];
            });
            $total = $kategori->sum(); // jumlah total aduan dari admin ini

            return [
                'admin' => $admin ? $admin->name : 'Tidak diketahui',
                'kategori' => $kategori,
                'total' => $total,
            ];
        })
            ->sortByDesc('total') // urutkan berdasarkan total
            ->take(10) // ambil 5 teratas
            ->values(); // reset indexing

        // === Grafik Aktivitas Laporan ===
        $range = $request->query('range', '7');
        $days = in_array($range, ['7', '30', '60', '90']) ? (int) $range : 30;

        $startDate = Carbon::now()->subDays($days);

        $aktivitasData = Report::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
            ->where('created_at', '>=', $startDate)
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $tanggalAktivitas = $aktivitasData->pluck('tanggal');
        $jumlahAktivitas = $aktivitasData->pluck('jumlah');

        return view('superadmin.dashboard', compact(
            'adminCount',
            'userCount',
            'totalUsers',
            'pendingCount',
            'readCount',
            'respondedCount',
            'completedCount',
            'totalReports',
            'kategoriLabels',
            'kategoriCounts',
            'wilayahLabels',
            'wilayahCounts',
            'anonimCount',
            'registeredCount',
            'tanggalAktivitas',
            'jumlahAktivitas',
            'adminLabels',
            'adminCounts',
            'kategoriAdminData',
            'range'
        ));
    }
}
