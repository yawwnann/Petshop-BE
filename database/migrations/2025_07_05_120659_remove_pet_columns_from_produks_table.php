<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn(['jenis_kelamin', 'umur_bulan', 'warna', 'ras']);
        });
    }

    public function down()
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->string('jenis_kelamin')->nullable();
            $table->integer('umur_bulan')->nullable();
            $table->string('warna')->nullable();
            $table->string('ras')->nullable();
        });
    }
};
