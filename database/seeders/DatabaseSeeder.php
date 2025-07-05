<?php

namespace Database\Seeders;

// Gunakan use untuk mengimpor semua model yang dibutuhkan
use App\Models\KategoriProduk;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks untuk menghindari masalah constraint
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        try {
            // 1. BUAT ROLES
            // ===========================================
            $this->command->info('Membuat Roles...');
            $adminRole = Role::firstOrCreate(
                ['slug' => 'admin'],
                ['name' => 'Admin']
            );
            // DIUBAH: Membuat role 'User' dengan slug 'user'
            $userRole = Role::firstOrCreate(
                ['slug' => 'user'],
                ['name' => 'User']
            );
            $this->command->info('Roles dibuat.');

            // 2. BUAT USER
            // ===========================================
            $this->command->info('Membuat Users...');
            // User Admin
            $adminUser = User::firstOrCreate(
                ['email' => 'admin@petshop.com'],
                [
                    'name' => 'Admin PetShop',
                    'password' => Hash::make('password'),
                ]
            );
            $adminUser->roles()->sync([$adminRole->id]); // Attach role Admin ke user Admin
            $this->command->info('User Admin dibuat dan role di-assign.');

            // User Pelanggan (sekarang dengan role 'user')
            $this->command->info('Membuat Pelanggan dan meng-assign role "User"...');
            $pelangganUsers = User::factory(10)->create();
            foreach ($pelangganUsers as $pelanggan) {
                $pelanggan->roles()->sync([$userRole->id]); // Attach role User ke user Pelanggan
            }
            $this->command->info('Pelanggan dibuat dan role "User" di-assign.');

            // 3. BUAT DATA PRODUK
            // ===========================================
            $this->command->info('Membuat Kategori dan Produks...');

            // Buat kategori terlebih dahulu
            $kategoriList = KategoriProduk::factory(6)->create();
            $this->command->info('Kategori dibuat.');

            // Buat produk dengan kategori yang sudah ada
            $produkList = collect();
            foreach ($kategoriList as $kategori) {
                $produks = Produk::factory(rand(3, 8))->create([
                    'kategori_produk_id' => $kategori->id
                ]);
                // Ambil gambar dari Pixabay dan upload ke Cloudinary
                foreach ($produks as $produk) {
                    try {
                        $pixabayKey = env('PIXABAY_API_KEY');
                        $query = urlencode($produk->nama_produk);
                        $response = Http::get("https://pixabay.com/api/?key={$pixabayKey}&q={$query}&image_type=photo&per_page=3");
                        $hits = $response->json('hits');
                        $imageUrl = $hits[0]['webformatURL'] ?? null;
                        if ($imageUrl) {
                            $upload = Cloudinary::uploadApi()->upload($imageUrl, [
                                'folder' => 'petshop/produk'
                            ]);
                            $cloudinaryUrl = $upload['secure_url'] ?? null;
                            if ($cloudinaryUrl) {
                                $produk->update(['gambar_utama' => $cloudinaryUrl]);
                            }
                        }
                    } catch (\Exception $e) {
                        $this->command->warn('Gagal upload gambar untuk produk ' . $produk->nama_produk . ': ' . $e->getMessage());
                    }
                }
                $produkList = $produkList->merge($produks);
            }
            $this->command->info('Produks dibuat dan gambar diupload.');

            // 4. BUAT DATA PESANAN (LOGIKA PALING KOMPLEKS)
            // ===========================================
            $this->command->info('Membuat Pesanan dan item-itemnya...');
            // Pastikan pesanan dibuat oleh user dengan role pelanggan (user)
            $pelangganUserIds = $pelangganUsers->pluck('id')->toArray();

            Pesanan::factory(25)->create([
                'user_id' => function () use ($pelangganUserIds) {
                    return $pelangganUserIds[array_rand($pelangganUserIds)];
                },
            ])->each(function (Pesanan $pesanan) use ($produkList) {
                // Untuk setiap pesanan, tambahkan 1 sampai 3 jenis Produk secara acak
                $itemsToAttach = $produkList->random(rand(1, 3));
                $totalHarga = 0;

                foreach ($itemsToAttach as $produk) {
                    $jumlah = rand(1, 3);
                    $hargaSaatPesan = $produk->harga;
                    $totalHarga += $jumlah * $hargaSaatPesan;

                    // Membuat item pesanan baru (bukan attach, karena relasi HasMany)
                    $pesanan->items()->create([
                        'produk_id' => $produk->id,
                        'jumlah' => $jumlah,
                        'harga_saat_pesanan' => $hargaSaatPesan,
                    ]);
                }

                // Setelah semua item ditambahkan, update total harga di pesanan utama
                $pesanan->update(['total_harga' => $totalHarga]);
            });
            $this->command->info('Pesanan dan item-itemnya dibuat.');

            $this->command->info('Database seeding selesai!');

        } catch (\Exception $e) {
            $this->command->error('Error saat seeding: ' . $e->getMessage());
            $this->command->error('Stack trace: ' . $e->getTraceAsString());
        } finally {
            // Enable foreign key checks kembali
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
