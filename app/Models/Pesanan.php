<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $user_id
 * @property string $nama_pelanggan
 * @property string $nomor_whatsapp
 * @property string $alamat_pengiriman
 * @property float $total_harga
 * @property string|null $metode_pembayaran
 * @property string|null $status_pembayaran
 * @property string $tanggal_pesanan
 * @property string $status
 * @property string|null $nomor_resi
 * @property string|null $payment_proof_path
 * @property string|null $catatan
 * @property string|null $catatan_admin
 */
class Pesanan extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terhubung dengan model ini.
     *
     * @var string
     */
    protected $table = 'pesanan';

    /**
     * Atribut yang dapat diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'nama_pelanggan',
        'nomor_whatsapp',
        'alamat_pengiriman',
        'total_harga',
        'metode_pembayaran',
        'status_pembayaran',
        'tanggal_pesanan',
        'status',
        'nomor_resi',
        'payment_proof_path',
        'catatan',
        'catatan_admin',
    ];

    /**
     * Atribut yang harus di-cast ke tipe data tertentu.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'total_harga' => 'decimal:2',
        'tanggal_pesanan' => 'date',
    ];

    /**
     * Relasi HasMany ke model ItemPesanan.
     * Satu pesanan memiliki banyak item pesanan.
     */
    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ItemPesanan::class, 'pesanan_id');
    }

    /**
     * Relasi BelongsTo ke model User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Accessor untuk mendapatkan URL thumbnail bukti pembayaran dari Cloudinary.
     */
    public function getPaymentProofThumbnailAttribute(): ?string
    {
        if ($this->payment_proof_path) {
            // Asumsi payment_proof_path adalah URL Cloudinary lengkap
            if (Str::contains($this->payment_proof_path, '/upload/')) {
                return Str::replaceFirst('/upload/', '/upload/w_80,h_80,c_thumb,q_auto,f_auto/', $this->payment_proof_path);
            }
            return $this->payment_proof_path;
        }
        return null;
    }

    /**
     * Accessor untuk mendapatkan format status pesanan yang lebih rapi.
     */
    public function getFormattedStatusAttribute(): string
    {
        return $this->status ? ucwords(str_replace('_', ' ', $this->status)) : 'N/A';
    }

    /**
     * Accessor untuk mendapatkan format status pembayaran yang lebih rapi.
     */
    public function getFormattedStatusPembayaranAttribute(): string
    {
        return $this->status_pembayaran ? ucwords(str_replace('_', ' ', $this->status_pembayaran)) : 'N/A';
    }
}