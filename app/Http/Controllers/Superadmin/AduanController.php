<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;
use App\Models\KategoriUmum;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    // Menampilkan semua laporan (aduan) yang ada
   public function index(Request $request)
    {
        $adminId = $request->input('admin_id');
        $kategoriId = $request->input('kategori_id');

        $admins = User::where('role', 'admin')->get();

        $query = Report::with('admin', 'kategori');

        if ($adminId) {
            $query->where('admin_id', $adminId);
        }

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        $reports = $query->paginate(5);

        // Ambil kategori umum yang hanya digunakan dalam laporan admin terkait
        $kategoriIds = Report::when($adminId, function ($q) use ($adminId) {
                $q->where('admin_id', $adminId);
            })
            ->select('kategori_id')
            ->distinct()
            ->pluck('kategori_id');

        $kategoris = KategoriUmum::whereIn('id', $kategoriIds)->get();

        return view('superadmin.aduan.index', compact('reports', 'admins', 'kategoris', 'adminId', 'kategoriId'));
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
