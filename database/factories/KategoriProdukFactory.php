<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\KategoriProduk>
 */
class KategoriProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $namaKategori = $this->faker->unique()->words(2, true);

        return [
            'nama_kategori' => $namaKategori,
            'slug' => Str::slug($namaKategori),
            'deskripsi' => $this->faker->sentence(),
            'icon' => $this->faker->randomElement(['🐱', '🐶', '🐰', '🐹', '🐦', '🐠']),
        ];
    }
}