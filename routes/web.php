<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DataAsetController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\DataLatihController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\PenghapusanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\ProfileSettingController;
use App\Http\Controllers\AsetDesaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/laporan', [LaporanController::class, 'index']);
Route::post('/laporan/cetak', [LaporanController::class, 'cetak']);
Route::get('/laporan/download-pdf', [LaporanController::class, 'downloadPdf']);

Route::get('/penghapusan', [PenghapusanController::class, 'index']);
Route::post('/penghapusan/{id_penghapusan}/approve', [PenghapusanController::class, 'approve']);
Route::post('/penghapusan/{id_penghapusan}/reject', [PenghapusanController::class, 'reject']);

Route::get('/profile', [ProfileSettingController::class, 'edit']);
Route::put('/profile', [ProfileSettingController::class, 'updateInfo']);
Route::put('/profile/password', [ProfileSettingController::class, 'updatePassword']);

Route::get('/perbaikan', [PerbaikanController::class, 'index']);
Route::post('/perbaikan/{id_perbaikan}/approve', [PerbaikanController::class, 'approve']);
Route::post('/perbaikan/{id_perbaikan}/reject', [PerbaikanController::class, 'reject']);

Route::middleware('admin')->group(function () {
    // Data Pengguna
    Route::get('/data-pengguna', [PenggunaController::class, 'index']);
    Route::get('/data-pengguna/create', [PenggunaController::class, 'create']);
    Route::post('/data-pengguna', [PenggunaController::class, 'store']);
    Route::delete('/data-pengguna/{id_pengguna}', [PenggunaController::class, 'destroy']);

    // Data Aset
    Route::get('/data-aset', [DataAsetController::class, 'index']);
    Route::get('/data-aset/create', [DataAsetController::class, 'create']);
    Route::post('/data-aset', [DataAsetController::class, 'store']);
    Route::get('/data-aset/{id_aset}/edit', [DataAsetController::class, 'edit']);
    Route::put('/data-aset/{id_aset}', [DataAsetController::class, 'update']);
    Route::delete('/data-aset/{id_aset}', [DataAsetController::class, 'destroy']);
    Route::get('/data-aset/download-pdf', [DataAsetController::class, 'downloadPdf']);

    // Data Latih
    Route::get('/data-latih', [DataLatihController::class, 'index']);
    Route::get('/data-latih/create', [DataLatihController::class, 'create']);
    Route::post('/data-latih', [DataLatihController::class, 'store']);
    Route::get('/data-latih/{id_data_latih}/edit', [DataLatihController::class, 'edit']);
    Route::put('/data-latih/{id_data_latih}', [DataLatihController::class, 'update']);
    Route::delete('/data-latih/{id_data_latih}', [DataLatihController::class, 'destroy']);

    // Klasifikasi
   Route::get('/klasifikasi', [KlasifikasiController::class, 'index']);
    Route::get('/klasifikasi/riwayat', [KlasifikasiController::class, 'riwayat']);
    Route::post('/klasifikasi', [KlasifikasiController::class, 'klasifikasikan']);
    Route::get('/klasifikasi/{id_klasifikasi}/pdf', [KlasifikasiController::class, 'downloadPdf']);

    // Perbaikan
    Route::get('/perbaikan/create', [PerbaikanController::class, 'create']);
    Route::post('/perbaikan', [PerbaikanController::class, 'store']);
    Route::delete('/perbaikan/{id_perbaikan}', [PerbaikanController::class, 'destroy']);
    Route::get('/klasifikasi/riwayat-lengkap', [KlasifikasiController::class, 'riwayatLengkap']);

    // Penghapusan
    Route::get('/penghapusan/create', [PenghapusanController::class, 'create']);
    Route::post('/penghapusan', [PenghapusanController::class, 'store']);
    Route::delete('/penghapusan/{id_penghapusan}', [PenghapusanController::class, 'destroy']);

    // Pembelian
    Route::get('/pembelian', [PembelianController::class, 'index']);
    Route::get('/pembelian/create', [PembelianController::class, 'create']);
    Route::post('/pembelian', [PembelianController::class, 'store']);
    Route::delete('/pembelian/{id_pembelian}', [PembelianController::class, 'destroy']);

    // Aset Desa
    Route::get('/data-aset-desa', [AsetDesaController::class, 'index']);
    Route::get('/data-aset-desa/create', [AsetDesaController::class, 'create']);
    Route::post('/data-aset-desa', [AsetDesaController::class, 'store']);
    Route::get('/data-aset-desa/{id_aset_desa}/edit', [AsetDesaController::class, 'edit']);
    Route::put('/data-aset-desa/{id_aset_desa}', [AsetDesaController::class, 'update']);
    Route::delete('/data-aset-desa/{id_aset_desa}', [AsetDesaController::class, 'destroy']);
});


//require __DIR__.'/auth.php';