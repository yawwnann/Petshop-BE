<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Mengubah kolom yang sudah ada untuk menambahkan nilai default
            // Ini akan mengisi kolom dengan tanggal saat ini jika tidak disediakan.
            $table->date('tanggal_pesanan')->default(now())->change();
            // Atau, jika Anda sebelumnya menggunakan timestamp dan ingin default, bisa juga:
            // $table->timestamp('tanggal_pesanan')->useCurrent()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Untuk rollback, hapus default value
            $table->date('tanggal_pesanan')->default(null)->change();
            // Atau jika sebelumnya timestamp:
            // $table->timestamp('tanggal_pesanan')->default(null)->change();
        });
    }
};