<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\VerifikasiController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\LaporanController;

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

    Route::get('/user/biodata', [\App\Http\Controllers\BiodataController::class, 'index'])
        ->name('user.biodata');

    Route::post('/user/biodata', [\App\Http\Controllers\BiodataController::class, 'store'])
        ->name('user.biodata.store');

    Route::get('/user/dokumen', [\App\Http\Controllers\DokumenController::class, 'index'])
        ->name('user.dokumen');

    Route::post('/user/dokumen', [\App\Http\Controllers\DokumenController::class, 'store'])
        ->name('user.dokumen.store');

    Route::post('/user/daftar-ulang', [\App\Http\Controllers\DokumenController::class, 'store'])
        ->name('user.daftar_ulang.store');

    Route::get('/user/orangtua', [\App\Http\Controllers\OrangtuaController::class, 'index'])
        ->name('user.orangtua');

    Route::post('/user/orangtua', [\App\Http\Controllers\OrangtuaController::class, 'store'])
        ->name('user.orangtua.store');

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware(['cekRole:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/verifikasi', [VerifikasiController::class, 'index'])->name('verifikasi');
        Route::view('/seleksi', 'admin.seleksi')->name('seleksi');
        Route::post('/pengumuman', [PengumumanController::class, 'store'])->name('pengumuman.store');
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

        // Verifikasi Dokumen Routes
        Route::get('/dokumen', [VerifikasiController::class, 'index'])->name('dokumen.index');
        Route::get('/dokumen/{dokumen}', [VerifikasiController::class, 'show'])->name('dokumen.show');
        Route::post('/dokumen/{dokumen}/update-status', [VerifikasiController::class, 'updateStatus'])->name('dokumen.update-status');
        Route::get('/dokumen/{dokumen}/download', [VerifikasiController::class, 'download'])->name('verifikasi.download');

        // Laporan Routes
        Route::get('/laporan-index', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export-dokumen', [LaporanController::class, 'exportExcel'])->name('laporan.export-dokumen');
        Route::get('/laporan/export-hasil', [LaporanController::class, 'exportHasil'])->name('laporan.export-hasil');
        Route::get('/laporan/dokumen/{status}', [LaporanController::class, 'dokumenByStatus'])->name('laporan.dokumen-status');
        Route::get('/laporan/hasil/{status}', [LaporanController::class, 'hasilByStatus'])->name('laporan.hasil-status');

        // Helper route untuk list biodata dengan user data
        Route::get('/biodata-list', function () {
            return response()->json(
                \App\Models\Biodata::with('user:id,nama_ayah,nik_ayah,pekerjaan_ayah,telepon_ayah,nama_ibu,nik_ibu,pekerjaan_ibu,telepon_ibu,alamat_ortu,rt_ortu,rw_ortu,kelurahan_ortu,kecamatan_ortu,kabupaten_ortu,provinsi_ortu,kode_pos_ortu,kk,akte,bukti_transfer')
                    ->select('id', 'user_id', 'nomor_pendaftaran', 'nama_lengkap')
                    ->get()
            );
        })->name('biodata.list');

        // Route untuk detail user
        Route::get('/user-detail/{user}', [VerifikasiController::class, 'getUserDetail'])->name('user.detail');
    });

    // Additional admin helpers for verifikasi (user file detail/download)
    Route::get('/verifikasi/user/{user}', [VerifikasiController::class, 'showUser'])->name('verifikasi.user.show');
    Route::get('/verifikasi/user/{user}/download/{file}', [VerifikasiController::class, 'downloadUserFile'])->name('verifikasi.user.download');
    Route::post('/verifikasi/user/{user}/file/{file}/update-status', [VerifikasiController::class, 'updateUserFileStatus'])->name('verifikasi.user.update-status');

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

        // Daftar Ulang
        Route::view('/daftar-ulang', 'user.daftar_ulang')->name('daftar_ulang');

            // Pengumuman (halaman user)
            Route::get('/pengumuman', [\App\Http\Controllers\PengumumanController::class, 'userIndex'])->name('pengumuman');
    });
});
