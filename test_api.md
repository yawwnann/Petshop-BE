# Testing API ATK

## Endpoint Publik

### 1. Daftar ATK

```bash
GET /api/atk
```

**Parameter Query:**

-   `q` - Pencarian (nama ATK atau deskripsi)
-   `sort` - Pengurutan (harga, created_at, nama_atk)
-   `order` - Urutan (asc, desc)
-   `status_ketersediaan` - Filter status (Tersedia, Habis)
-   `kategori_slug` - Filter kategori berdasarkan slug

**Contoh:**

```bash
curl "http://localhost:8000/api/atk?q=pulpen&sort=harga&order=asc"
```

### 2. Detail ATK

```bash
GET /api/atk/{slug}
```

**Contoh:**

```bash
curl "http://localhost:8000/api/atk/faber-castell-pulpen-gel"
```

### 3. Daftar Kategori

```bash
GET /api/kategori
```

**Contoh:**

```bash
curl "http://localhost:8000/api/kategori"
```

## Endpoint dengan Autentikasi

### 1. Login

```bash
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password"
}
```

### 2. Keranjang Belanja

#### Daftar Keranjang

```bash
GET /api/keranjang
Authorization: Bearer {token}
```

#### Tambah ke Keranjang

```bash
POST /api/keranjang
Authorization: Bearer {token}
Content-Type: application/json

{
    "atk_id": 1,
    "quantity": 2
}
```

#### Update Keranjang

```bash
PUT /api/keranjang/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "quantity": 3
}
```

#### Hapus dari Keranjang

```bash
DELETE /api/keranjang/{id}
Authorization: Bearer {token}
```

#### Kosongkan Keranjang

```bash
DELETE /api/keranjang/clear
Authorization: Bearer {token}
```

### 3. Pesanan

#### Daftar Pesanan

```bash
GET /api/pesanan
Authorization: Bearer {token}
```

#### Buat Pesanan

```bash
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

```bash
GET /api/pesanan/{id}
Authorization: Bearer {token}
```

#### Update Pesanan

```bash
PUT /api/pesanan/{id}
Authorization: Bearer {token}
Content-Type: application/json

{
    "status": "dikirim",
    "nomor_resi": "JNE123456789"
}
```

#### Upload Bukti Pembayaran

```bash
POST /api/pesanan/{id}/submit-payment-proof
Authorization: Bearer {token}
Content-Type: multipart/form-data

payment_proof: [file]
```

## Contoh Response

### Daftar ATK

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
    "links": {
        "first": "http://localhost:8000/api/atk?page=1",
        "last": "http://localhost:8000/api/atk?page=3",
        "prev": null,
        "next": "http://localhost:8000/api/atk?page=2"
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 3,
        "per_page": 12,
        "to": 12,
        "total": 30
    }
}
```

### Detail ATK

```json
{
    "data": {
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
}
```

## Testing dengan Postman

1. **Import Collection**: Buat collection baru di Postman
2. **Set Base URL**: `http://localhost:8000/api`
3. **Test Endpoint Publik**: Daftar ATK, Detail ATK, Kategori
4. **Login**: Dapatkan token JWT
5. **Set Authorization**: Bearer token untuk endpoint yang memerlukan auth
6. **Test Endpoint Auth**: Keranjang, Pesanan

## Testing dengan cURL

### Test Daftar ATK

```bash
curl -X GET "http://localhost:8000/api/atk" \
  -H "Accept: application/json"
```

### Test Login

```bash
curl -X POST "http://localhost:8000/api/login" \
  -H "Content-Type: application/json" \
  -H "Accept: application/json" \
  -d '{
    "email": "admin@atk.com",
    "password": "password"
  }'
```

### Test Keranjang (dengan token)

```bash
curl -X GET "http://localhost:8000/api/keranjang" \
  -H "Authorization: Bearer YOUR_TOKEN_HERE" \
  -H "Accept: application/json"
```

## Error Handling

### 404 - Not Found

```json
{
    "message": "ATK tidak ditemukan."
}
```

### 422 - Validation Error

```json
{
    "message": "Data tidak valid.",
    "errors": {
        "atk_id": ["ATK tidak ditemukan."],
        "quantity": ["Jumlah harus minimal 1."]
    }
}
```

### 401 - Unauthorized

```json
{
    "message": "Unauthorized"
}
```

### 500 - Server Error

```json
{
    "message": "Terjadi kesalahan saat menambahkan item ke keranjang.",
    "error": "Internal server error"
}
```
