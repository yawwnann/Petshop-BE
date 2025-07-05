<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Ubah kolom agar boleh null
            $table->string('metode_pembayaran', 100)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Kembalikan seperti semula
            $table->string('metode_pembayaran', 100)->nullable(false)->change();
        });
    }
};