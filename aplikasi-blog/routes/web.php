<?php

use App\Http\Controllers\PengunjungController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Halaman Pengunjung (publik, tanpa middleware auth)
|--------------------------------------------------------------------------
*/

// Halaman utama: 5 artikel terbaru + widget kategori (+ filter kategori).
Route::get('/', [PengunjungController::class, 'index'])->name('pengunjung.index');

// Halaman detail artikel: isi lengkap + artikel terkait.
Route::get('/artikel/{id}', [PengunjungController::class, 'show'])
    ->whereNumber('id')
    ->name('pengunjung.show');

// Penyaji gambar artikel dari folder uploads_artikel milik CMS.
Route::get('/uploads_artikel/{file}', [PengunjungController::class, 'gambar'])
    ->where('file', '[A-Za-z0-9._-]+')
    ->name('pengunjung.gambar');
