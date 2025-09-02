<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\KategoriUmum;
use App\Models\WilayahUmum;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::with(['kategori', 'wilayah']);

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
        $kategori = KategoriUmum::all();
        $wilayah = WilayahUmum::all();

        return view('superadmin.peta.index', compact('reports', 'kategori', 'wilayah'));
    }

}
