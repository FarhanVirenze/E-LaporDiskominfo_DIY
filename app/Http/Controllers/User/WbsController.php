<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WbsReport;

class WbsController extends Controller
{
    public function index()
    {
        $wbsReports = WbsReport::where('user_id', auth()->id())->get();
        return view('user.wbs.index', compact('wbsReports'));
    }

    public function create()
    {
        return view('user.wbs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'is_anonim' => 'required|boolean',
            'nama_pengadu' => 'nullable|string|max:255',
            'email_pengadu' => 'nullable|email|max:255',
            'telepon_pengadu' => 'nullable|string|max:20',
            'nama_terlapor' => 'required|string|max:255',
            'wilayah' => 'required|string|max:255',
            'kategori_pelanggaran' => 'required|string|max:255',
            'waktu_kejadian' => 'required|date',
            'lokasi_kejadian' => 'required|string|max:100',
            'uraian' => 'required|string',
            'lampiran.*' => 'nullable|file|max:2048', // per lampiran max 2MB
        ]);

        // Cek apakah pengguna anonim
        if (!$validated['is_anonim']) {
            $request->validate([
                'nama_pengadu' => 'required|string|max:255',
                'email_pengadu' => 'required|email|max:255',
                'telepon_pengadu' => 'required|string|max:20',
            ]);
        } else {
            // Jika anonim, kosongkan data pengadu
            $validated['nama_pengadu'] = null;
            $validated['email_pengadu'] = null;
            $validated['telepon_pengadu'] = null;
        }

        // Handle lampiran (file upload)
        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $path = $file->store('lampiran', 'public');
                $lampiranPaths[] = $path;
            }
        }

        $wbsReport = WbsReport::create([
            'user_id' => auth()->check() ? auth()->user()->id_user : null,
            'is_anonim' => $validated['is_anonim'],
            'nama_pengadu' => $validated['nama_pengadu'],
            'email_pengadu' => $validated['email_pengadu'],
            'telepon_pengadu' => $validated['telepon_pengadu'],
            'nama_terlapor' => $validated['nama_terlapor'],
            'wilayah' => $validated['wilayah'],
            'kategori_pelanggaran' => $validated['kategori_pelanggaran'],
            'waktu_kejadian' => $validated['waktu_kejadian'],
            'lokasi_kejadian' => $validated['lokasi_kejadian'],
            'uraian' => $validated['uraian'],
            'lampiran' => $lampiranPaths,
            'status' => 'Diajukan', // dipastikan selalu 'Diajukan'
        ]);

        return redirect()->route('wbs.index')->with('success', 'Laporan WBS berhasil dikirim.');
    }
}
