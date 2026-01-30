<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SiswaController as AdminSiswaController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\AspirasiController;
use App\Http\Controllers\Admin\InputAspirasiController;
use App\Http\Controllers\Siswa\SiswaController;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('siswa', AdminSiswaController::class);
    Route::resource('kategori', KategoriController::class);
    Route::resource('aspirasi', AspirasiController::class)->only(['index', 'show']);
    Route::patch('aspirasi/{aspirasi}/status', [AspirasiController::class, 'updateStatus'])->name('aspirasi.update-status');
});

Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'dashboard'])->name('dashboard');
    Route::get('/input-aspirasi', [SiswaController::class, 'inputAspirasi'])->middleware('siswa')->name('input-aspirasi');
    Route::post('/input-aspirasi', [SiswaController::class, 'storeAspirasi'])->middleware('siswa')->name('store-aspirasi');
    Route::get('/riwayat', [SiswaController::class, 'riwayat'])->middleware('siswa')->name('riwayat');
    Route::get('/aspirasi/{id}', [SiswaController::class, 'detailAspirasi'])->middleware('siswa')->name('detail-aspirasi');
    Route::get('/aspirasi/{id}/status', [SiswaController::class, 'aspirasiStatus'])->middleware('siswa')->name('aspirasi.status');
    Route::get('/aspirasi/{id}/edit', [SiswaController::class, 'editAspirasi'])->middleware('siswa')->name('edit-aspirasi');
    Route::patch('/aspirasi/{id}', [SiswaController::class, 'updateAspirasi'])->middleware('siswa')->name('update-aspirasi');
    Route::delete('/aspirasi/{id}', [SiswaController::class, 'deleteAspirasi'])->middleware('siswa')->name('delete-aspirasi');
});

