# LESTARI-ATK2 Backend

## Dokumentasi API

### Autentikasi

#### Register

```
POST /api/register
Content-Type: application/json
{
  "name": "Nama User",
  "email": "user@email.com",
  "password": "password"
}
```

#### Login

```
POST /api/login
Content-Type: application/json
{
  "email": "user@email.com",
  "password": "password"
}
```

#### Logout

```
POST /api/logout
Authorization: Bearer {token}
```

#### Get User

```
GET /api/user
Authorization: Bearer {token}
```

---

### Katalog ATK

#### Daftar ATK

```
GET /api/atk
```

**Query:**

-   `q` (pencarian)
-   `sort` (harga, created_at, nama_atk)
-   `order` (asc, desc)
-   `status_ketersediaan` (Tersedia, Habis)
-   `kategori_slug` (slug kategori)

#### Detail ATK

```
GET /api/atk/{slug}
```

#### Daftar Kategori ATK

```
GET /api/kategori
```

---

### Keranjang

#### Lihat Keranjang

```
GET /api/keranjang
Authorization: Bearer {token}
```

#### Tambah ke Keranjang

```
POST /api/keranjang
Authorization: Bearer {token}
Content-Type: application/json
{
  "atk_id": 1,
  "quantity": 2
}
```

#### Update Item Keranjang

```
PUT /api/keranjang/{id}
Authorization: Bearer {token}
Content-Type: application/json
{
  "quantity": 3
}
```

#### Hapus Item Keranjang

```
DELETE /api/keranjang/{id}
Authorization: Bearer {token}
```

#### Kosongkan Keranjang

```
DELETE /api/keranjang/clear
Authorization: Bearer {token}
```

---

### Pesanan

#### Daftar Pesanan

```
GET /api/pesanan
Authorization: Bearer {token}
```

#### Buat Pesanan

```
POST /api/pesanan
Authorization: Bearer {token}
Content-Type: application/json
{
  "nama_pelanggan": "John Doe",
  "nomor_whatsapp": "081234567890",
  "alamat_pengiriman": "Jl. Contoh No. 123",
  "metode_pembayaran": "transfer",
  "catatan": "Tolong dibungkus rapi"
}
```

#### Detail Pesanan

```
GET /api/pesanan/{id}
Authorization: Bearer {token}
```

#### Update Pesanan

```
PUT /api/pesanan/{id}
Authorization: Bearer {token}
Content-Type: application/json
{
  "status": "dikirim",
  "nomor_resi": "JNE123456789"
}
```

#### Upload Bukti Pembayaran

```
POST /api/pesanan/{id}/submit-payment-proof
Authorization: Bearer {token}
Content-Type: multipart/form-data
payment_proof: [file]
```

---

### Contoh Response ATK

```json
{
  "data": [
    {
      "id": 1,
      "nama_atk": "Faber-Castell Pulpen Gel",
      "slug": "faber-castell-pulpen-gel",
      "deskripsi": "Pulpen berkualitas tinggi...",
      "harga": 15000.0,
      "stok": 50,
      "status_ketersediaan": "Tersedia",
      "gambar_utama": "https://images.unsplash.com/...",
      "kategori": {
        "id": 1,
        "nama_kategori": "Pulpen dan Pensil",
        "slug": "pulpen-dan-pensil"
      },
      "dibuat_pada": "2025-06-08 10:00:00",
      "diupdate_pada": "2025-06-08 10:00:00"
    }
  ],
  "links": { ... },
  "meta": { ... }
}
```

---

### Error Handling

-   401 Unauthorized
-   404 Not Found
-   422 Validation Error
-   500 Server Error

---

### Catatan

-   Semua endpoint keranjang dan pesanan membutuhkan token JWT (login dulu).
-   Untuk testing, gunakan user admin: `admin@atk.com` / `password`.
-   Lihat file `test_api.md` untuk contoh cURL/Postman lebih lanjut.
