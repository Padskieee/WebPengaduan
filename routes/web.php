<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\User\DashboardController as UserDashboard;
use App\Http\Controllers\User\LaporanController;
use App\Http\Controllers\User\FeedController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Admin\HasilLaporanController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('user.login');
});

/*
|--------------------------------------------------------------------------
| ROUTES USER
|--------------------------------------------------------------------------
*/
Route::prefix('user')->name('user.')->group(function () {

    // Guest (belum login)
    Route::middleware('guest')->group(function () {
        Route::get('/login',     [UserAuthController::class, 'showLogin'])->name('login');
        Route::post('/login',    [UserAuthController::class, 'login']);
        Route::get('/register',  [UserAuthController::class, 'showRegister'])->name('register');
        Route::post('/register', [UserAuthController::class, 'register']);
    });

    // Logout
    Route::post('/logout', [UserAuthController::class, 'logout'])
        ->middleware('auth')
        ->name('logout');

    // Verifikasi email
    Route::middleware('auth')->group(function () {
        Route::get('/email/verify', [UserAuthController::class, 'verificationNotice'])
            ->name('verification.notice');
        Route::get('/email/verify/{id}/{hash}', [UserAuthController::class, 'verificationVerify'])
            ->middleware('signed')
            ->name('verification.verify');
        Route::post('/email/verification-notification', [UserAuthController::class, 'verificationResend'])
            ->middleware('throttle:6,1')
            ->name('verification.send');
    });

    // Harus login & verified
    Route::middleware('auth.user')->group(function () {
        Route::get('/dashboard', [UserDashboard::class, 'index'])->name('dashboard');

        // Laporan
        Route::get('/laporan',      [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/buat', [LaporanController::class, 'create'])->name('laporan.create');
        Route::post('/laporan',     [LaporanController::class, 'store'])->name('laporan.store');
        Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');

        // Feed
        Route::get('/feed',      [FeedController::class, 'index'])->name('feed.index');
        Route::get('/feed/{id}', [FeedController::class, 'show'])->name('feed.show');
    });

});

/*
|--------------------------------------------------------------------------
| ROUTES ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Guest admin
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Harus login admin
    Route::middleware('auth.admin')->group(function () {

        Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');
        Route::post('/logout',   [AdminAuthController::class, 'logout'])->name('logout');

        // ── Laporan ──
        Route::get('/laporan',              [AdminLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/{id}',         [AdminLaporanController::class, 'show'])->name('laporan.show');
        Route::post('/laporan/{id}/status', [AdminLaporanController::class, 'updateStatus'])->name('laporan.status');
        Route::delete('/laporan/{id}',      [AdminLaporanController::class, 'destroy'])->name('laporan.destroy');

        // ── Hasil laporan ──
        Route::get('/hasil',                   [HasilLaporanController::class, 'index'])->name('hasil.index');
        Route::get('/laporan/{id}/hasil/buat', [HasilLaporanController::class, 'create'])->name('hasil.create');
        Route::post('/laporan/{id}/hasil',     [HasilLaporanController::class, 'store'])->name('hasil.store');
        Route::get('/hasil/{id}',              [HasilLaporanController::class, 'show'])->name('hasil.show');
        Route::post('/hasil/{id}/publish',     [HasilLaporanController::class, 'togglePublish'])->name('hasil.publish');

        // ── Kategori ──
        Route::get('/kategori',           [KategoriController::class, 'index'])->name('kategori.index');
        Route::get('/kategori/tambah',    [KategoriController::class, 'create'])->name('kategori.create');
        Route::post('/kategori',          [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{id}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{id}',      [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}',   [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // ── User ──
        Route::get('/user',      [UserController::class, 'index'])->name('user.index');
        Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

    });

});
