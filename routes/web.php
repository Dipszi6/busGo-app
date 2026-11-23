<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PembayaranController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');

Route::get('/tiket', [TiketController::class, 'cari'])->name('tiket.cari');
Route::get('/tiket/{id}', [TiketController::class, 'detail'])
    ->whereNumber('id')->name('tiket.detail');
Route::get('/tiket/{id}/kursi', [TiketController::class, 'kursi'])
    ->whereNumber('id')->name('tiket.kursi');
Route::post('/tiket/{id}/kursi', [TiketController::class, 'lanjutKursi'])
    ->whereNumber('id')->name('tiket.kursi.lanjut');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

Route::post('/webhook/midtrans', [PembayaranController::class, 'webhook'])
    ->name('webhook.midtrans');

require __DIR__ . '/auth.php';
