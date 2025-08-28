<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WbsReport;
use App\Models\KategoriUmum;
use App\Models\WilayahUmum;
use Illuminate\Support\Str;
use Carbon\Carbon;

class WbsController extends Controller
{
    /**
     * Tampilkan daftar laporan WBS.
     */
    public function index()
    {
        $user = auth()->user();
        $wbsReports = collect(); // default kosong

        if ($user) {
            if ($user->role === 'admin') {
                $kategoriIds = $user->kategori->pluck('id')->toArray();
                $wbsReports = WbsReport::with(['pelapor', 'wilayah', 'kategori'])
                    ->whereIn('kategori_id', $kategoriIds)
                    ->latest()
                    ->get();
            } elseif ($user->role === 'superadmin') {
                $wbsReports = WbsReport::with(['pelapor', 'wilayah', 'kategori'])
                    ->latest()
                    ->get();
            } else {
                $wbsReports = WbsReport::with(['pelapor', 'wilayah', 'kategori'])
                    ->where('user_id', $user->id_user)
                    ->latest()
                    ->get();
            }
        }

        // ambil kategori & wilayah umum untuk form
        $kategoriUmum = KategoriUmum::all();
        $wilayahUmum  = WilayahUmum::all();

        return view('portal.wbs.index', compact('wbsReports', 'user', 'kategoriUmum', 'wilayahUmum'));
    }

    /**
     * Simpan laporan baru.
     */
    public function store(Request $request)
    {
        // validasi awal
        $validated = $request->validate([
            'is_anonim'       => 'nullable|boolean',
            'nama_pengadu'    => 'nullable|string|max:255',
            'email_pengadu'   => 'nullable|email|max:255',
            'telepon_pengadu' => 'nullable|string|max:20',
            'nama_terlapor'   => 'required|string|max:255',
            'wilayah_id'      => 'required|exists:wilayah_umum,id',
            'kategori_id'     => 'required|exists:kategori_umum,id',
            'tanggal_kejadian'=> 'required|date',
            'waktu_kejadian'  => 'required|date_format:H:i',
            'lokasi_kejadian' => 'required|string|max:100',
            'uraian'          => 'required|string',
            'lampiran'        => 'nullable|array|max:3',
            'lampiran.*'      => 'nullable|file|max:10240', // max 10MB/file
        ]);

        // pastikan boolean aman
        $isAnonim = $request->boolean('is_anonim');

        // kalau tidak anonim → wajib isi data pengadu
        if (!$isAnonim) {
            $request->validate([
                'nama_pengadu'    => 'required|string|max:255',
                'email_pengadu'   => 'required|email|max:255',
                'telepon_pengadu' => 'required|string|max:20',
            ]);
        } else {
            // kosongkan field pengadu
            $validated['nama_pengadu'] = null;
            $validated['email_pengadu'] = null;
            $validated['telepon_pengadu'] = null;
        }

        // gabungkan tanggal + waktu
        $waktuKejadian = Carbon::parse(
            $validated['tanggal_kejadian'].' '.$validated['waktu_kejadian']
        );

        // handle lampiran
        $lampiranPaths = [];
        if ($request->hasFile('lampiran')) {
            $totalSize = collect($request->file('lampiran'))->sum->getSize();

            if ($totalSize > 30 * 1024 * 1024) { // > 30 MB
                return back()
                    ->withErrors(['lampiran' => 'Total ukuran semua lampiran tidak boleh lebih dari 30 MB.'])
                    ->withInput();
            }

            foreach ($request->file('lampiran') as $file) {
                $lampiranPaths[] = $file->store('lampiran', 'public');
            }
        }

        // simpan ke DB
        WbsReport::create([
            'tracking_id'     => 'WBS-'.Str::upper(Str::uuid()),
            'user_id'         => auth()->check() ? auth()->user()->id_user : null,
            'is_anonim'       => $isAnonim,
            'nama_pengadu'    => $validated['nama_pengadu'],
            'email_pengadu'   => $validated['email_pengadu'],
            'telepon_pengadu' => $validated['telepon_pengadu'],
            'nama_terlapor'   => $validated['nama_terlapor'],
            'wilayah_id'      => $validated['wilayah_id'],
            'kategori_id'     => $validated['kategori_id'],
            'waktu_kejadian'  => $waktuKejadian,
            'lokasi_kejadian' => $validated['lokasi_kejadian'],
            'uraian'          => $validated['uraian'],
            'lampiran'        => $lampiranPaths,
            'status'          => 'Diajukan',
        ]);

        return redirect()
            ->route('wbs.index')
            ->with('success', 'Laporan WBS berhasil dikirim.');
    }

    /**
     * Pantau laporan berdasarkan tracking_id.
     */
    public function track(Request $request)
    {
        $trackingId = $request->get('tracking_id');

        $report = WbsReport::where('tracking_id', $trackingId)->first();

        if (!$report) {
            return redirect()
                ->route('wbs.index', ['tab' => 'riwayat'])
                ->with('error', 'Kode unik tidak ditemukan.');
        }

        return view('portal.wbs.track', compact('report'));
    }
}
