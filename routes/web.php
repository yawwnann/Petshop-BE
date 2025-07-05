<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;


Route::get('/', function () {
    return view('welcome');
});

// Add login route for web authentication
Route::get('/login', function () {
    return redirect('/admin/login');
})->name('login');

Route::get('/pesanan/{pesanan}/pdf', [PdfController::class, 'downloadPesananPdf'])
    ->name('pesanan.pdf');