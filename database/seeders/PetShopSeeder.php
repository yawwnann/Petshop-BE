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
            // Makanan Kucing
            [
                'kategori_produk_id' => 1,
                'nama_produk' => 'Whiskas Adult Tuna 1.2kg',
                'slug' => 'whiskas-adult-tuna-1-2kg',
                'deskripsi' => 'Makanan kucing dewasa rasa tuna, kaya vitamin dan mineral untuk bulu sehat dan pencernaan optimal.',
                'harga' => 95000,
                'stok' => 40,
                'status_ketersediaan' => 'Tersedia',
                'gambar_utama' => 'https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'kategori_produk_id' => 1,
                'nama_produk' => 'Me-O Persian Adult 1.1kg',
                'slug' => 'meo-persian-adult-1-1kg',
                'deskripsi' => 'Makanan kucing khusus Persia, membantu mengurangi hairball dan menjaga kesehatan bulu.',
                'harga' => 88000,
                'stok' => 30,
                'status_ketersediaan' => 'Tersedia',
                'gambar_utama' => 'https://images.unsplash.com/photo-1518715308788-3005759c61d3?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'kategori_produk_id' => 1,
                'nama_produk' => 'Royal Canin Kitten 2kg',
                'slug' => 'royal-canin-kitten-2kg',
                'deskripsi' => 'Makanan kucing kitten dengan nutrisi lengkap untuk pertumbuhan optimal dan daya tahan tubuh.',
                'harga' => 210000,
                'stok' => 25,
                'status_ketersediaan' => 'Tersedia',
                'gambar_utama' => 'https://images.unsplash.com/photo-1518715308788-3005759c61d3?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'kategori_produk_id' => 1,
                'nama_produk' => 'Pro Plan Adult Salmon 1.5kg',
                'slug' => 'pro-plan-adult-salmon-1-5kg',
                'deskripsi' => 'Makanan kucing dewasa premium dengan salmon asli, mendukung sistem imun dan kesehatan ginjal.',
                'harga' => 230000,
                'stok' => 20,
                'status_ketersediaan' => 'Tersedia',
                'gambar_utama' => 'https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'kategori_produk_id' => 1,
                'nama_produk' => 'Friskies Seafood Sensations 1.1kg',
                'slug' => 'friskies-seafood-sensations-1-1kg',
                'deskripsi' => 'Makanan kering kucing dengan rasa seafood, lezat dan bergizi untuk kucing aktif.',
                'harga' => 67000,
                'stok' => 35,
                'status_ketersediaan' => 'Tersedia',
                'gambar_utama' => 'https://images.unsplash.com/photo-1518715308788-3005759c61d3?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'kategori_produk_id' => 1,
                'nama_produk' => 'Bolt Tuna Cat Food 1kg',
                'slug' => 'bolt-tuna-cat-food-1kg',
                'deskripsi' => 'Makanan kucing ekonomis dengan rasa tuna, cocok untuk semua usia.',
                'harga' => 42000,
                'stok' => 50,
                'status_ketersediaan' => 'Tersedia',
                'gambar_utama' => 'https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=400&q=80',
            ],
            // Perlengkapan Kucing
            [
                'kategori_produk_id' => 2,
                'nama_produk' => 'Tempat Makan Kucing Stainless',
                'slug' => 'tempat-makan-kucing-stainless',
                'deskripsi' => 'Tempat makan kucing berbahan stainless steel, anti slip dan mudah dibersihkan.',
                'harga' => 35000,
                'stok' => 30,
                'status_ketersediaan' => 'Tersedia',
                'gambar_utama' => 'https://images.unsplash.com/photo-1518715308788-3005759c61d3?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'kategori_produk_id' => 2,
                'nama_produk' => 'Litter Box Kucing Jumbo',
                'slug' => 'litter-box-kucing-jumbo',
                'deskripsi' => 'Kotak pasir kucing ukuran besar, nyaman dan mudah dibersihkan.',
                'harga' => 78000,
                'stok' => 18,
                'status_ketersediaan' => 'Tersedia',
                'gambar_utama' => 'https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'kategori_produk_id' => 2,
                'nama_produk' => 'Mainan Kucing Bola Bell',
                'slug' => 'mainan-kucing-bola-bell',
                'deskripsi' => 'Bola mainan dengan lonceng di dalamnya, cocok untuk melatih aktifitas kucing.',
                'harga' => 15000,
                'stok' => 60,
                'status_ketersediaan' => 'Tersedia',
                'gambar_utama' => 'https://images.unsplash.com/photo-1518715308788-3005759c61d3?auto=format&fit=crop&w=400&q=80',
            ],
            [
                'kategori_produk_id' => 2,
                'nama_produk' => 'Sisir Bulu Kucing',
                'slug' => 'sisir-bulu-kucing',
                'deskripsi' => 'Sisir khusus bulu kucing, membantu mengurangi rontok dan menjaga bulu tetap halus.',
                'harga' => 22000,
                'stok' => 40,
                'status_ketersediaan' => 'Tersedia',
                'gambar_utama' => 'https://images.unsplash.com/photo-1518717758536-85ae29035b6d?auto=format&fit=crop&w=400&q=80',
            ],
        ];

        foreach ($produks as $produk) {
            Produk::create($produk);
        }

        // Upload gambar dari Pixabay ke Cloudinary untuk setiap produk jika gambar_utama masih kosong
        foreach (\App\Models\Produk::whereNull('gambar_utama')->orWhere('gambar_utama', '')->get() as $produk) {
            try {
                $pixabayKey = env('PIXABAY_API_KEY');
                $query = urlencode($produk->nama_produk . ' cat');
                $response = \Illuminate\Support\Facades\Http::get("https://pixabay.com/api/?key={$pixabayKey}&q={$query}&image_type=photo&per_page=3");
                $hits = $response->json('hits');
                $imageUrl = $hits[0]['webformatURL'] ?? null;
                if ($imageUrl) {
                    $upload = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::uploadApi()->upload($imageUrl, [
                        'folder' => 'petshop/produk'
                    ]);
                    $cloudinaryUrl = $upload['secure_url'] ?? null;
                    if ($cloudinaryUrl) {
                        $produk->update(['gambar_utama' => $cloudinaryUrl]);
                    }
                }
            } catch (\Exception $e) {
                echo "Gagal upload gambar untuk produk {$produk->nama_produk}: {$e->getMessage()}\n";
            }
        }
    }
}