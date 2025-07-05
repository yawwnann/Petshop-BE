<?php
// File: app/Services/PesananService.php

namespace App\Services;

use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class PesananService
{
    /**
     * Membuat Pesanan baru.
     *
     * @param array $data Data pesanan dari request
     * @param ?User $user Pengguna yang membuat pesanan (opsional)
     * @return Pesanan
     * @throws Exception
     */
    public function createOrder(array $data, ?User $user = null): Pesanan
    {
        Log::debug('[PesananService] Memulai createOrder dengan data:', ['data' => $data, 'userId' => $user?->id]);
        return DB::transaction(function () use ($data, $user) {
            $itemsData = $data['items'] ?? [];
            $pesananData = Arr::except($data, ['items']); // Ambil semua data kecuali 'items'

            $pivotData = []; // Data untuk tabel pivot item_pesanan
            $calculatedBackendTotal = 0; // Total harga akan dihitung di backend
            $listOfProdukToUpdateStock = []; // Tampung produk & jumlah untuk update stok

            if (empty($itemsData)) {
                throw new Exception("Pesanan harus memiliki minimal 1 item Produk.");
            }

            // 1. Validasi & Siapkan Data Item (Ambil harga dari DB untuk akurasi)
            foreach ($itemsData as $item) {
                $jumlah = intval($item['quantity'] ?? 0);
                $produkId = $item['produk_id'] ?? null;

                if (!$produkId || $jumlah <= 0) {
                    // Log warning atau throw Exception jika item tidak valid
                    Log::warning("Skipping invalid item in order creation", $item);
                    continue;
                }

                $produk = Produk::find($produkId);
                if (!$produk) {
                    throw new Exception("Produk dengan ID {$produkId} tidak ditemukan.");
                }
                if ($produk->stok < $jumlah) {
                    throw new Exception("Stok untuk Produk '{$produk->nama_produk}' tidak mencukupi (Stok: {$produk->stok}, Dipesan: {$jumlah}).");
                }

                // Gunakan harga dari database, bukan dari frontend payload, untuk akurasi
                $hargaSaatPesanan = $produk->harga;
                $calculatedBackendTotal += $jumlah * $hargaSaatPesanan;

                // Siapkan data untuk tabel pivot
                $pivotData[$produkId] = [
                    'jumlah' => $jumlah,
                    'harga_saat_pesanan' => $hargaSaatPesanan
                ];

                // Simpan instance produk dan jumlahnya untuk pengurangan stok nanti
                $listOfProdukToUpdateStock[] = ['instance' => $produk, 'jumlah' => $jumlah];
            }

            // 2. Siapkan Data Pesanan Utama
            // Gunakan total yang dihitung di backend
            $pesananData['total_harga'] = $calculatedBackendTotal;

            // Pastikan status default jika tidak ada dari frontend
            $pesananData['status'] = $pesananData['status'] ?? 'baru';

            // Pastikan tanggal_pesanan diisi dari data request atau default
            $pesananData['tanggal_pesanan'] = $pesananData['tanggal_pesanan'] ?? now()->toDateString();

            // Assign user_id dan nama_pelanggan
            if ($user) {
                $pesananData['user_id'] = $user->id;
                $pesananData['nama_pelanggan'] = $pesananData['nama_pelanggan'] ?? $user->name;
                $pesananData['nomor_whatsapp'] = $pesananData['nomor_whatsapp'] ?? $user->phone_number; // Asumsi user punya phone_number
            } else {
                $pesananData['user_id'] = $data['user_id'] ?? null; // Jika user_id dikirim dari frontend untuk guest checkout
            }

            // Pastikan kolom lain yang diperlukan oleh model Pesanan ada di $pesananData
            $pesananData['alamat_pengiriman'] = $pesananData['alamat_pengiriman'] ?? $data['alamat_pengiriman'];
            $pesananData['catatan'] = $pesananData['catatan'] ?? ($data['catatan'] ?? null);
            $pesananData['metode_pembayaran'] = $pesananData['metode_pembayaran'] ?? 'Transfer Bank'; // Set default jika tidak ada

            // 3. Buat Record Pesanan Utama
            $pesanan = Pesanan::create($pesananData);

            // 4. Lampirkan Items ke Pesanan (Tabel Pivot) - DIPERBAIKI
            if (!empty($pivotData)) {
                // SALAH untuk HasMany:
                // $pesanan->items()->attach($pivotData);

                // BENAR untuk HasMany:
                $itemsToCreate = [];
                foreach ($pivotData as $produkId => $pivot) {
                    $itemsToCreate[] = [
                        'produk_id' => $produkId,
                        'jumlah' => $pivot['jumlah'],
                        'harga_saat_pesanan' => $pivot['harga_saat_pesanan'],
                    ];
                }
                $pesanan->items()->createMany($itemsToCreate);

                // 5. Kurangi Stok Produk (setelah createMany berhasil dan dalam transaksi)
                foreach ($listOfProdukToUpdateStock as $produkData) {
                    $produkData['instance']->decrement('stok', $produkData['jumlah']);
                }
            } else {
                $pesanan->delete();
                throw new Exception("Pesanan gagal dibuat: tidak ada item valid.");
            }

            // Load relasi items untuk response yang lengkap
            $pesanan->load('items');

            return $pesanan;
        });
    }

    /**
     * Mengupdate Pesanan.
     * Note: Penyesuaian stok saat update (kompleks) perlu diimplementasikan.
     *
     * @param Pesanan $pesanan Instance pesanan yang akan diupdate
     * @param array $data Data update
     * @return Pesanan
     * @throws Exception
     */
    public function updateOrder(Pesanan $pesanan, array $data): Pesanan
    {
        Log::debug('[PesananService] Memulai updateOrder untuk Pesanan ID: ' . $pesanan->id, ['data' => $data]);
        return DB::transaction(function () use ($pesanan, $data) {
            $itemsData = $data['items'] ?? [];
            $pesananData = Arr::except($data, ['items']);
            $pivotData = [];
            $calculatedBackendTotal = 0; // Hitung ulang total untuk update

            // TODO: Implementasi logika penyesuaian stok saat update (kompleks)
            // Ini akan melibatkan membandingkan kuantitas lama dengan kuantitas baru
            // dan menyesuaikan stok produk secara accordingly (increment/decrement)

            if (is_array($itemsData)) {
                foreach ($itemsData as $item) {
                    $jumlah = intval($item['quantity'] ?? 0);
                    $produkId = $item['produk_id'] ?? null;

                    if ($produkId && $jumlah > 0) {
                        $produk = Produk::find($produkId); // Ambil produk dari DB
                        if (!$produk) {
                            throw new Exception("Produk dengan ID {$produkId} tidak ditemukan saat update.");
                        }
                        if ($produk->stok < $jumlah) { // Basic check, but not full stock adjustment logic
                            throw new Exception("Stok Produk '{$produk->nama_produk}' tidak mencukupi untuk jumlah yang diminta saat update.");
                        }

                        $hargaSaatPesanan = $produk->harga; // Gunakan harga dari DB
                        $calculatedBackendTotal += $jumlah * $hargaSaatPesanan;

                        $pivotData[$produkId] = ['jumlah' => $jumlah, 'harga_saat_pesanan' => $hargaSaatPesanan];
                    }
                }
            }

            // Perbarui total harga berdasarkan perhitungan baru
            $pesananData['total_harga'] = $calculatedBackendTotal;

            // Pastikan user_id tidak hilang jika tidak diupdate
            $pesananData['user_id'] = $pesananData['user_id'] ?? $pesanan->user_id;

            // 1. Update Pesanan Utama
            $pesanan->update($pesananData);

            // 2. Sync Items (Tabel Pivot) - DIPERBAIKI
            // ✅ BENAR: Gunakan items() untuk sync relasi many-to-many
            $pesanan->items()->delete();
            $pesanan->items()->createMany($data); // jika ingin update semua item

            // Load relasi items untuk response yang lengkap
            $pesanan->load('items');

            return $pesanan;
        });
    }

    /**
     * Menghapus pesanan dan mengembalikan stok produk
     *
     * @param Pesanan $pesanan
     * @return bool
     */
    public function deleteOrder(Pesanan $pesanan): bool
    {
        Log::debug('[PesananService] Memulai deleteOrder untuk Pesanan ID: ' . $pesanan->id);
        return DB::transaction(function () use ($pesanan) {
            // Ambil semua item pesanan untuk mengembalikan stok
            $items = $pesanan->items;

            // Kembalikan stok untuk setiap item
            foreach ($items as $item) {
                /** @var \App\Models\ItemPesanan $item */
                $produk = $item->produk;
                $jumlah = $item->jumlah;
                if ($produk) {
                    $produk->increment('stok', $jumlah);
                    Log::info("Stok produk '{$produk->nama_produk}' dikembalikan sebanyak {$jumlah}");
                }
            }

            // Hapus pesanan (akan cascade delete items)
            $deleted = $pesanan->delete();

            if ($deleted) {
                Log::info("Pesanan ID {$pesanan->id} berhasil dihapus");
            }

            return $deleted;
        });
    }
}
