# Migrasi dari Sistem Pupuk ke Sistem ATK

## Ringkasan Perubahan

Sistem telah berhasil dimigrasikan dari manajemen pupuk menjadi manajemen ATK (Alat Tulis Kerja). Berikut adalah daftar lengkap perubahan yang telah dilakukan:

## 1. Model Baru

### Model ATK

-   **File**: `app/Models/Atk.php`
-   **Tabel**: `atk`
-   **Relasi**:
    -   `belongsTo(KategoriAtk::class)`
    -   `belongsToMany(Pesanan::class)` melalui `item_pesanan`
    -   `hasMany(KeranjangItem::class)`

### Model Kategori ATK

-   **File**: `app/Models/KategoriAtk.php`
-   **Tabel**: `kategori_atk`
-   **Relasi**: `hasMany(Atk::class)`

## 2. Migration Baru

### Tabel ATK

-   **File**: `database/migrations/2025_06_08_093558_create_atk_table.php`
-   **Kolom**: `id`, `kategori_atk_id`, `nama_atk`, `slug`, `deskripsi`, `harga`, `stok`, `status_ketersediaan`, `gambar_utama`

### Tabel Kategori ATK

-   **File**: `database/migrations/2025_06_08_093542_create_kategori_atk_table.php`
-   **Kolom**: `id`, `nama_kategori`, `slug`, `deskripsi`

### Migration Perubahan Kolom

-   **File**: `database/migrations/2025_06_08_104240_change_pupuk_id_to_atk_id_in_item_pesanan_table.php`
-   **File**: `database/migrations/2025_06_08_104241_change_pupuk_id_to_atk_id_in_keranjang_items_table.php`

## 3. Controller Baru

### AtkController

-   **File**: `app/Http/Controllers/Api/AtkController.php`
-   **Endpoint**:
    -   `GET /api/atk` - Daftar ATK
    -   `GET /api/atk/{atk:slug}` - Detail ATK
    -   `GET /api/kategori` - Daftar kategori ATK

## 4. Resource API Baru

### AtkResource

-   **File**: `app/Http/Resources/AtkResource.php`
-   **Format**: JSON response untuk data ATK

## 5. Factory Baru

### AtkFactory

-   **File**: `database/factories/AtkFactory.php`
-   **Data**: Nama ATK realistis, deskripsi, harga, stok, gambar

### KategoriAtkFactory

-   **File**: `database/factories/KategoriAtkFactory.php`
-   **Data**: Kategori ATK seperti "Pulpen dan Pensil", "Kertas dan Buku", dll.

## 6. Filament Resources Baru

### AtkResource

-   **File**: `app/Filament/Resources/AtkResource.php`
-   **Halaman**: List, Create, Edit ATK
-   **Fitur**: Upload gambar ke Cloudinary, validasi, filter

### KategoriAtkResource

-   **File**: `app/Filament/Resources/KategoriAtkResource.php`
-   **Halaman**: List, Create, Edit kategori ATK

## 7. Widget Baru

### AtkPopulerChart

-   **File**: `app/Filament/Widgets/AtkPopulerChart.php`
-   **Fungsi**: Menampilkan chart ATK paling laris

## 8. Command Baru

### PopulateRandomAtkImages

-   **File**: `app/Console/Commands/PopulateRandomAtkImages.php`
-   **Command**: `php artisan atk:populate-images`
-   **Fungsi**: Mengisi gambar ATK dengan gambar office supplies

## 9. Model yang Diupdate

### Pesanan

-   **Relasi**: `belongsToMany(Atk::class)` melalui `item_pesanan`

### KeranjangItem

-   **Relasi**: `belongsTo(Atk::class)`
-   **Kolom**: `atk_id` (sebelumnya `pupuk_id`)

### User

-   **Relasi**: `hasMany(KeranjangItem::class)` (tidak berubah)

## 10. Routes yang Diupdate

### API Routes

-   **File**: `routes/api.php`
-   **Perubahan**:
    -   `/api/pupuk` → `/api/atk`
    -   `/api/pupuk/{pupuk:slug}` → `/api/atk/{atk:slug}`
    -   Controller: `PupukController` → `AtkController`

## 11. Database Seeder yang Diupdate

### DatabaseSeeder

-   **File**: `database/seeders/DatabaseSeeder.php`
-   **Perubahan**:
    -   `KategoriPupuk::factory()` → `KategoriAtk::factory()`
    -   `Pupuk::factory()` → `Atk::factory()`
    -   Email admin: `admin@pupuk.com` → `admin@atk.com`

## 12. Resource yang Diupdate

### KeranjangItemResource

-   **File**: `app/Http/Resources/KeranjangItemResource.php`
-   **Perubahan**: `PupukResource` → `AtkResource`

## Cara Menjalankan Migrasi

1. **Jalankan Migration**:

    ```bash
    php artisan migrate
    ```

2. **Seed Database**:

    ```bash
    php artisan db:seed
    ```

3. **Populate Gambar ATK** (opsional):
    ```bash
    php artisan atk:populate-images
    ```

## Endpoint API Baru

### Publik

-   `GET /api/atk` - Daftar ATK dengan filter dan pencarian
-   `GET /api/atk/{atk:slug}` - Detail ATK berdasarkan slug
-   `GET /api/kategori` - Daftar kategori ATK

### Dengan Autentikasi

-   Semua endpoint keranjang dan pesanan tetap sama, hanya data yang berubah dari pupuk ke ATK

## Catatan Penting

1. **Data Lama**: Data pupuk lama akan hilang setelah migrasi
2. **Gambar**: Gambar ATK menggunakan Unsplash office supplies
3. **Harga**: Range harga disesuaikan untuk ATK (Rp 5.000 - Rp 150.000)
4. **Stok**: Range stok disesuaikan untuk ATK (10 - 500 unit)
5. **Kategori**: Kategori disesuaikan untuk ATK (Pulpen, Kertas, dll.)

## Testing

Setelah migrasi, pastikan untuk test:

1. API endpoint ATK berfungsi
2. Filament admin panel dapat mengelola ATK
3. Keranjang belanja berfungsi dengan ATK
4. Sistem pesanan berfungsi dengan ATK
5. Widget dashboard menampilkan data ATK
