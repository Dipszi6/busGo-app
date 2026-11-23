<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ArmadaController;
use App\Http\Controllers\Admin\JadwalController as AdminJadwalController;
use App\Http\Controllers\Admin\OperasionalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/tiket', [TiketController::class, 'cari'])->name('tiket.cari');
Route::get('/tiket/{id}', [TiketController::class, 'detail'])
    ->whereNumber('id')->name('tiket.detail');
Route::get('/tiket/{id}/kursi', [TiketController::class, 'kursi'])
    ->whereNumber('id')->name('tiket.kursi');
Route::post('/tiket/{id}/kursi', [TiketController::class, 'lanjutKursi'])
    ->whereNumber('id')->name('tiket.kursi.lanjut');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/riwayat-pemesanan', [DashboardController::class, 'riwayat'])->name('riwayat.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/pemesanan/{id}/penumpang', [PemesananController::class, 'penumpang'])
        ->whereNumber('id')->name('pemesanan.penumpang');
    Route::post('/pemesanan/{id}/penumpang', [PemesananController::class, 'simpanPenumpang'])
        ->whereNumber('id')->name('pemesanan.penumpang.simpan');
    Route::get('/pemesanan/{id}/ringkasan', [PemesananController::class, 'ringkasan'])
        ->whereNumber('id')->name('pemesanan.ringkasan');
    Route::post('/pemesanan/{id}/simpan', [PemesananController::class, 'simpan'])
        ->whereNumber('id')->name('pemesanan.simpan');
    Route::get('/pemesanan/sukses/{kode}', [PemesananController::class, 'sukses'])
        ->name('pemesanan.sukses');
    Route::get('/pembayaran/selesai', [PembayaranController::class, 'selesaiMidtrans'])
        ->name('pembayaran.selesai.midtrans');
    Route::get('/pembayaran/{kode}', [PembayaranController::class, 'bayar'])
        ->name('pembayaran.bayar');
    Route::get('/pembayaran/{kode}/gagal', [PembayaranController::class, 'gagal'])
        ->name('pembayaran.gagal');
    Route::get('/pembayaran/{kode}/selesai', [PembayaranController::class, 'selesai'])
        ->name('pembayaran.selesai');
    Route::get('/pemesanan/etiket/{kode}', [PemesananController::class, 'etiket'])
        ->name('pemesanan.etiket');
    Route::get('/pemesanan/etiket/{kode}/pdf', [PemesananController::class, 'etiketPdf'])
        ->name('pemesanan.etiket.pdf');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/armada', [ArmadaController::class, 'index'])->name('armada.index');
    Route::post('/armada', [ArmadaController::class, 'store'])->name('armada.store');
    Route::put('/armada/{bus}', [ArmadaController::class, 'update'])->name('armada.update');
    Route::delete('/armada/{bus}', [ArmadaController::class, 'destroy'])->name('armada.destroy');

    Route::get('/jadwal', [AdminJadwalController::class, 'index'])->name('jadwal.index');
    Route::post('/jadwal/terminal', [AdminJadwalController::class, 'storeTerminal'])->name('jadwal.terminal.store');
    Route::post('/jadwal/rute', [AdminJadwalController::class, 'storeRute'])->name('jadwal.rute.store');
    Route::post('/jadwal', [AdminJadwalController::class, 'storeJadwal'])->name('jadwal.store');
    Route::patch('/jadwal/{jadwal}/toggle', [AdminJadwalController::class, 'toggleAktif'])->name('jadwal.toggle');
    Route::delete('/jadwal/{jadwal}', [AdminJadwalController::class, 'destroyJadwal'])->name('jadwal.destroy');

    Route::get('/pemesanan', [OperasionalController::class, 'pemesanan'])->name('pemesanan.index');
    Route::get('/pemesanan/{pemesanan}', [OperasionalController::class, 'showPemesanan'])->name('pemesanan.show');
    Route::patch('/pemesanan/{pemesanan}/status', [OperasionalController::class, 'updateStatusPemesanan'])->name('pemesanan.status');

    Route::get('/pembayaran', [OperasionalController::class, 'pembayaran'])->name('pembayaran.index');
    Route::get('/pelanggan', [OperasionalController::class, 'pelanggan'])->name('pelanggan.index');
    Route::get('/laporan', [OperasionalController::class, 'laporan'])->name('laporan.index');
});

Route::post('/webhook/midtrans', [PembayaranController::class, 'webhook'])
    ->name('webhook.midtrans');

require __DIR__ . '/auth.php';
