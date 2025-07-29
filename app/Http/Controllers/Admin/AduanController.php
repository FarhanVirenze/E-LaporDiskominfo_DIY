<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AduanController extends Controller
{
    // Menampilkan semua laporan (aduan) yang ada
    public function index()
    {
        $admin = Auth::user(); // Admin yang sedang login

        // Ambil ID kategori yang ditangani oleh admin ini
        $kategoriIds = $admin->kategori()->pluck('id');

        // Ambil laporan yang hanya termasuk dalam kategori tersebut
        $reports = Report::whereIn('kategori_id', $kategoriIds)->paginate(5);

        return view('admin.aduan.index', compact('reports'));
    }

    // Mengupdate status laporan
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:' . implode(',', Report::getStatuses()),
        ]);

        $report = Report::findOrFail($id);

        // Validasi: hanya admin yang menangani kategori itu yang boleh ubah
        $adminKategoriIds = Auth::user()->kategori()->pluck('id');
        if (!$adminKategoriIds->contains($report->kategori_id)) {
            abort(403, 'Anda tidak memiliki akses untuk memperbarui laporan ini.');
        }

        $report->status = $validated['status'];
        $report->save();

        return redirect()->route('admin.kelola-aduan.index')
            ->with('success', 'Status laporan berhasil diperbarui.');
    }

    // Menghapus laporan
    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        $adminKategoriIds = Auth::user()->kategori()->pluck('id');
        if (!$adminKategoriIds->contains($report->kategori_id)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus laporan ini.');
        }

        $report->delete();

        return redirect()->route('admin.kelola-aduan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }
}
