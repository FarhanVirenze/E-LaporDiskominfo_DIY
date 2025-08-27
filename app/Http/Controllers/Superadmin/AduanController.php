<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    // Menampilkan semua laporan (aduan) yang ada
    public function index(Request $request)
    {
        $adminId = $request->input('admin_id');
        $kategoriId = $request->input('kategori_id');
        $status = $request->input('status');

        $query = Report::with(['admin', 'kategori']);

        // 🔹 Filter Admin (langsung dari report.admin_id)
        if ($adminId) {
            $query->where('admin_id', $adminId);
        }

        // 🔹 Filter Kategori
        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        // 🔹 Filter Status
        if ($status) {
            $query->where('status', $status);
        }

        $reports = $query->paginate(10);

        // 🔹 Ambil daftar admin (untuk dropdown filter)
        $admins = \App\Models\User::where('role', 'admin')->get();

        // 🔹 Ambil kategori yang dipakai laporan (supaya dropdown kategori dinamis)
        $kategoriIds = Report::when($adminId, function ($q) use ($adminId) {
            $q->where('admin_id', $adminId);
        })
            ->select('kategori_id')
            ->distinct()
            ->pluck('kategori_id');

        $kategoris = \App\Models\KategoriUmum::whereIn('id', $kategoriIds)->get();

        return view('superadmin.aduan.index', compact(
            'reports',
            'admins',
            'kategoris',
            'adminId',
            'kategoriId',
            'status'
        ));
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
