<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PoinController;
use App\Http\Controllers\AcaraController;
use App\Http\Controllers\ApelController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\DutyTarunaController;
use App\Http\Controllers\AksesController;
use App\Http\Controllers\KonsinyirController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ActivityLogController; // <-- TAMBAHAN
use App\Http\Controllers\BeritaController;
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
    // POIN — semua role (taruna hanya baca, pengasuh/admin bisa edit)
    // ===========================
    Route::get('/poin', [PoinController::class, 'index'])->name('poin.index');
    Route::get('/api/my-points', [PoinController::class, 'myPointsApi'])->name('api.myPoints');

    // ===========================
    // PENGAJUAN SURAT — khusus taruna
    // ===========================
    Route::get('/surat-taruna', [\App\Http\Controllers\SuratTarunaController::class, 'index'])
        ->middleware('role:taruna')
        ->name('surat-taruna.index');
    Route::get('/surat-taruna/create', [\App\Http\Controllers\SuratTarunaController::class, 'create'])
        ->middleware('role:taruna')
        ->name('surat-taruna.create');
    Route::post('/surat-taruna', [\App\Http\Controllers\SuratTarunaController::class, 'store'])
        ->middleware('role:taruna')
        ->name('surat-taruna.store');
    Route::get('/surat-taruna/{surat}', [\App\Http\Controllers\SuratTarunaController::class, 'show'])
        ->middleware('role:taruna')
        ->name('surat-taruna.show');
    Route::get('/api/my-surat-notifications', [\App\Http\Controllers\SuratTarunaController::class, 'notifications'])
        ->middleware('role:taruna')
        ->name('api.suratNotifications');

    // Tambah & hapus poin: hanya pengasuh & admin
    Route::post('/poin', [PoinController::class, 'store'])
        ->middleware('role:pengasuh,admin')
        ->name('poin.store');
    Route::delete('/poin/{id}', [PoinController::class, 'destroy'])
        ->middleware('role:pengasuh,admin')
        ->name('poin.destroy');

    // ===========================
    // ACARA — daftar acara (semua pengguna terautentikasi dapat melihat kalender)
    // Pengasuh & admin masih butuh role untuk CRUD route lainnya
    // ===========================
    Route::get('/acara', [AcaraController::class, 'index'])
        ->middleware('auth')
        ->name('acara.index');
    Route::get('/acara/create', [AcaraController::class, 'create'])
        ->middleware('role:pengasuh,admin')
        ->name('acara.create');
    Route::post('/acara', [AcaraController::class, 'store'])
        ->middleware('role:pengasuh,admin')
        ->name('acara.store');
    Route::get('/acara/{acara}', [AcaraController::class, 'show'])
        ->middleware('role:pengasuh,admin')
        ->name('acara.show');
    Route::get('/acara/{acara}/edit', [AcaraController::class, 'edit'])
        ->middleware('role:pengasuh,admin')
        ->name('acara.edit');
    Route::put('/acara/{acara}', [AcaraController::class, 'update'])
        ->middleware('role:pengasuh,admin')
        ->name('acara.update');
    Route::patch('/acara/{acara}', [AcaraController::class, 'update']);
    Route::delete('/acara/{acara}', [AcaraController::class, 'destroy'])
        ->middleware('role:pengasuh,admin')
        ->name('acara.destroy');

    // ===========================
    // APEL — hanya pengasuh
    // ===========================
    Route::middleware('role:pengasuh')->group(function () {
        Route::get('/apel', [ApelController::class, 'index'])->name('apel.index');
        Route::get('/apel/create', [ApelController::class, 'create'])->name('apel.create');
        Route::post('/apel', [ApelController::class, 'store'])->name('apel.store');
        Route::get('/apel/{apel}/edit', [ApelController::class, 'edit'])->name('apel.edit');
        Route::put('/apel/{apel}', [ApelController::class, 'update'])->name('apel.update');
        Route::delete('/apel/{apel}', [ApelController::class, 'destroy'])->name('apel.destroy');
    });

    // Jadwal apel — taruna, hanya lihat (tanpa informasi apel)
    Route::get('/jadwal-apel', [ApelController::class, 'jadwalTaruna'])
        ->middleware('role:taruna')
        ->name('apel.jadwal');

    // ===========================
    // JADWAL — pengasuh: jadwal pengasuh + duty taruna
    // ===========================
    Route::middleware('role:pengasuh')->group(function () {
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::post('/jadwal/generate', [JadwalController::class, 'generate'])->name('jadwal.generate');
        Route::post('/jadwal/set', [JadwalController::class, 'set'])->name('jadwal.set');

        Route::get('/jadwal/duty', [DutyTarunaController::class, 'index'])->name('duty.index');
        Route::post('/jadwal/duty', [DutyTarunaController::class, 'store'])->name('duty.store');
    });

    // Jadwal untuk taruna — hanya lihat (pengasuh hari ini + duty minggu ini)
    Route::get('/jadwal-saya', [JadwalController::class, 'taruna'])
        ->middleware('role:taruna')
        ->name('jadwal.taruna');

    // ===========================
    // KONSINYIR — hanya pengasuh
    // ===========================
    Route::middleware('role:pengasuh')->group(function () {
        Route::get('/konsinyir', [KonsinyirController::class, 'index'])->name('konsinyir.index');
        Route::post('/konsinyir', [KonsinyirController::class, 'store'])->name('konsinyir.store');
        Route::delete('/konsinyir/{konsinyir}', [KonsinyirController::class, 'destroy'])->name('konsinyir.destroy');
    });

    // ===========================
    // AKSES FITUR — hanya admin
    // ===========================
    Route::middleware('role:admin')->group(function () {
        Route::get('/akses', [AksesController::class, 'index'])->name('akses.index');
        Route::post('/akses', [AksesController::class, 'update'])->name('akses.update');
    });

    // ===========================
    // SURAT — pengasuh & admin
    // ===========================
    Route::get('/surat', [SuratController::class, 'index'])
        ->middleware('role:pengasuh,admin')
        ->name('surat.index');
    Route::get('/surat/create', [SuratController::class, 'create'])
        ->middleware('role:pengasuh,admin')
        ->name('surat.create');
    Route::post('/surat', [SuratController::class, 'store'])
        ->middleware('role:pengasuh,admin')
        ->name('surat.store');
    Route::get('/surat/{surat}', [SuratController::class, 'show'])
        ->middleware('role:pengasuh,admin')
        ->name('surat.show');
    Route::get('/surat/{surat}/edit', [SuratController::class, 'edit'])
        ->middleware('role:pengasuh,admin')
        ->name('surat.edit');
    Route::put('/surat/{surat}', [SuratController::class, 'update'])
        ->middleware('role:pengasuh,admin')
        ->name('surat.update');
    Route::patch('/surat/{surat}', [SuratController::class, 'update']);
    Route::delete('/surat/{surat}', [SuratController::class, 'destroy'])
        ->middleware('role:pengasuh,admin')
        ->name('surat.destroy');
    Route::patch('/surat/{surat}/status', [SuratController::class, 'updateStatus'])
        ->middleware('role:pengasuh,admin')
        ->name('surat.updateStatus');

    // ===========================
    // DATABASE MAHASISWA — hanya admin
    // ===========================
    Route::get('/mahasiswa', [MahasiswaController::class, 'index'])
        ->middleware('role:admin')
        ->name('mahasiswa.index');
    Route::get('/mahasiswa/{mahasiswa}/edit', [MahasiswaController::class, 'edit'])
        ->middleware('role:admin')
        ->name('mahasiswa.edit');
    Route::patch('/mahasiswa/{mahasiswa}', [MahasiswaController::class, 'update'])
        ->middleware('role:admin')
        ->name('mahasiswa.update');

    // ===========================
    // SETTING SISTEM — hanya admin
    // ===========================
    Route::get('/setting', [SettingController::class, 'index'])
        ->middleware('role:admin')
        ->name('setting.index');
    Route::post('/setting', [SettingController::class, 'update'])
        ->middleware('role:admin')
        ->name('setting.update');

    // ===========================
    // MANAJEMEN AKUN TARUNA — hanya admin
    // ===========================
    Route::get('/users', [\App\Http\Controllers\UserManagementController::class, 'index'])
        ->middleware('role:admin')
        ->name('users.index');
    Route::get('/users/create', [\App\Http\Controllers\UserManagementController::class, 'create'])
        ->middleware('role:admin')
        ->name('users.create');
    Route::post('/users', [\App\Http\Controllers\UserManagementController::class, 'store'])
        ->middleware('role:admin')
        ->name('users.store');
    Route::get('/users/{user}/edit', [\App\Http\Controllers\UserManagementController::class, 'edit'])
        ->middleware('role:admin')
        ->name('users.edit');
    Route::put('/users/{user}', [\App\Http\Controllers\UserManagementController::class, 'update'])
        ->middleware('role:admin')
        ->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\UserManagementController::class, 'destroy'])
        ->middleware('role:admin')
        ->name('users.destroy');

    // ===========================
    // LOG AKTIVITAS — hanya admin       
    // ===========================
    Route::get('/activity-log', [ActivityLogController::class, 'index'])
        ->middleware('role:admin')
        ->name('activity-log.index');
    // ===========================
    // BERITA       
    // ===========================
    Route::resource('berita', BeritaController::class);
    Route::patch('/berita/{beritum}/pin', [BeritaController::class, 'togglePin'])
    ->name('berita.toggle-pin');

    // ===========================
    // LOG PERGERAKAN TARUNA (TABLET & TV MONITORING)
    // ===========================
    Route::get('/log-pergerakan', [\App\Http\Controllers\LogPergerakanController::class, 'index'])->name('log-pergerakan.index');
    Route::get('/log-pergerakan/tablet', [\App\Http\Controllers\LogPergerakanController::class, 'tablet'])->name('log-pergerakan.tablet');
    Route::post('/log-pergerakan', [\App\Http\Controllers\LogPergerakanController::class, 'store'])->name('log-pergerakan.store');
    Route::patch('/log-pergerakan/{id}/kembali', [\App\Http\Controllers\LogPergerakanController::class, 'updateKembali'])->name('log-pergerakan.kembali');
    Route::get('/log-pergerakan/tv-monitoring', [\App\Http\Controllers\LogPergerakanController::class, 'tvMonitoring'])->name('log-pergerakan.tv');
    Route::get('/log-pergerakan/api-data', [\App\Http\Controllers\LogPergerakanController::class, 'apiData'])->name('log-pergerakan.api');
    Route::get('/log-pergerakan/{id}', [\App\Http\Controllers\LogPergerakanController::class, 'show'])->name('log-pergerakan.show');
    Route::delete('/log-pergerakan/{id}', [\App\Http\Controllers\LogPergerakanController::class, 'destroy'])
        ->middleware('role:pengasuh,admin')
        ->name('log-pergerakan.destroy');
});

require __DIR__.'/auth.php';
