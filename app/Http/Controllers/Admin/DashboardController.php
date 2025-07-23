<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Data yang sudah ada
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();
        $anonimCount = Report::where('is_anonim', true)->count();
        $reportCount = Report::count();
        $pendingCount = Report::where('status', 'Diajukan')->count();
        $inProgressCount = Report::where('status', 'Diproses')->count();
        $completedCount = Report::where('status', 'Selesai')->count();
        $umumCount = Report::whereHas('kategori', function ($query) {
            $query->where('nama', 'Umum');
        })->count();

        return view('admin.dashboard', compact(
            'adminCount',
            'userCount',
            'anonimCount',
            'reportCount',
            'pendingCount',
            'inProgressCount',
            'completedCount',
            'umumCount'
        ));
    }
}