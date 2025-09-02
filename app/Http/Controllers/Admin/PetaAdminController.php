<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\KategoriUmum;
use App\Models\WilayahUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PetaAdminController extends Controller
{
    public function index(Request $request)
    {
        $adminId = Auth::user()->id_user; // ✅ sesuai dengan relasi admin_id di migration

        $query = Report::with(['kategori', 'wilayah'])
            ->where('admin_id', $adminId);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan kategori
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter berdasarkan wilayah
        if ($request->filled('wilayah')) {
            $query->where('wilayah_id', $request->wilayah);
        }

        $reports = $query->get();
        $kategori = KategoriUmum::where('admin_id', $adminId)->get();
        $wilayah = WilayahUmum::all();

        return view('admin.peta.index', compact('reports', 'kategori', 'wilayah'));
    }
}
