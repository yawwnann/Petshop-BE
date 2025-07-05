<?php

namespace Database\Seeders;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PetShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori Produks
        $kategoriProduks = [
            [
                'nama_kategori' => 'Makanan Hewan',
                'slug' => 'makanan-hewan',
                'deskripsi' => 'Berbagai jenis makanan untuk hewan peliharaan',
                'icon' => '🍖',
            ],
            [
                'nama_kategori' => 'Aksesoris',
                'slug' => 'aksesoris',
                'deskripsi' => 'Aksesoris dan perlengkapan hewan peliharaan',
                'icon' => '🦮',
            ],
            [
                'nama_kategori' => 'Kandang & Tempat Tidur',
                'slug' => 'kandang-tempat-tidur',
                'deskripsi' => 'Kandang dan tempat tidur yang nyaman',
                'icon' => '🏠',
            ],
            [
                'nama_kategori' => 'Mainan',
                'slug' => 'mainan',
                'deskripsi' => 'Mainan untuk hewan peliharaan',
                'icon' => '🎾',
            ],
            [
                'nama_kategori' => 'Perawatan',
                'slug' => 'perawatan',
                'deskripsi' => 'Produk perawatan dan kebersihan',
                'icon' => '🧴',
            ],
            [
                'nama_kategori' => 'Vitamin & Suplemen',
                'slug' => 'vitamin-suplemen',
                'deskripsi' => 'Vitamin dan suplemen untuk kesehatan hewan',
                'icon' => '💊',
            ],
        ];

        foreach ($kategoriProduks as $kategori) {
            KategoriProduk::create($kategori);
        }

        // Data Produks
        $produks = [
            // Makanan Hewan
            [
                'kategori_produk_id' => 1,
                'nama_produk' => 'Royal Canin Kitten',
                'slug' => 'royal-canin-kitten',
                'deskripsi' => 'Makanan kucing kitten dengan nutrisi lengkap untuk pertumbuhan optimal.',
                'harga' => 150000,
                'stok' => 50,
                'status_ketersediaan' => 'Tersedia',
                'jenis_kelamin' => null,
                'umur_bulan' => null,
                'warna' => null,
                'ras' => null,
            ],
            [
                'kategori_produk_id' => 1,
                'nama_produk' => 'Pedigree Adult Dog',
                'slug' => 'pedigree-adult-dog',
                'deskripsi' => 'Makanan anjing dewasa dengan protein tinggi untuk kesehatan optimal.',
                'harga' => 120000,
                'stok' => 40,
                'status_ketersediaan' => 'Tersedia',
                'jenis_kelamin' => null,
                'umur_bulan' => null,
                'warna' => null,
                'ras' => null,
            ],
            [
                'kategori_produk_id' => 1,
                'nama_produk' => 'Vitakraft Hamster Food',
                'slug' => 'vitakraft-hamster-food',
                'deskripsi' => 'Makanan hamster dengan biji-bijian dan nutrisi seimbang.',
                'harga' => 45000,
                'stok' => 30,
                'status_ketersediaan' => 'Tersedia',
                'jenis_kelamin' => null,
                'umur_bulan' => null,
                'warna' => null,
                'ras' => null,
            ],
            // Aksesoris
            [
                'kategori_produk_id' => 2,
                'nama_produk' => 'Kalung Anjing Premium',
                'slug' => 'kalung-anjing-premium',
                'deskripsi' => 'Kalung anjing dengan bahan kulit berkualitas tinggi.',
                'harga' => 85000,
                'stok' => 25,
                'status_ketersediaan' => 'Tersedia',
                'jenis_kelamin' => null,
                'umur_bulan' => null,
                'warna' => 'Coklat',
                'ras' => null,
            ],
            [
                'kategori_produk_id' => 2,
                'nama_produk' => 'Tali Anjing Retractable',
                'slug' => 'tali-anjing-retractable',
                'deskripsi' => 'Tali anjing yang bisa ditarik dengan panjang maksimal 5 meter.',
                'harga' => 95000,
                'stok' => 20,
                'status_ketersediaan' => 'Tersedia',
                'jenis_kelamin' => null,
                'umur_bulan' => null,
                'warna' => 'Hitam',
                'ras' => null,
            ],
            // Kandang & Tempat Tidur
            [
                'kategori_produk_id' => 3,
                'nama_produk' => 'Kandang Kucing 3 Lantai',
                'slug' => 'kandang-kucing-3-lantai',
                'deskripsi' => 'Kandang kucing dengan 3 lantai dan aksesoris lengkap.',
                'harga' => 450000,
                'stok' => 10,
                'status_ketersediaan' => 'Tersedia',
                'jenis_kelamin' => null,
                'umur_bulan' => null,
                'warna' => 'Putih',
                'ras' => null,
            ],
            // Mainan
            [
                'kategori_produk_id' => 4,
                'nama_produk' => 'Mainan Kucing Laser Pointer',
                'slug' => 'mainan-kucing-laser-pointer',
                'deskripsi' => 'Laser pointer untuk bermain dengan kucing, aman dan menyenangkan.',
                'harga' => 35000,
                'stok' => 35,
                'status_ketersediaan' => 'Tersedia',
                'jenis_kelamin' => null,
                'umur_bulan' => null,
                'warna' => 'Merah',
                'ras' => null,
            ],
            // Perawatan
            [
                'kategori_produk_id' => 5,
                'nama_produk' => 'Shampoo Anjing Anti Kutu',
                'slug' => 'shampoo-anjing-anti-kutu',
                'deskripsi' => 'Shampoo khusus anjing dengan formula anti kutu dan menyehatkan bulu.',
                'harga' => 75000,
                'stok' => 30,
                'status_ketersediaan' => 'Tersedia',
                'jenis_kelamin' => null,
                'umur_bulan' => null,
                'warna' => null,
                'ras' => null,
            ],
            // Vitamin & Suplemen
            [
                'kategori_produk_id' => 6,
                'nama_produk' => 'Vitamin Kucing NutriGel',
                'slug' => 'vitamin-kucing-nutrigel',
                'deskripsi' => 'Vitamin kucing dalam bentuk gel yang mudah dikonsumsi.',
                'harga' => 65000,
                'stok' => 40,
                'status_ketersediaan' => 'Tersedia',
                'jenis_kelamin' => null,
                'umur_bulan' => null,
                'warna' => null,
                'ras' => null,
            ],
        ];

        foreach ($produks as $produk) {
            Produk::create($produk);
        }
    }
}