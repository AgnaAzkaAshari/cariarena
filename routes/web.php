<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VenueController;
use App\Http\Controllers\Admin\PemesananController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PengaturanController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

// ✅ Redirect root ke login admin
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// ✅ Route authentication khusus admin - TANPA MIDDLEWARE AUTH
Route::prefix('admin')->name('admin.')->group(function () {
    // Login Routes
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login.submit');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Registration Routes (opsional)
    Route::get('register', [AdminAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AdminAuthController::class, 'register'])->name('register.submit');
    
    // Forgot Password Routes (opsional)
    Route::get('forgot-password', [AdminAuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
    Route::post('forgot-password', [AdminAuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [AdminAuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [AdminAuthController::class, 'reset'])->name('password.update');
});

// ✅ Protected routes untuk admin - DENGAN MIDDLEWARE AUTH:ADMIN
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {
    // DASHBOARD
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // NOTIFIKASI
    Route::get('dashboard/notifikasi', [DashboardController::class, 'notifikasi'])->name('dashboard.notifikasi');
    
    // MENU LAINNYA
    Route::get('/catatan-aktivitas', [DashboardController::class, 'catatanAktivitas'])->name('catatan-aktivitas.index');
    Route::get('/jadwal-lapangan', [DashboardController::class, 'jadwalLapangan'])->name('jadwal-lapangan.index');
    
    // ✅ PERBAIKAN: Manajemen Pengguna - Route yang benar
    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Manajemen Venue
    Route::prefix('venue')->name('venue.')->group(function () {
        Route::get('/', [VenueController::class, 'index'])->name('index');
        Route::get('/create', [VenueController::class, 'create'])->name('create');
        Route::post('/', [VenueController::class, 'store'])->name('store');
        Route::get('/{venue}', [VenueController::class, 'show'])->name('show');
        Route::get('/{venue}/edit', [VenueController::class, 'edit'])->name('edit');
        Route::put('/{venue}', [VenueController::class, 'update'])->name('update');
        Route::delete('/{venue}', [VenueController::class, 'destroy'])->name('destroy');
        
        // Route tambahan dengan nama Indonesia
        Route::get('/tambah', [VenueController::class, 'create'])->name('tambah');
        Route::post('/simpan', [VenueController::class, 'store'])->name('simpan');
        Route::delete('/{venue}/hapus', [VenueController::class, 'destroy'])->name('hapus');
    });

    // Manajemen Pemesanan
    Route::prefix('pemesanan')->name('pemesanan.')->group(function () {
    Route::get('/', [PemesananController::class, 'index'])->name('index');
    Route::post('/', [PemesananController::class, 'store'])->name('store');
    Route::get('/{pemesanan}', [PemesananController::class, 'show'])->name('show');
    Route::get('/{pemesanan}/edit', [PemesananController::class, 'edit'])->name('edit');
    Route::put('/{pemesanan}', [PemesananController::class, 'update'])->name('update');
    Route::delete('/{pemesanan}', [PemesananController::class, 'destroy'])->name('destroy');
    Route::post('/{pemesanan}/confirm', [PemesananController::class, 'confirm'])->name('confirm');
    Route::post('/{pemesanan}/cancel', [PemesananController::class, 'cancel'])->name('cancel');
    Route::post('/{pemesanan}/complete', [PemesananController::class, 'complete'])->name('complete');
    });

    // ✅ PERBAIKAN: Manajemen Transaksi - Hapus nested prefix admin
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
        Route::post('/filter', [TransaksiController::class, 'filter'])->name('filter');
        Route::put('/{transaksi}', [TransaksiController::class, 'update'])->name('update');
        Route::delete('/{transaksi}', [TransaksiController::class, 'destroy'])->name('destroy');
        Route::post('/{transaksi}/confirm', [TransaksiController::class, 'confirmPayment'])->name('confirm');
        Route::post('/{transaksi}/reject', [TransaksiController::class, 'rejectPayment'])->name('reject');
    });

    // Manajemen Laporan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index');
        Route::get('/create', [LaporanController::class, 'create'])->name('create');
        Route::post('/', [LaporanController::class, 'store'])->name('store');
        Route::get('/{laporan}', [LaporanController::class, 'show'])->name('show');
        Route::get('/{laporan}/edit', [LaporanController::class, 'edit'])->name('edit');
        Route::put('/{laporan}', [LaporanController::class, 'update'])->name('update');
        Route::delete('/{laporan}', [LaporanController::class, 'destroy'])->name('destroy');
        
        // Route tambahan
        Route::get('/tambah', [LaporanController::class, 'create'])->name('tambah');
        Route::post('/simpan', [LaporanController::class, 'store'])->name('simpan');
        Route::delete('/{laporan}/hapus', [LaporanController::class, 'destroy'])->name('hapus');
        
        // Export routes
        Route::post('/export-pdf', [LaporanController::class, 'exportPdf'])->name('export-pdf');
        Route::post('/export-excel', [LaporanController::class, 'exportExcel'])->name('export-excel');
        Route::post('/quick-generate', [LaporanController::class, 'quickGenerate'])->name('quick-generate');
        Route::get('/analitik', [LaporanController::class, 'analitik'])->name('analitik');
    });

    // Settings Routes
    Route::prefix('pengaturan')->name('pengaturan.')->group(function () {
        Route::get('/', [PengaturanController::class, 'index'])->name('index');
        Route::post('/profile', [PengaturanController::class, 'updateProfile'])->name('profile.update');
        Route::post('/system', [PengaturanController::class, 'updateSystem'])->name('system.update');
        Route::post('/admin', [PengaturanController::class, 'addAdmin'])->name('admin.add');
        Route::post('/notifications', [PengaturanController::class, 'updateNotifications'])->name('notifications.update');
        Route::post('/security', [PengaturanController::class, 'updateSecurity'])->name('security.update');
        Route::post('/backup', [PengaturanController::class, 'backupNow'])->name('backup.now');
        Route::post('/faq', [PengaturanController::class, 'updateFAQ'])->name('faq.update');
    });
});