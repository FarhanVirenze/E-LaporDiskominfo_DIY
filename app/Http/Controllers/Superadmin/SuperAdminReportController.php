<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Report;

class SuperAdminReportController extends Controller
{
    // Menampilkan semua laporan umum
    public function index()
    {
        $reports = Report::latest()->get();
        return view('superadmin.reports.index', compact('reports'));
    }

    // Menampilkan detail laporan tertentu
    public function show($id)
    {
        $report = Report::findOrFail($id);
        return view('superadmin.reports.show', compact('report'));
    }

    // Form edit status
    public function editStatus($id)
    {
        $report = Report::findOrFail($id);
        $statuses = Report::getStatuses();
        return view('superadmin.reports.edit_status', compact('report', 'statuses'));
    }

    // Simpan perubahan status
    public function updateStatus(Request $request, $id)
    {
        $report = Report::findOrFail($id);

        $request->validate([
            'status' => 'required|in:' . implode(',', Report::getStatuses())
        ]);

        $report->update(['status' => $request->status]);

        return redirect()->route('superadmin.reports.index')->with('success', 'Status laporan berhasil diperbarui.');
    }

    // Hapus laporan
    public function destroy($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return redirect()->route('superadmin.reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
