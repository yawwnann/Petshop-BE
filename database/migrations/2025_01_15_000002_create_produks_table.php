<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_produk_id')->constrained('kategori_produks')->cascadeOnDelete();
            $table->string('nama_produk', 150);
            $table->string('slug', 170)->unique();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 15, 2);
            $table->integer('stok')->default(0);
            $table->string('status_ketersediaan', 50)->default('Tersedia');
            $table->string('gambar_utama', 255)->nullable();
            $table->enum('jenis_kelamin', ['Jantan', 'Betina'])->nullable();
            $table->integer('umur_bulan')->nullable();
            $table->string('warna', 100)->nullable();
            $table->string('ras', 100)->nullable();
            $table->string('merk', 100)->nullable();
            $table->string('berat_volume', 50)->nullable();
            $table->date('expired')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};