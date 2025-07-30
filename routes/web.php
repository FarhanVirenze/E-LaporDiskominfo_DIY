<?php

use App\Http\Controllers\User\ReportController;
use App\Http\Controllers\Admin\ReportAdminController;
use App\Http\Controllers\Superadmin\ReportSuperadminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Superadmin\DashboardSuperadminController;
use App\Http\Controllers\User\WbsController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\ProfileAdminController;
use App\Http\Controllers\Superadmin\ProfileSuperadminController;
use App\Http\Controllers\Superadmin\KategoriAdminController;
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

Route::post('/lacak', [ReportController::class, 'lacak'])->name('report.lacak');
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

    Route::get('/riwayat-aduan', [ReportController::class, 'riwayat'])->name('aduan.riwayat');
    Route::get('/riwayat-aduan-wbs', [ReportController::class, 'riwayatWbs'])->name('aduan.riwayatWbs');

    // Report and WBS Routes without repeating the 'user/' prefix
    Route::resource('aduan', ReportController::class);
    Route::resource('wbs', WbsController::class);
});

Route::middleware(['auth', '\App\Http\Middleware\RoleMiddleware:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::post('/lacak', [ReportAdminController::class, 'lacak'])->name('report.lacak');
    Route::get('/daftar-aduan/{id}/detail', [ReportAdminController::class, 'show'])->name('reports.show');
    Route::post('/daftar-aduan/{id}/follow-up', [ReportAdminController::class, 'storeFollowUp'])->name('reports.followup');
    Route::post('/daftar-aduan/{id}/comment', [ReportAdminController::class, 'storeComment'])->name('reports.comment');
    Route::get('/reports/{id}/badges', [ReportAdminController::class, 'getBadgeCounts'])->name('reports.badges');
    Route::delete('/daftar-aduan/komentar/{id}', [ReportAdminController::class, 'deleteComment'])->name('reports.comment.delete');
    Route::delete('reports/{reportId}/followup/{id}', [ReportAdminController::class, 'deleteFollowUp'])->name('reports.followup.delete');
    Route::post('/report/{id}/like', [ReportAdminController::class, 'like'])->name('report.like');
    Route::post('/report/{id}/dislike', [ReportAdminController::class, 'dislike'])->name('report.dislike');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/', function () {
        return view('admin.welcome', [
            'page_title' => 'Beranda | E-Lapor DIY Admin'
        ]);
    })->name('beranda');

    Route::get('/riwayat-aduan', [ProfileAdminController::class, 'riwayat'])->name('aduan.riwayat');
    Route::get('/riwayat-aduan-wbs', [profileadminController::class, 'riwayatWbs'])->name('aduan.riwayatWbs');

    Route::resource('aduan', ReportAdminController::class);

    Route::get('profile', [ProfileAdminController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileAdminController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileAdminController::class, 'destroy'])->name('profile.destroy');
    Route::put('password', [ProfileAdminController::class, 'updatePassword'])->name('password.update');
    // Kelola Aduan
    Route::resource('kelola-aduan', \App\Http\Controllers\Admin\AduanController::class);

});

/// Superadmin Routes
Route::middleware(['auth', '\App\Http\Middleware\RoleMiddleware:superadmin'])->prefix('superadmin')->name('superadmin.')->group(function () {

    Route::post('/lacak', [ReportSuperadminController::class, 'lacak'])->name('report.lacak');
    Route::get('/daftar-aduan/{id}/detail', [ReportSuperadminController::class, 'show'])->name('reports.show');
    Route::post('/daftar-aduan/{id}/follow-up', [ReportSuperadminController::class, 'storeFollowUp'])->name('reports.followup');
    Route::post('/daftar-aduan/{id}/comment', [ReportSuperadminController::class, 'storeComment'])->name('reports.comment');
    Route::get('/reports/{id}/badges', [ReportSuperadminController::class, 'getBadgeCounts'])->name('reports.badges');
    Route::delete('/daftar-aduan/komentar/{id}', [ReportSuperadminController::class, 'deleteComment'])->name('reports.comment.delete');
    Route::delete('reports/{reportId}/followup/{id}', [ReportSuperadminController::class, 'deleteFollowUp'])->name('reports.followup.delete');
    Route::post('/report/{id}/like', [ReportSuperadminController::class, 'like'])->name('report.like');
    Route::post('/report/{id}/dislike', [ReportSuperadminController::class, 'dislike'])->name('report.dislike');

    Route::get('/', function () {
        return view('superadmin.welcome', [
            'page_title' => 'Beranda | E-Lapor DIY Superadmin'
        ]);
    })->name('beranda');

    Route::get('/riwayat-aduan', [ProfileSuperadminController::class, 'riwayat'])->name('aduan.riwayat');
    Route::get('/riwayat-aduan-wbs', [profileSuperadminController::class, 'riwayatWbs'])->name('aduan.riwayatWbs');

    Route::resource('aduan', ReportSuperadminController::class);

    Route::get('dashboard', [DashboardSuperadminController::class, 'index'])->name('dashboard');

    Route::get('profile', [ProfileSuperadminController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileSuperadminController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileSuperadminController::class, 'destroy'])->name('profile.destroy');
    Route::put('password', [ProfileSuperadminController::class, 'updatePassword'])->name('password.update');

    // Kelola User
    Route::resource('kelola-user', \App\Http\Controllers\Superadmin\UserController::class)->except(['create', 'store', 'show']);

    // Kelola Aduan
    Route::resource('kelola-aduan', \App\Http\Controllers\Superadmin\AduanController::class);

    // Kelola Kategori
    Route::resource('kelola-kategori', \App\Http\Controllers\Superadmin\KategoriUmumController::class);

    // Kelola Kategori-admin
    Route::resource('kategori-admin', KategoriAdminController::class);

    // Kelola Wilayah
    Route::resource('kelola-wilayah', \App\Http\Controllers\Superadmin\WilayahUmumController::class);
});

require __DIR__ . '/auth.php';
