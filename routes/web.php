<?php

use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\WbsController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Superadmin\SuperAdminReportController;
use App\Http\Controllers\Superadmin\SuperAdminWbsController;
use App\Http\Controllers\Superadmin\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('portal.welcome', [
        'page_title' => 'Beranda | E-Lapor DIY'
    ]);
})->name('beranda');

Route::get('/daftar-aduan', function () {
    return view('portal.daftar-aduan.index', [
        'page_title' => 'Daftar Aduan | E-Lapor DIY'
    ]);
})->name('daftar-aduan');

Route::get('/wbs', function () {
    return view('portal.wbs');
})->name('wbs.index');

Route::get('/tentang', function () {
    return view('portal.tentang.index');
})->name('tentang');

Route::get('/daftar-aduan/{id}/detail', [ReportController::class, 'show'])->name('reports.show');
Route::post('/daftar-aduan/{id}/follow-up', [ReportController::class, 'storeFollowUp'])->name('reports.followup');
Route::post('/daftar-aduan/{id}/comment', [ReportController::class, 'storeComment'])->name('reports.comment');
Route::get('/reports/{id}/badges', [ReportController::class, 'getBadgeCounts'])->name('reports.badges');
Route::delete('/daftar-aduan/komentar/{id}', [ReportController::class, 'deleteComment'])->name('reports.comment.delete');
Route::delete('reports/{reportId}/followup/{id}', [ReportController::class, 'deleteFollowUp'])->name('reports.followup.delete');
Route::post('/report/{id}/like', [ReportController::class, 'like'])->name('report.like');
Route::post('/report/{id}/dislike', [ReportController::class, 'dislike'])->name('report.dislike');

// User Routes
Route::middleware(['auth', '\App\Http\Middleware\RoleMiddleware:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('password', [ProfileController::class, 'updatePassword'])->name('password.update');

    // Report and WBS Routes without repeating the 'user/' prefix
    Route::resource('aduan', ReportController::class);
    Route::resource('wbs', WbsController::class);
});

Route::middleware(['auth', '\App\Http\Middleware\RoleMiddleware:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kelola User
    Route::resource('kelola-user', \App\Http\Controllers\Admin\UserController::class)->except(['create', 'store', 'show']);

    // Kelola Aduan
    Route::resource('kelola-aduan', \App\Http\Controllers\Admin\AduanController::class);

    // Kelola Kategori
    Route::resource('kelola-kategori', \App\Http\Controllers\Admin\KategoriUmumController::class);

    // Kelola Wilayah
    Route::resource('kelola-wilayah', \App\Http\Controllers\Admin\WilayahUmumController::class);

});

/// Superadmin Routes
Route::middleware(['auth', 'role:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::resource('laporan-umum', SuperAdminReportController::class);
    Route::resource('laporan-wbs', SuperAdminWbsController::class);
    Route::resource('users', UserManagementController::class);
    Route::resource('kategori', \App\Http\Controllers\Superadmin\KategoriController::class)->except(['show']);
    Route::resource('wilayah', \App\Http\Controllers\Superadmin\WilayahController::class)->except(['show']);
});

require __DIR__ . '/auth.php';
