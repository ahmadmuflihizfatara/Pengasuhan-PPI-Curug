<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PoinController;
use App\Http\Controllers\AcaraController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ActivityLogController; // <-- TAMBAHAN
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Dashboard — semua role boleh akses, tapi taruna lihat versi terbatas
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {

    // ===========================
    // PROFIL — semua role
    // ===========================
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===========================
    // POIN — semua role (taruna hanya baca, pengasuh/penyelenggara bisa edit)
    // ===========================
    Route::get('/poin', [PoinController::class, 'index'])->name('poin.index');

    // Tambah & hapus poin: hanya pengasuh & penyelenggara
    Route::post('/poin', [PoinController::class, 'store'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('poin.store');
    Route::delete('/poin/{id}', [PoinController::class, 'destroy'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('poin.destroy');

    // ===========================
    // ACARA — pengasuh & penyelenggara
    // ===========================
    Route::get('/acara', [AcaraController::class, 'index'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('acara.index');
    Route::get('/acara/create', [AcaraController::class, 'create'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('acara.create');
    Route::post('/acara', [AcaraController::class, 'store'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('acara.store');
    Route::get('/acara/{acara}', [AcaraController::class, 'show'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('acara.show');
    Route::get('/acara/{acara}/edit', [AcaraController::class, 'edit'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('acara.edit');
    Route::put('/acara/{acara}', [AcaraController::class, 'update'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('acara.update');
    Route::patch('/acara/{acara}', [AcaraController::class, 'update']);
    Route::delete('/acara/{acara}', [AcaraController::class, 'destroy'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('acara.destroy');

    // ===========================
    // SURAT — pengasuh & penyelenggara
    // ===========================
    Route::get('/surat', [SuratController::class, 'index'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('surat.index');
    Route::get('/surat/create', [SuratController::class, 'create'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('surat.create');
    Route::post('/surat', [SuratController::class, 'store'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('surat.store');
    Route::get('/surat/{surat}', [SuratController::class, 'show'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('surat.show');
    Route::get('/surat/{surat}/edit', [SuratController::class, 'edit'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('surat.edit');
    Route::put('/surat/{surat}', [SuratController::class, 'update'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('surat.update');
    Route::patch('/surat/{surat}', [SuratController::class, 'update']);
    Route::delete('/surat/{surat}', [SuratController::class, 'destroy'])
        ->middleware('role:pengasuh,penyelenggara')
        ->name('surat.destroy');

    // ===========================
    // DATABASE MAHASISWA — hanya penyelenggara
    // ===========================
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])
        ->middleware('role:penyelenggara')
        ->name('mahasiswa.index');
    Route::get('/mahasiswa/{npm}/edit', [MahasiswaController::class, 'edit'])
        ->middleware('role:penyelenggara')
        ->name('mahasiswa.edit');

    // ===========================
    // SETTING SISTEM — hanya penyelenggara
    // ===========================
    Route::get('/setting', [SettingController::class, 'index'])
        ->middleware('role:penyelenggara')
        ->name('setting.index');
    Route::post('/setting', [SettingController::class, 'update'])
        ->middleware('role:penyelenggara')
        ->name('setting.update');

    // ===========================
    // MANAJEMEN AKUN TARUNA — hanya penyelenggara
    // ===========================
    Route::get('/users', [\App\Http\Controllers\UserManagementController::class, 'index'])
        ->middleware('role:penyelenggara')
        ->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\UserManagementController::class, 'create'])
        ->middleware('role:penyelenggara')
        ->name('users.create');
    Route::post('/users', [\App\Http\Controllers\UserManagementController::class, 'store'])
        ->middleware('role:penyelenggara')
        ->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\UserManagementController::class, 'edit'])
        ->middleware('role:penyelenggara')
        ->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\UserManagementController::class, 'update'])
        ->middleware('role:penyelenggara')
        ->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\UserManagementController::class, 'destroy'])
        ->middleware('role:penyelenggara')
        ->name('users.destroy');

    // ===========================
    // LOG AKTIVITAS — hanya penyelenggara       ← TAMBAHAN
    // ===========================
    Route::get('/activity-log', [ActivityLogController::class, 'index'])
        ->middleware('role:penyelenggara')
        ->name('activity-log.index');
});

require __DIR__.'/auth.php';
