<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::view('/', 'welcome');
Route::view('/contact-us', 'contact');

// Email verification
Route::get('/verify-email', [AuthController::class, 'showVerifyForm'])->name('verify.form');
Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');
Route::post('/verify-email', [AuthController::class, 'verify'])->name('verify.otp');

/*
|--------------------------------------------------------------------------
| Guest (belum login)
|--------------------------------------------------------------------------
*/
Route::middleware(['guest'])->group(function () {

    // Login & Register
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');

    /*
    |--------------------------------------------------------------------------
    | SSO Google / GitHub / Provider Sosial lainnya
    |--------------------------------------------------------------------------
    */
    Route::get('/auth/{provider}', [AuthController::class, 'redirect'])
        ->where('provider', 'google|github|facebook')
        ->name('sso.redirect');

    Route::get('/auth/{provider}/callback', [AuthController::class, 'callback'])
        ->where('provider', 'google|github|facebook')
        ->name('sso.callback');

    // Forgot password
    Route::get('/forgot-password', [AuthController::class, 'showRequestForm'])->name('forgot_password.email_form');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('forgot_password.send_link');

    // Reset password
    Route::get('/password-reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password-reset', [AuthController::class, 'resetPassword'])->name('password.update');
});

/*
|--------------------------------------------------------------------------
| Authenticated Users (sudah login)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::view('/myprofile', 'myprofile')->name('myprofile');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['cekRole:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::view('/verifikasi', 'admin.verifikasi')->name('verifikasi');
        Route::view('/seleksi', 'admin.seleksi')->name('seleksi');
        Route::view('/pengumuman', 'admin.pengumuman')->name('pengumuman');
        Route::view('/laporan', 'admin.laporan')->name('laporan');
    });

    /*
    |--------------------------------------------------------------------------
    | User Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['cekRole:user'])->prefix('user')->name('user.')->group(function () {

        // Biodata
        Route::get('/biodata', [BiodataController::class, 'index'])->name('biodata');
        // Dokumen
        Route::view('/dokumen', 'user.dokumen')->name('dokumen');

        // Status PPDB
        Route::view('/status', 'user.status')->name('status');

        // Daftar Ulang
        Route::view('/daftar-ulang', 'user.daftar_ulang')->name('daftar_ulang');
    });
});
