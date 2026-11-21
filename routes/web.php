<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\TiketController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\ProfileController;
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
});

require __DIR__ . '/auth.php';
