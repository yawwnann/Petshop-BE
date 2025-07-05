<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $pesanan_id
 * @property int $produk_id
 * @property int $jumlah
 * @property float $harga_saat_pesanan
 * @property-read Produk $produk
 */
class ItemPesanan extends Model
{
    use HasFactory;

    protected $table = 'item_pesanan';

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'jumlah',
        'harga_saat_pesanan',
    ];

    /**
     * Mendefinisikan relasi bahwa setiap item pesanan merujuk ke satu produk.
     * @return BelongsTo
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    /**
     * Mendefinisikan relasi bahwa setiap item pesanan adalah bagian dari satu pesanan.
     * @return BelongsTo
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}