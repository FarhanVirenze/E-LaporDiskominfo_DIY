<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
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

        // === Top Admin Penerima (Top 10 dan Semua) ===
        $adminSemua = Report::whereNotNull('admin_id')
            ->selectRaw('admin_id, COUNT(*) as jumlah')
            ->groupBy('admin_id')
            ->orderByDesc('jumlah')
            ->get()
            ->map(function ($item) {
                $admin = User::find($item->admin_id);
                return [
                    'nama' => $admin ? $admin->name : 'Tidak diketahui',
                    'jumlah' => $item->jumlah,
                ];
            });

        $adminTop10 = $adminSemua->take(10);

        // Format data
        $adminData = [
            'top10' => [
                'labels' => $adminTop10->pluck('nama'),
                'data' => $adminTop10->pluck('jumlah'),
            ],
            'semua' => [
                'labels' => $adminSemua->pluck('nama'),
                'data' => $adminSemua->pluck('jumlah'),
            ],
        ];

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
        $kategoriSemua = Report::selectRaw('kategori_id, COUNT(*) as total')
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

        $kategoriTop10 = $kategoriSemua->take(10);

        $kategoriUmumData = [
            'top10' => [
                'labels' => $kategoriTop10->pluck('nama'),
                'counts' => $kategoriTop10->pluck('jumlah'),
            ],
            'all' => [
                'labels' => $kategoriSemua->pluck('nama'),
                'counts' => $kategoriSemua->pluck('jumlah'),
            ],
        ];

        // Kategori berdasarkan admin (Top 10 admin + kategorinya)
        $kategoriPerAdmin = Report::selectRaw('admin_id, kategori_id, COUNT(*) as total')
            ->whereNotNull('admin_id')
            ->groupBy('admin_id', 'kategori_id')
            ->with(['admin', 'kategori'])
            ->get()
            ->groupBy('admin_id');

        $kategoriAdminDataAll = $kategoriPerAdmin->map(function ($reports, $adminId) {
            $admin = $reports->first()->admin;
            $kategori = $reports->mapWithKeys(function ($item) {
                return [$item->kategori->nama ?? 'Tidak diketahui' => $item->total];
            });
            $total = $kategori->sum();

            return [
                'admin' => $admin ? $admin->name : 'Tidak diketahui',
                'kategori' => $kategori,
                'total' => $total,
            ];
        })->sortByDesc('total')->values();

        $kategoriAdminDataTop10 = $kategoriAdminDataAll->take(10);

        // === Grafik Aktivitas Laporan (Semua Range Sekaligus) ===
        $ranges = ['7', '30', '60', '90'];
        $aktivitasSemuaRange = [];

        foreach ($ranges as $range) {
            $start = Carbon::now()->subDays((int) $range);
            $data = Report::selectRaw('DATE(created_at) as tanggal, COUNT(*) as jumlah')
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
            'adminCount',
            'userCount',
            'totalUsers',
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
            'adminData',
            'kategoriAdminDataTop10',
            'kategoriAdminDataAll'
        ));
    }
}
