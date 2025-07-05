# Migrasi dari Toko ATK ke PetShop

## Overview

Sistem telah berhasil dimigrasi dari toko ATK menjadi PetShop dengan perubahan struktur database, model, controller, dan API endpoints.

## Perubahan Utama

### 1. Model Baru

-   **Pet** (menggantikan Atk)
    -   Field tambahan: `jenis_kelamin`, `umur_bulan`, `warna`, `ras`
    -   Accessor: `umur_formatted` untuk format umur yang mudah dibaca
-   **KategoriPet** (menggantikan KategoriAtk)
    -   Field tambahan: `icon` untuk emoji kategori

### 2. Database Migration

-   `2025_01_15_000001_create_kategori_pets_table.php`
-   `2025_01_15_000002_create_pets_table.php`
-   `2025_01_15_000003_update_keranjang_items_table.php`
-   `2025_01_15_000004_update_item_pesanan_table.php`
-   `2025_01_15_000005_drop_old_tables.php`

### 3. API Endpoints Baru

-   `GET /api/pets` - Daftar semua pets
-   `GET /api/pets/{pet:slug}` - Detail pet berdasarkan slug
-   `GET /api/kategori` - Daftar kategori pets

### 4. Controller Baru

-   **PetController** dengan fitur filter tambahan:
    -   Filter berdasarkan jenis kelamin
    -   Filter berdasarkan umur (min/max)
    -   Pencarian berdasarkan ras dan warna

### 5. Resource Baru

-   **PetResource** dengan field tambahan untuk petshop

## Data Sample

Sistem dilengkapi dengan data sample petshop yang mencakup:

-   6 kategori: Kucing, Anjing, Kelinci, Hamster, Burung, Ikan
-   9 pets dengan detail lengkap (jenis kelamin, umur, warna, ras)

## Cara Menjalankan

### 1. Setup Database

```bash
# Jalankan migration dan seeder
php artisan migrate:fresh --seed

# Atau gunakan script batch
setup_petshop.bat
```

### 2. Test API

```bash
# Daftar pets
GET http://localhost:8000/api/pets

# Detail pet
GET http://localhost:8000/api/pets/kucing-persia-putih

# Kategori
GET http://localhost:8000/api/kategori

# Filter pets
GET http://localhost:8000/api/pets?jenis_kelamin=Jantan&umur_min=6&umur_max=12
```

## Fitur Baru untuk PetShop

### 1. Filter Lanjutan

-   Filter berdasarkan jenis kelamin (Jantan/Betina)
-   Filter berdasarkan umur (bulan)
-   Filter berdasarkan kategori
-   Pencarian berdasarkan nama, deskripsi, ras, warna

### 2. Informasi Pet Lengkap

-   Jenis kelamin
-   Umur dalam bulan (dengan format yang mudah dibaca)
-   Warna
-   Ras
-   Status ketersediaan

### 3. Kategori dengan Icon

-   Setiap kategori memiliki icon emoji
-   Deskripsi kategori yang informatif

## Struktur Database Baru

### Tabel `pets`

```sql
- id (primary key)
- kategori_pet_id (foreign key)
- nama_pet
- slug (unique)
- deskripsi
- harga
- stok
- status_ketersediaan
- gambar_utama
- jenis_kelamin (enum: Jantan, Betina)
- umur_bulan
- warna
- ras
- created_at, updated_at
```

### Tabel `kategori_pets`

```sql
- id (primary key)
- nama_kategori
- slug (unique)
- deskripsi
- icon
- created_at, updated_at
```

## Migration Path

1. Buat tabel baru (kategori_pets, pets)
2. Update tabel existing (keranjang_items, item_pesanan)
3. Drop tabel lama (atk, kategori_atk)

## Notes

-   Semua relasi telah diupdate untuk menggunakan `pet_id` alih-alih `atk_id`
-   Factory dan Seeder telah dibuat untuk data testing
-   API endpoints tetap konsisten dengan pola RESTful
-   Backward compatibility tidak tersedia (perlu update frontend)
