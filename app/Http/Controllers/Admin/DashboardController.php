<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil ID admin yang sedang login (id_user dari tabel users)
        $adminId = auth()->user()->id_user;

        $adminName = auth()->user()->name; // atau ->name

        // Hitung status laporan (khusus admin login)
        $pendingCount = Report::where('admin_id', $adminId)->where('status', 'Diajukan')->count();
        $readCount = Report::where('admin_id', $adminId)->where('status', 'Dibaca')->count();
        $respondedCount = Report::where('admin_id', $adminId)->where('status', 'Direspon')->count();
        $completedCount = Report::where('admin_id', $adminId)->where('status', 'Selesai')->count();
        $totalReports = $pendingCount + $readCount + $respondedCount + $completedCount;

        // Anonim vs Terdaftar
        $anonimCount = Report::where('admin_id', $adminId)->where('is_anonim', true)->count();
        $registeredCount = Report::where('admin_id', $adminId)->where('is_anonim', false)->count();

        // Distribusi wilayah
        $wilayahData = Report::where('admin_id', $adminId)
            ->selectRaw('wilayah_id, COUNT(*) as total')
            ->groupBy('wilayah_id')
            ->with('wilayah')
            ->get();
        $wilayahLabels = $wilayahData->pluck('wilayah.nama');
        $wilayahCounts = $wilayahData->pluck('total');

        // Statistik kategori aduan (semua kategori untuk admin login)
        $kategoriSemua = Report::where('admin_id', $adminId)
            ->selectRaw('kategori_id, COUNT(*) as total')
            ->groupBy('kategori_id')
            ->with('kategori')
            ->orderByDesc('total')
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->kategori->nama ?? 'Tidak diketahui',
                    'jumlah' => $item->total,
                ];
            });

        $kategoriUmumData = [
            'all' => [
                'labels' => $kategoriSemua->pluck('nama'),
                'counts' => $kategoriSemua->pluck('jumlah'),
            ],
        ];

        // Grafik aktivitas laporan (7, 30, 60, 90 hari terakhir)
        $ranges = ['7', '30', '60', '90'];
        $aktivitasSemuaRange = [];

        foreach ($ranges as $range) {
            $start = Carbon::now()->subDays((int) $range);
            $data = Report::where('admin_id', $adminId)
                ->selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
                ->where('created_at', '>=', $start)
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            $aktivitasSemuaRange[$range] = [
                'tanggal' => $data->pluck('tanggal'),
                'jumlah' => $data->pluck('jumlah'),
            ];
        }

        return view('admin.dashboard', compact(
            'pendingCount',
            'readCount',
            'respondedCount',
            'completedCount',
            'totalReports',
            'kategoriUmumData',
            'wilayahLabels',
            'wilayahCounts',
            'anonimCount',
            'registeredCount',
            'aktivitasSemuaRange',
            'adminName'
        ));
    }
}
