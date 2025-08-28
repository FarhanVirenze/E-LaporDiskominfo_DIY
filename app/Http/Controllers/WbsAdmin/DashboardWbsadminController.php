<?php

namespace App\Http\Controllers\WbsAdmin;

use App\Http\Controllers\Controller;
use App\Models\WbsReport;
use Illuminate\Support\Carbon;

class DashboardWbsadminController extends Controller
{
    public function index()
    {
        // Ambil nama wbs admin yang login
        $wbsAdminName = auth()->user()->name;

        // Hitung status laporan
        $pendingCount = WbsReport::where('status', 'Diajukan')->count();
        $readCount = WbsReport::where('status', 'Dibaca')->count();
        $respondedCount = WbsReport::where('status', 'Direspon')->count();
        $completedCount = WbsReport::where('status', 'Selesai')->count();
        $totalReports = $pendingCount + $readCount + $respondedCount + $completedCount;

        // Anonim vs Terdaftar
        $anonimCount = WbsReport::where('is_anonim', true)->count();
        $registeredCount = WbsReport::where('is_anonim', false)->count();

        // Distribusi wilayah
        $wilayahData = WbsReport::selectRaw('wilayah_id, COUNT(*) as total')
            ->groupBy('wilayah_id')
            ->with('wilayah')
            ->get();
        $wilayahLabels = $wilayahData->pluck('wilayah.nama');
        $wilayahCounts = $wilayahData->pluck('total');

        // Statistik kategori aduan
        $kategoriSemua = WbsReport::selectRaw('kategori_id, COUNT(*) as total')
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
            $data = WbsReport::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
                ->where('created_at', '>=', $start)
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            $aktivitasSemuaRange[$range] = [
                'tanggal' => $data->pluck('tanggal'),
                'jumlah' => $data->pluck('jumlah'),
            ];
        }

        return view('wbs_admin.dashboard', compact(
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
            'wbsAdminName'
        ));
    }
}
