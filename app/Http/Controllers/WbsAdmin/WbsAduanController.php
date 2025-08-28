<?php

namespace App\Http\Controllers\WbsAdmin;

use App\Http\Controllers\Controller;
use App\Models\WbsReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WbsAduanController extends Controller
{
    // Menampilkan semua laporan (WBS Aduan)
    public function index(Request $request)
    {
        $wbsAdmin = Auth::user(); // WBS Admin login

        // Query report hanya untuk kategori yg ditangani wbs admin ini
        $query = WbsReport::whereHas('kategori', function ($q) use ($wbsAdmin) {
            $q->where('admin_id', $wbsAdmin->id_user);
        });

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Pagination
        $reports = $query->orderByDesc('created_at')
            ->paginate(5)
            ->appends($request->query());

        return view('wbs_admin.aduan.index', compact('reports'));
    }

    // Update status laporan
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', WbsReport::getStatuses()),
        ]);

        $report = WbsReport::findOrFail($id);

        // Validasi akses kategori
        $wbsAdminKategoriIds = Auth::user()->kategori()->pluck('id');
        if (!$wbsAdminKategoriIds->contains($report->kategori_id)) {
            abort(403, 'Anda tidak memiliki akses untuk memperbarui laporan ini.');
        }

        $report->status = $validated['status'];
        $report->save();

        return redirect()->route('wbs_admin.kelola-aduan.index')
            ->with('success', 'Status laporan berhasil diperbarui.');
    }

    // Hapus laporan
    public function destroy($id)
    {
        $report = WbsReport::findOrFail($id);

        $wbsAdminKategoriIds = Auth::user()->kategori()->pluck('id');
        if (!$wbsAdminKategoriIds->contains($report->kategori_id)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus laporan ini.');
        }

        $report->delete();

        return redirect()->route('wbs_admin.kelola-aduan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
