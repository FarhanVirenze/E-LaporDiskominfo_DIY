<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\KategoriUmum;
use App\Models\WilayahUmum;
use Illuminate\Http\Request;

class DaftarAduanController extends Controller
{
    public function index(Request $request)
    {
        $kategoriList = KategoriUmum::select('id', 'nama')->get();
        $wilayahList = WilayahUmum::select('id', 'nama')->get();

        // Base query
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role === 'admin') {
                // Admin hanya melihat kategori sesuai miliknya
                $kategoriIds = $user->kategori->pluck('id')->toArray();
                $reportsQuery = Report::whereIn('kategori_id', $kategoriIds);
            } else {
                // superadmin & user biasa bisa lihat semua
                $reportsQuery = Report::query();
            }
        } else {
            // Guest lihat semua
            $reportsQuery = Report::query();
        }

        // Filter tambahan dari request
        if ($request->filled('status')) {
            $reportsQuery->where('status', $request->status);
        }
        if ($request->filled('kategori')) {
            $reportsQuery->where('kategori_id', $request->kategori);
        }
        if ($request->filled('wilayah')) {
            $reportsQuery->where('wilayah_id', $request->wilayah);
        }
        if ($request->filled('tanggal')) {
            $reportsQuery->whereDate('created_at', $request->tanggal);
        }

        // Sorting
        switch ($request->sort) {
            case 'terlama':
                $reportsQuery->oldest();
                break;
            case 'likes':
                $reportsQuery->orderBy('likes', 'desc');
                break;
            case 'views':
                $reportsQuery->orderBy('views', 'desc');
                break;
            default:
                $reportsQuery->latest();
                break;
        }

        $reports = $reportsQuery->get([
            'id',
            'judul',
            'isi',
            'nama_pengadu',
            'kategori_id',
            'status',
            'file',
            'is_anonim',
            'created_at',
            'likes',
            'views'
        ]);

        $reports = $reportsQuery->paginate(10)->withQueryString();

        return view('portal.daftar-aduan.index', [
            'page_title' => 'Daftar Aduan | E-Lapor DIY',
            'kategoriList' => $kategoriList,
            'wilayahList' => $wilayahList,
            'reports' => $reports
        ]);
    }
}
