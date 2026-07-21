<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// ============ CONTROLLER ADMIN ============
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\SemesterController;
use App\Http\Controllers\Admin\PertanyaanController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\BackupController;

// ============ CONTROLLER MAHASISWA ============
use App\Http\Controllers\Mahasiswa\DashboardController as MahasiswaDashboardController;
use App\Http\Controllers\Mahasiswa\DaftarDosenController;
use App\Http\Controllers\Mahasiswa\VotingController;
use App\Http\Controllers\Mahasiswa\RiwayatController;
use App\Http\Controllers\Mahasiswa\HasilController;
use App\Http\Controllers\Mahasiswa\RankingController;

// ============ CONTROLLER PIMPINAN ============
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboardController;
use App\Http\Controllers\Pimpinan\GrafikController;
use App\Http\Controllers\Pimpinan\RankingController as PimpinanRankingController;
use App\Http\Controllers\Pimpinan\LaporanController as PimpinanLaporanController;
use App\Http\Controllers\Pimpinan\ExportController;

// ============ AUTH ============
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/', function () {
    return view('auth.login');
});

// ============ ADMIN ROUTES ============
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Master Data Dosen
    Route::resource('dosen', DosenController::class);
    Route::get('/dosen/{id}/detail', [DosenController::class, 'show'])->name('dosen.show');
    Route::post('/dosen/import', [DosenController::class, 'import'])->name('dosen.import');
    Route::get('/dosen/export', [DosenController::class, 'export'])->name('dosen.export');

    // Master Data Mahasiswa
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::get('/mahasiswa/{id}/detail', [MahasiswaController::class, 'show'])->name('mahasiswa.show');
    Route::post('/mahasiswa/import', [MahasiswaController::class, 'import'])->name('mahasiswa.import');
    Route::get('/mahasiswa/export', [MahasiswaController::class, 'export'])->name('mahasiswa.export');
    Route::post('/mahasiswa/{id}/reset-voting', [MahasiswaController::class, 'resetVoting'])->name('mahasiswa.reset-voting');

    // Master Data Mata Kuliah
    Route::resource('matakuliah', MataKuliahController::class);
    Route::get('/matakuliah/{id}/detail', [MataKuliahController::class, 'show'])->name('matakuliah.show');
    Route::post('/matakuliah/import', [MataKuliahController::class, 'import'])->name('matakuliah.import');

    // Master Data Semester
    Route::resource('semester', SemesterController::class);
    Route::post('/semester/{id}/set-aktif', [SemesterController::class, 'setAktif'])->name('semester.set-aktif');

    // Master Data Pertanyaan
    Route::resource('pertanyaan', PertanyaanController::class);
    Route::post('/pertanyaan/{id}/toggle-status', [PertanyaanController::class, 'toggleStatus'])->name('pertanyaan.toggle-status');
    Route::post('/pertanyaan/reorder', [PertanyaanController::class, 'reorder'])->name('pertanyaan.reorder');

    // Laporan
    Route::get('/laporan/dosen', [LaporanController::class, 'dosen'])->name('laporan.dosen');
    Route::get('/laporan/matakuliah', [LaporanController::class, 'matakuliah'])->name('laporan.matakuliah');
    Route::get('/laporan/prodi', [LaporanController::class, 'prodi'])->name('laporan.prodi');
    Route::get('/laporan/export-pdf', [LaporanController::class, 'exportPdf'])->name('laporan.export-pdf');
    Route::get('/laporan/export-excel', [LaporanController::class, 'exportExcel'])->name('laporan.export-excel');


    // Grafik & Ranking
    Route::get('/grafik', [LaporanController::class, 'grafik'])->name('grafik');
    Route::get('/ranking', [LaporanController::class, 'ranking'])->name('ranking');

    // Activity Log
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log');
    Route::get('/activity-log/export', [ActivityLogController::class, 'export'])->name('activity-log.export');
    Route::delete('/activity-log/clear', [ActivityLogController::class, 'clear'])->name('activity-log.clear');

    // Backup
    Route::get('/backup', [BackupController::class, 'index'])->name('backup');
    Route::post('/backup/create', [BackupController::class, 'create'])->name('backup.create');
    Route::get('/backup/download/{filename}', [BackupController::class, 'download'])->name('backup.download');
    Route::delete('/backup/delete/{filename}', [BackupController::class, 'delete'])->name('backup.delete');
    Route::post('/backup/restore', [BackupController::class, 'restore'])->name('backup.restore');
});

// ============ MAHASISWA ROUTES ============
Route::middleware(['auth', 'role:mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [MahasiswaDashboardController::class, 'index'])->name('dashboard');

    // Daftar Dosen
    Route::get('/daftar-dosen', [DaftarDosenController::class, 'index'])->name('daftar-dosen');
    Route::get('/daftar-dosen/{id}', [DaftarDosenController::class, 'show'])->name('daftar-dosen.show');

    // Voting
    Route::get('/voting', [VotingController::class, 'index'])->name('voting');
    Route::get('/voting/{dosenId}', [VotingController::class, 'create'])->name('voting.create');
    Route::post('/voting', [VotingController::class, 'store'])->name('voting.store');
    Route::get('/voting/{id}/hasil', [VotingController::class, 'hasil'])->name('voting.hasil');

    // Riwayat
    Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat');
    Route::get('/riwayat/{id}', [RiwayatController::class, 'show'])->name('riwayat.show');

    // Hasil Penilaian
    Route::get('/hasil', [HasilController::class, 'index'])->name('hasil');
    Route::get('/hasil/{id}', [HasilController::class, 'show'])->name('hasil.show');

    // Ranking
    Route::get('/ranking', [RankingController::class, 'index'])->name('ranking');
    Route::get('/ranking/export-pdf', [RankingController::class, 'exportPdf'])->name('ranking.export-pdf');
});

// ============ PIMPINAN ROUTES ============
Route::middleware(['auth', 'role:pimpinan'])->prefix('pimpinan')->name('pimpinan.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PimpinanDashboardController::class, 'index'])->name('dashboard');

    // Grafik & Chart
    Route::get('/grafik', [GrafikController::class, 'index'])->name('grafik');
    Route::get('/grafik/data', [GrafikController::class, 'data'])->name('grafik.data');

    // Ranking
    Route::get('/ranking', [PimpinanRankingController::class, 'index'])->name('ranking');
    Route::get('/ranking/export-pdf', [PimpinanRankingController::class, 'exportPdf'])->name('ranking.export-pdf');
    Route::get('/ranking/export-excel', [PimpinanRankingController::class, 'exportExcel'])->name('ranking.export-excel');

    // Laporan
    Route::get('/laporan', [PimpinanLaporanController::class, 'index'])->name('laporan');
    Route::get('/laporan/dosen', [PimpinanLaporanController::class, 'dosen'])->name('laporan.dosen');
    Route::get('/laporan/matakuliah', [PimpinanLaporanController::class, 'matakuliah'])->name('laporan.matakuliah');
    Route::get('/laporan/prodi', [PimpinanLaporanController::class, 'prodi'])->name('laporan.prodi');

    // Export
    Route::get('/export/pdf', [ExportController::class, 'pdf'])->name('export.pdf');
    Route::get('/export/excel', [ExportController::class, 'excel'])->name('export.excel');
});

// ============ PROFILE (semua role) ============
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
