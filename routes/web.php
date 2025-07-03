<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\IsiRapatController;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\NotifController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\DashboardController;

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth', 'verified')->group(function () {

    Route::post('/agendas/{agenda}/approve', [AgendaController::class, 'approve'])->name('agendas.approve');
    Route::post('/agendas/{agenda}/reject', [AgendaController::class, 'reject'])->name('agendas.reject');

    Route::resource('agendas', AgendaController::class);
    Route::get('/agendas/{agenda}', [AgendaController::class, 'show'])->name('agendas.show');

    Route::resource('isi_rapats', IsiRapatController::class);
    Route::get('/isi_rapats/{isi_rapat}/edit', [IsiRapatController::class, 'edit'])->name('isi_rapats.edit');
    Route::post('/isi_rapats/{isi_rapat}/close', [IsiRapatController::class, 'close'])->name('isi_rapats.close');
    Route::post('/isi_rapats/{isi_rapat}/reopen', [IsiRapatController::class, 'reopen'])->name('isi_rapats.reopen');

    Route::resource('ruangans', RuanganController::class);

    Route::resource('notifs', NotifController::class);
    Route::get('/notifs/{notif}', [NotifController::class, 'show'])->name('notifs.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
