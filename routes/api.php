<?php

// File: routes/api.php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// --- IMPORTS CONTROLLER API ---
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProdukController;
use App\Http\Controllers\Api\PesananApiController;
use App\Http\Controllers\Api\PaymentProofController;
use App\Http\Controllers\Api\UserProfileController;
use App\Http\Controllers\Api\KonsultasiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// == API Endpoints Katalog Produk (Pets) - Publik ==
// Endpoint untuk mendapatkan daftar kategori Pets
Route::get('/kategori', [ProdukController::class, 'daftarKategori'])->name('api.kategori.index');

// Endpoint untuk mendapatkan daftar dokter (Publik)
Route::get('/dokters', [\App\Http\Controllers\Api\DokterController::class, 'index']);

// Endpoint untuk mendapatkan daftar Pets
Route::get('/produks', [ProdukController::class, 'index'])->name('api.produks.index');
// Endpoint untuk mendapatkan informasi Pet berdasarkan slug
Route::get('/produks/{produk}', [ProdukController::class, 'show'])->name('api.produks.show');


// == API Endpoints Otentikasi - Publik ==
// Endpoint untuk registrasi pengguna baru
Route::post('/register', [AuthController::class, 'register'])->name('api.register');
// Endpoint untuk login dan mendapatkan token autentikasi
Route::post('/login', [AuthController::class, 'login'])->name('api.login');


// == API Endpoints yang Memerlukan Otentikasi (JWT Token) ==
// Semua endpoint yang memerlukan otentikasi berada di dalam grup ini
Route::middleware('auth:api')->group(function () {

    // --- Autentikasi & Profil Pengguna ---
    // Endpoint untuk melakukan logout dan menghapus token
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    // Endpoint untuk mendapatkan data pengguna yang sedang login
    Route::get('/user', [AuthController::class, 'user'])->name('api.user');
    // Endpoint untuk mendapatkan data profile pengguna (alias untuk /user)
    Route::get('/profile', [AuthController::class, 'user'])->name('api.profile');
    // Endpoint untuk update foto profil pengguna
    Route::post('/user/profile-photo', [UserProfileController::class, 'updateProfilePhoto'])->name('user.photo.update');
    // Tambahkan route untuk menghapus foto jika diperlukan
    // Route::delete('/user/profile-photo', [UserProfileController::class, 'deleteProfilePhoto'])->name('user.photo.delete');


    // --- Manajemen Pesanan ---
    // Route resource API untuk pesanan (index, show, store, update, destroy)
    Route::apiResource('pesanan', PesananApiController::class);
    // Route kustom untuk pesanan
    Route::post('/pesanan/{pesanan}/submit-payment-proof', [PaymentProofController::class, 'submitProof'])
        ->name('api.pesanan.submitProof');
    Route::put('/pesanan/{pesanan}/tandai-selesai', [PesananApiController::class, 'tandaiSelesai'])->name('api.pesanan.tandaiSelesai');

    // --- Manajemen Konsultasi ---
    Route::get('/konsultasi', [KonsultasiController::class, 'index']);
    Route::post('/konsultasi', [KonsultasiController::class, 'store']);

    // == API Endpoints Keranjang ==
    Route::get('/keranjang', [\App\Http\Controllers\Api\KeranjangController::class, 'index']);
    Route::put('/keranjang', [\App\Http\Controllers\Api\KeranjangController::class, 'update']);
    Route::put('/keranjang/{id}', [\App\Http\Controllers\Api\KeranjangController::class, 'update']);
    Route::delete('/keranjang/{id}', [\App\Http\Controllers\Api\KeranjangController::class, 'destroy']);

});

Route::post('/produk-upload-gambar', [\App\Http\Controllers\Api\ProdukController::class, 'uploadGambar']);

// Route fallback jika endpoint API tidak ditemukan (opsional)
// Jika endpoint yang diminta tidak ada, akan memberikan respons error 404
Route::fallback(function () {
    return response()->json(['message' => 'Endpoint tidak ditemukan.'], 404);
});

