<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Guru\PresensiController as GuruPresensiController;
use App\Http\Controllers\Guru\SetoranHafalanController as GuruSetoranHafalanController;
use App\Http\Controllers\Parent\DashboardController as ParentDashboardController;
use App\Http\Controllers\Parent\RaporController as ParentRaporController;
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\SuperAdmin\GuruController;
use App\Http\Controllers\SuperAdmin\LaporanController as SuperAdminLaporanController;
use App\Http\Controllers\SuperAdmin\OrangTuaController as SuperAdminOrangTuaController;
use App\Http\Controllers\SuperAdmin\SantriController as SuperAdminSantriController;
use App\Http\Controllers\SuperAdmin\SurahController as SuperAdminSurahController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// SuperAdmin Routes (Full Access Control)
Route::prefix('superadmin')
    ->middleware(['auth', 'superadmin'])
    ->name('superadmin.')
    ->group(function (): void {
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])->name('dashboard');

        // Master Data Guru
        Route::resource('guru', GuruController::class)->except(['show']);

        // Master Data Santri
        Route::resource('santri', SuperAdminSantriController::class)->except(['show']);

        // Master Data Orang Tua
        Route::resource('orang-tua', SuperAdminOrangTuaController::class)->except(['show'])->names([
            'index' => 'orang_tua.index',
            'create' => 'orang_tua.create',
            'store' => 'orang_tua.store',
            'edit' => 'orang_tua.edit',
            'update' => 'orang_tua.update',
            'destroy' => 'orang_tua.destroy',
        ]);

        // Master Referensi Al-Qur'an (Surah)
        Route::get('/surah', [SuperAdminSurahController::class, 'index'])->name('surah.index');

        // Modul Laporan & Rapor PDF
        Route::get('/laporan', [SuperAdminLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/rapor/{santri}', [SuperAdminLaporanController::class, 'cetakRapor'])->name('laporan.rapor');
    });

// Guru Routes (Limited to Presensi & Setoran Hafalan)
Route::prefix('guru')
    ->middleware(['auth', 'guru'])
    ->name('guru.')
    ->group(function (): void {
        Route::get('/dashboard', [GuruDashboardController::class, 'index'])->name('dashboard');

        // Modul Presensi Santri
        Route::get('/presensi', [GuruPresensiController::class, 'index'])->name('presensi.index');
        Route::post('/presensi', [GuruPresensiController::class, 'store'])->name('presensi.store');
        Route::get('/presensi/rekap', [GuruPresensiController::class, 'rekap'])->name('presensi.rekap');

        // Modul Setoran Hafalan
        Route::resource('setoran', GuruSetoranHafalanController::class)->except(['show']);
    });

// Wali Santri / Parent Routes (Role-Based Access Control)
Route::prefix('parent')
    ->middleware(['auth', 'parent'])
    ->name('parent.')
    ->group(function (): void {
        Route::get('/dashboard', [ParentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/rapor/{santri}', [ParentRaporController::class, 'cetakRapor'])->name('rapor');
    });
