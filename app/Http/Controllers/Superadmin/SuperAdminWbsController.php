<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WbsReport;

class SuperAdminWbsController extends Controller
{
    public function index() {
        $wbsReports = WbsReport::all();
        return view('superadmin.wbs.index', compact('wbsReports'));
    }

    public function show($id) {
        $wbs = WbsReport::findOrFail($id);
        return view('superadmin.wbs.show', compact('wbs'));
    }

    public function updateStatus(Request $request, $id) {
        $wbs = WbsReport::findOrFail($id);
        $wbs->status = $request->input('status');
        $wbs->save();

        return redirect()->back()->with('success', 'Status laporan WBS diperbarui.');
    }
}
