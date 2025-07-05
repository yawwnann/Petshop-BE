<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @mixin IdeHelperKategoriPupuk
 * @property int $id
 * @property string $nama_kategori
 * @property string $slug
 * @property string|null $deskripsi
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pupuk> $pupuk
 * @property-read int|null $pupuk_count
 * @method static \Database\Factories\KategoriPupukFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriPupuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriPupuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriPupuk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriPupuk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriPupuk whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriPupuk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriPupuk whereNamaKategori($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriPupuk whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KategoriPupuk whereUpdatedAt($value)
 */
	class KategoriPupuk extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property int $user_id
 * @property int $pupuk_id
 * @property int $quantity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pupuk $pupuk
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeranjangItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeranjangItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeranjangItem query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeranjangItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeranjangItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeranjangItem wherePupukId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeranjangItem whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeranjangItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|KeranjangItem whereUserId($value)
 */
	class KeranjangItem extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @mixin IdeHelperPesanan
 * @property int $id
 * @property int|null $user_id
 * @property string $nama_pelanggan
 * @property string $nomor_whatsapp
 * @property string $alamat_pengiriman
 * @property numeric $total_harga
 * @property string|null $metode_pembayaran
 * @property string $status_pembayaran
 * @property \Illuminate\Support\Carbon $tanggal_pesanan
 * @property string $status
 * @property string|null $nomor_resi
 * @property string|null $payment_proof_path
 * @property string|null $catatan
 * @property string|null $catatan_admin
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $formatted_status
 * @property-read string $formatted_status_pembayaran
 * @property-read string|null $payment_proof_thumbnail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pupuk> $items
 * @property-read int|null $items_count
 * @property-read \App\Models\User|null $user
 * @method static \Database\Factories\PesananFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereAlamatPengiriman($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereCatatan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereCatatanAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereMetodePembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereNamaPelanggan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereNomorResi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereNomorWhatsapp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan wherePaymentProofPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereStatusPembayaran($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereTanggalPesanan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereTotalHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pesanan whereUserId($value)
 */
	class Pesanan extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @mixin IdeHelperPupuk
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\KeranjangItem[] $keranjangItems
 * @property int $id
 * @property int $kategori_pupuk_id
 * @property string $nama_pupuk
 * @property string $slug
 * @property string|null $deskripsi
 * @property numeric $harga
 * @property int $stok
 * @property string $status_ketersediaan
 * @property string|null $gambar_utama
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string|null $gambar_utama_url
 * @property-read \App\Models\KategoriPupuk $kategoriPupuk
 * @property-read int|null $keranjang_items_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pesanan> $pesanan
 * @property-read int|null $pesanan_count
 * @method static \Database\Factories\PupukFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereDeskripsi($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereGambarUtama($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereHarga($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereKategoriPupukId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereNamaPupuk($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereStatusKetersediaan($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereStok($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pupuk whereUpdatedAt($value)
 */
	class Pupuk extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @mixin IdeHelperRole
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\KeranjangItem[] $keranjangItems
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Pesanan[] $pesanan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $profile_photo_public_id
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read string $initials
 * @property-read string $profile_photo_url
 * @property-read int|null $keranjang_items_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read int|null $pesanan_count
 * @property-read int|null $roles_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereProfilePhotoPublicId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 */
	class User extends \Eloquent implements \Tymon\JWTAuth\Contracts\JWTSubject {}
}

