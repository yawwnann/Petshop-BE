<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Ubah kolom user_id agar boleh null
            $table->foreignId('user_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            // Kembalikan seperti semula jika di-rollback
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};