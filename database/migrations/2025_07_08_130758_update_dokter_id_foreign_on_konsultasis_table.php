<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('konsultasis', function (Blueprint $table) {
            // Drop foreign key lama (ke users)
            $table->dropForeign(['dokter_id']);
            // Tambahkan foreign key baru ke dokters
            $table->foreign('dokter_id')->references('id')->on('dokters')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('konsultasis', function (Blueprint $table) {
            $table->dropForeign(['dokter_id']);
            $table->foreign('dokter_id')->references('id')->on('users')->nullOnDelete();
        });
    }
};
