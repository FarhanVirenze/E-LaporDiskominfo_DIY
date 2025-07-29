<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    // Menampilkan semua laporan (aduan) yang ada
    public function index()
    {
        // Ambil semua laporan (aduan) yang telah terdaftar
        $reports = Report::paginate(5);

        // Tampilkan ke halaman view 'admin.aduan.index'
        return view('superadmin.aduan.index', compact('reports'));
    }

    // Mengupdate status laporan
    public function update(Request $request, $id)
    {
        // Validasi dan logika untuk memperbarui status laporan
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', Report::getStatuses()), // Validasi status yang valid
        ]);

        // Cari laporan berdasarkan ID
        $report = Report::findOrFail($id);
        $report->status = $validated['status']; // Update status
        $report->save(); // Simpan perubahan

        return redirect()->route('superadmin.kelola-aduan.index')
                         ->with('success', 'Status laporan berhasil diperbarui.');
    }

    // Menghapus laporan
    public function destroy($id)
    {
        // Cari laporan berdasarkan ID
        $report = Report::findOrFail($id);

        // Hapus laporan
        $report->delete();

        return redirect()->route('superadmin.kelola-aduan.index')
                         ->with('success', 'Laporan berhasil dihapus.');
    }
}
