<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $nama_kategori
 * @property string $slug
 * @property string|null $deskripsi
 * @property string|null $icon
 */
class KategoriProduk extends Model
{
    use HasFactory;

    protected $table = 'kategori_produks';

    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
        'icon',
    ];

    public function produks(): HasMany
    {
        return $this->hasMany(Produk::class, 'kategori_produk_id');
    }
}