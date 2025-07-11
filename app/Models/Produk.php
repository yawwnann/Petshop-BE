<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;
use function CloudinaryLabs\CloudinaryLaravel\cloudinary_url;

/**
 * @property int $id
 * @property int $kategori_produk_id
 * @property string $nama_produk
 * @property string $slug
 * @property string|null $deskripsi
 * @property float $harga
 * @property int $stok
 * @property string $status_ketersediaan
 * @property string|null $gambar_utama
 * @property string|null $jenis_kelamin
 * @property int|null $umur_bulan
 * @property string|null $warna
 * @property string|null $ras
 * @property string|null $merk
 * @property float|null $berat_volume
 * @property string|null $expired
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\KeranjangItem[] $keranjangItems
 */
class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks';

    protected $fillable = [
        'kategori_produk_id',
        'nama_produk',
        'slug',
        'deskripsi',
        'harga',
        'stok',
        'status_ketersediaan',
        'gambar_utama',
        'jenis_kelamin',
        'umur_bulan',
        'warna',
        'ras',
        'merk',
        'berat_volume',
        'expired',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'umur_bulan' => 'integer',
        'expired' => 'date',
    ];

    // Relasi ke KategoriProduk
    public function kategoriProduk(): BelongsTo
    {
        return $this->belongsTo(KategoriProduk::class, 'kategori_produk_id');
    }

    // Relasi untuk Pesanan (Many-to-Many) melalui tabel pivot 'item_pesanan'
    public function pesanan(): BelongsToMany
    {
        return $this->belongsToMany(Pesanan::class, 'item_pesanan', 'produk_id', 'pesanan_id')
            ->withPivot('jumlah', 'harga_saat_pesanan')
            ->withTimestamps();
    }

    // Relasi untuk Keranjang
    public function keranjangItems(): HasMany
    {
        return $this->hasMany(KeranjangItem::class, 'produk_id');
    }

    // Accessor untuk mendapatkan URL gambar utama yang sudah di-transformasi oleh Cloudinary
    public function getGambarUtamaUrlAttribute(): ?string
    {
        \Log::info('Akses accessor getGambarUtamaUrlAttribute', [
            'gambar_utama' => $this->gambar_utama,
        ]);
        if ($this->gambar_utama) {
            try {
                if (Str::startsWith($this->gambar_utama, ['http://', 'https://'])) {
                    \Log::info('Accessor: gambar_utama sudah berupa URL', [
                        'url' => $this->gambar_utama,
                    ]);
                    return $this->gambar_utama;
                }
                $url = cloudinary()->image($this->gambar_utama)
                    ->secure()
                    ->format('auto')
                    ->quality('auto')
                    ->toUrl();
                \Log::info('Accessor: URL Cloudinary berhasil dibuat', [
                    'public_id' => $this->gambar_utama,
                    'url' => $url,
                ]);
                return $url;
            } catch (\Exception $e) {
                \Log::error("Accessor: Gagal generate Cloudinary URL untuk produk ID {$this->id}, public ID: {$this->gambar_utama}. Error: " . $e->getMessage());
                return null;
            }
        }
        \Log::warning('Accessor: gambar_utama kosong');
        return null;
    }

    // Accessor untuk mendapatkan umur dalam format yang mudah dibaca
    public function getUmurFormattedAttribute(): string
    {
        if (!$this->umur_bulan) {
            return 'Tidak diketahui';
        }

        if ($this->umur_bulan < 12) {
            return "{$this->umur_bulan} bulan";
        }

        $tahun = floor($this->umur_bulan / 12);
        $bulan = $this->umur_bulan % 12;

        if ($bulan == 0) {
            return "{$tahun} tahun";
        }

        return "{$tahun} tahun {$bulan} bulan";
    }
}