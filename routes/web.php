<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Kategori Produk CRUD
Route::resource('kategori-produk', App\Http\Controllers\KategoriProdukController::class)->middleware(['auth']);

// Produk CRUD
Route::resource('produk', App\Http\Controllers\ProdukController::class)->middleware(['auth']);

// Pesanan CRUD
Route::resource('pesanan', App\Http\Controllers\PesananController::class)->except(['create', 'store']);

// Dokter CRUD
Route::resource('dokter', App\Http\Controllers\DokterController::class)->middleware(['auth']);

// Konsultasi CRUD
Route::resource('konsultasi', App\Http\Controllers\KonsultasiController::class)->middleware(['auth']);

require __DIR__ . '/auth.php';
