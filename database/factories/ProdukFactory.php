<?php

namespace Database\Factories;

use App\Models\KategoriProduk;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaProduk = $this->faker->unique()->words(2, true);

        return [
            'kategori_produk_id' => KategoriProduk::factory(),
            'nama_produk' => $namaProduk,
            'slug' => Str::slug($namaProduk),
            'deskripsi' => $this->faker->paragraph(),
            'harga' => $this->faker->numberBetween(50000, 500000),
            'stok' => $this->faker->numberBetween(1, 50),
            'status_ketersediaan' => $this->faker->randomElement(['Tersedia', 'Habis']),
            'gambar_utama' => null,
            'jenis_kelamin' => $this->faker->randomElement(['Jantan', 'Betina']),
            'umur_bulan' => $this->faker->numberBetween(1, 60),
            'warna' => $this->faker->randomElement(['Putih', 'Hitam', 'Coklat', 'Abu-abu', 'Orange', 'Campuran']),
            'ras' => $this->faker->randomElement(['Persia', 'Angora', 'Siam', 'Maine Coon', 'British Shorthair', 'Ragdoll']),
            'merk' => $this->faker->company(),
            'berat_volume' => $this->faker->randomFloat(2, 0.1, 10) . ' kg',
            'expired' => $this->faker->optional()->date(),
        ];
    }
}