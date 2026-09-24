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
use App\Http\Controllers\AksesKhususController;
use App\Http\Controllers\KonsinyirController;
use App\Http\Controllers\LaporanDutyController;
use App\Http\Controllers\NilaiTarunaController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ActivityLogController; // <-- TAMBAHAN
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\KeluhanBarakController;
use App\Http\Controllers\KeluhanBarakStaffController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\RewardStaffController;
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

    // Tambah poin: pengasuh, admin & polisi taruna (polisi taruna dibatasi ke pelanggaran di controller)
    Route::post('/poin', [PoinController::class, 'store'])
        ->middleware('role:pengasuh,admin,polisi_taruna')
        ->name('poin.store');
    // Hapus poin: hanya pengasuh & admin

    Route::delete('/poin/{id}', [PoinController::class, 'destroy'])
        ->middleware('role:pengasuh,admin')
        ->name('poin.destroy');
    Route::patch('/poin/{id}/validasi', [PoinController::class, 'validasi'])
        ->middleware('role:admin')
        ->name('poin.validasi');

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

    // Kalkulator BMI — khusus taruna (hitung di browser, tidak disimpan)
    Route::view('/bmi', 'bmi.index')
        ->middleware('role:taruna')
        ->name('bmi.index');

    // Jadwal apel — taruna, hanya lihat (tanpa informasi apel)
    Route::get('/jadwal-apel', [ApelController::class, 'jadwalTaruna'])
        ->middleware('role:taruna')
        ->name('apel.jadwal');

    // ===========================
    // JADWAL — pengasuh: jadwal pengasuh saja
    // DUTY TARUNA — dibuat khusus Kepala Seksi Internal (pengasuh hanya lihat)
    // ===========================
    Route::middleware('role:pengasuh')->group(function () {
        Route::get('/jadwal', [JadwalController::class, 'index'])->name('jadwal.index');
        Route::post('/jadwal/generate', [JadwalController::class, 'generate'])->name('jadwal.generate');
        Route::post('/jadwal/set', [JadwalController::class, 'set'])->name('jadwal.set');
    });

    Route::get('/jadwal/duty', [DutyTarunaController::class, 'index'])
        ->middleware('role:pengasuh,kasi_internal')
        ->name('duty.index');
    Route::post('/jadwal/duty', [DutyTarunaController::class, 'store'])
        ->middleware('role:kasi_internal')
        ->name('duty.store');

    // ===========================
    // LAPORAN DUTY TARUNA — taruna duty minggu ini (akses otomatis) lapor sakit;
    // pengasuh & admin lihat laporan masuk
    // ===========================
    Route::middleware('role:pengasuh,admin,duty_taruna')->group(function () {
        Route::get('/laporan-duty', [LaporanDutyController::class, 'index'])->name('laporan-duty.index');
        Route::post('/laporan-duty', [LaporanDutyController::class, 'store'])->name('laporan-duty.store');
        Route::delete('/laporan-duty/{laporan}', [LaporanDutyController::class, 'destroy'])->name('laporan-duty.destroy');
    });

    // Jadwal untuk taruna — hanya lihat (pengasuh hari ini + duty minggu ini)
    Route::get('/jadwal-saya', [JadwalController::class, 'taruna'])
        ->middleware('role:taruna')
        ->name('jadwal.taruna');

    // ===========================
    // KONSINYIR — pengasuh kelola, taruna lihat saja (read-only)
    // ===========================
    Route::get('/konsinyir', [KonsinyirController::class, 'index'])
        ->middleware('role:pengasuh,taruna')
        ->name('konsinyir.index');
    Route::middleware('role:pengasuh')->group(function () {
        Route::post('/konsinyir', [KonsinyirController::class, 'store'])->name('konsinyir.store');
        Route::delete('/konsinyir/{konsinyir}', [KonsinyirController::class, 'destroy'])->name('konsinyir.destroy');
    });

    // ===========================
    // NILAI TARUNA — pengasuh & admin input; taruna lihat rekap di dashboard
    // ===========================
    Route::middleware('role:pengasuh,admin')->group(function () {
        Route::get('/nilai-taruna', [NilaiTarunaController::class, 'index'])->name('nilai-taruna.index');
        Route::post('/nilai-taruna', [NilaiTarunaController::class, 'store'])->name('nilai-taruna.store');
        Route::delete('/nilai-taruna/{nilai}', [NilaiTarunaController::class, 'destroy'])->name('nilai-taruna.destroy');
    });

    // ===========================
    // AKSES FITUR — hanya admin
    // ===========================
    Route::middleware('role:admin')->group(function () {
        Route::get('/akses', [AksesController::class, 'index'])->name('akses.index');
        Route::post('/akses', [AksesController::class, 'update'])->name('akses.update');

        // Pemberian akses khusus (Kasi Internal / Polisi Taruna) ke akun taruna
        Route::get('/akses-khusus', [AksesKhususController::class, 'index'])->name('akses-khusus.index');
        Route::patch('/akses-khusus/{user}', [AksesKhususController::class, 'update'])->name('akses-khusus.update');
    });

    // ===========================
    // KELUHAN BARAK TARUNA — taruna: pengajuan; pengasuh/admin: kelola
    // ===========================
    Route::middleware('role:pengasuh,admin')->group(function () {
        Route::get('/keluhan-barak/kelola', [KeluhanBarakStaffController::class, 'kelola'])
            ->name('keluhan-barak.kelola');
        Route::get('/keluhan-barak/export-pdf', [KeluhanBarakStaffController::class, 'exportPdf'])
            ->name('keluhan-barak.exportPdf');
        Route::get('/keluhan-barak/{keluhan}/detail', [KeluhanBarakStaffController::class, 'showDetail'])
            ->name('keluhan-barak.detail');
        Route::patch('/keluhan-barak/{keluhan}/status', [KeluhanBarakStaffController::class, 'updateStatus'])
            ->name('keluhan-barak.updateStatus');
    });

    Route::get('/keluhan-barak', [KeluhanBarakController::class, 'index'])
        ->middleware('role:taruna')
        ->name('keluhan-barak.index');
    Route::get('/keluhan-barak/create', [KeluhanBarakController::class, 'create'])
        ->middleware('role:taruna')
        ->name('keluhan-barak.create');
    Route::post('/keluhan-barak', [KeluhanBarakController::class, 'store'])
        ->middleware('role:taruna')
        ->name('keluhan-barak.store');
    Route::get('/keluhan-barak/{keluhan}', [KeluhanBarakController::class, 'show'])
        ->middleware('role:taruna')
        ->name('keluhan-barak.show');
    Route::get('/api/my-keluhan-notifications', [KeluhanBarakController::class, 'notifications'])
        ->middleware('role:taruna')
        ->name('api.keluhanNotifications');

    // ===========================
    // REWARD TARUNA — taruna: pengajuan; pengasuh/admin: kelola
    // ===========================
    Route::middleware('role:pengasuh,admin')->group(function () {
        Route::get('/reward/kelola', [RewardStaffController::class, 'kelola'])
            ->name('reward.kelola');
        Route::get('/reward/{reward}/detail', [RewardStaffController::class, 'showDetail'])
            ->name('reward.detail');
        Route::patch('/reward/{reward}/status', [RewardStaffController::class, 'updateStatus'])
            ->name('reward.updateStatus');
    });

    Route::get('/reward', [RewardController::class, 'index'])
        ->middleware('role:taruna')
        ->name('reward.index');
    Route::get('/reward/create', [RewardController::class, 'create'])
        ->middleware('role:taruna')
        ->name('reward.create');
    Route::post('/reward', [RewardController::class, 'store'])
        ->middleware('role:taruna')
        ->name('reward.store');
    Route::get('/reward/{reward}', [RewardController::class, 'show'])
        ->middleware('role:taruna')
        ->name('reward.show');
    Route::get('/api/my-reward-notifications', [RewardController::class, 'notifications'])
        ->middleware('role:taruna')
        ->name('api.rewardNotifications');

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
    // MONITORING TV — pengasuh & admin (layar penuh, dibuka dari dashboard)
    // ===========================
    Route::get('/monitoring-tv', [\App\Http\Controllers\MonitoringTvController::class, 'index'])
        ->middleware('role:pengasuh,admin')
        ->name('monitoring-tv.index');
    // ===========================
    // BERITA       
    // ===========================
    Route::resource('berita', BeritaController::class);
    Route::patch('/berita/{beritum}/pin', [BeritaController::class, 'togglePin'])
    ->name('berita.toggle-pin');

    // ===========================
    // LOG PERGERAKAN TARUNA (POS JAGA GERBANG)
    // Taruna: input mandiri izin keluar/pulang. Pengasuh: validator saja (tidak input).
    // ===========================
    Route::middleware('role:pengasuh,admin')->group(function () {
        Route::get('/log-pergerakan', [\App\Http\Controllers\LogPergerakanController::class, 'index'])->name('log-pergerakan.index');
    });

    // Form manual pos jaga — khusus admin (pengasuh tidak lagi input manual)
    Route::get('/log-pergerakan/tablet', [\App\Http\Controllers\LogPergerakanController::class, 'tablet'])
        ->middleware('role:admin')
        ->name('log-pergerakan.tablet');

    // Form mandiri taruna: input izin keluar & konfirmasi kembali sendiri
    Route::get('/log-pergerakan/mandiri', [\App\Http\Controllers\LogPergerakanController::class, 'mandiri'])
        ->middleware('role:taruna')
        ->name('log-pergerakan.mandiri');

    // Store & kembali: taruna (punya sendiri) atau admin (input manual di tablet)
    Route::middleware('role:taruna,admin')->group(function () {
        Route::post('/log-pergerakan', [\App\Http\Controllers\LogPergerakanController::class, 'store'])->name('log-pergerakan.store');
        Route::patch('/log-pergerakan/{id}/kembali', [\App\Http\Controllers\LogPergerakanController::class, 'updateKembali'])->name('log-pergerakan.kembali');
    });

    // Rute dengan wildcard {id} — didaftarkan paling akhir agar tidak menangkap path spesifik di atas (tablet/mandiri)
    Route::middleware('role:pengasuh,admin')->group(function () {
        Route::get('/log-pergerakan/{id}', [\App\Http\Controllers\LogPergerakanController::class, 'show'])->name('log-pergerakan.show');
        Route::patch('/log-pergerakan/{id}/validasi', [\App\Http\Controllers\LogPergerakanController::class, 'validasi'])->name('log-pergerakan.validasi');
        Route::delete('/log-pergerakan/{id}', [\App\Http\Controllers\LogPergerakanController::class, 'destroy'])
            ->name('log-pergerakan.destroy');
    });
});

require __DIR__.'/auth.php';
