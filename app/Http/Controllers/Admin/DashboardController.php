<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Report;

class DashboardController extends Controller
{
    public function index()
    {
        $adminCount = User::where('role', 'admin')->count();
        $userCount = User::where('role', 'user')->count();
        $totalUsers = $adminCount + $userCount;

        $pendingCount = Report::where('status', 'Diajukan')->count();
        $readCount = Report::where('status', 'Dibaca')->count();
        $respondedCount = Report::where('status', 'Direspon')->count();
        $completedCount = Report::where('status', 'Selesai')->count();
        $totalReports = $pendingCount + $readCount + $respondedCount + $completedCount;

        return view('admin.dashboard', compact(
            'adminCount',
            'userCount',
            'totalUsers',
            'pendingCount',
            'readCount',
            'respondedCount',
            'completedCount',
            'totalReports'
        ));
    }
}
