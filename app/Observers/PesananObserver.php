<?php

namespace App\Observers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Log;

class PesananObserver
{
    /**
     * Handle the Pesanan "created" event.
     */
    public function created(Pesanan $pesanan): void
    {
        Log::info("Pesanan baru dibuat dengan ID: {$pesanan->id}");

        // Contoh: Update stok ATK
        foreach ($pesanan->items as $atk) {
            $jumlahPesan = $atk->pivot?->jumlah ?? 0;
            if ($jumlahPesan > 0) {
                $atk->decrement('stok', $jumlahPesan);
                $namaAtk = $atk->nama_atk ?? 'Unknown';
                Log::info("Stok ATK '{$namaAtk}' dikurangi sebanyak {$jumlahPesan}");
            }
        }
    }

    /**
     * Handle the Pesanan "updated" event.
     */
    public function updated(Pesanan $pesanan): void
    {
        Log::info("Pesanan dengan ID {$pesanan->id} telah diperbarui");
    }

    /**
     * Handle the Pesanan "deleted" event.
     */
    public function deleted(Pesanan $pesanan): void
    {
        Log::info("Pesanan dengan ID {$pesanan->id} telah dihapus");

        // Kembalikan stok ATK jika pesanan dihapus
        foreach ($pesanan->items as $atk) {
            $jumlahPesan = $atk->pivot?->jumlah ?? 0;
            if ($jumlahPesan > 0) {
                $atk->increment('stok', $jumlahPesan);
                $namaAtk = $atk->nama_atk ?? 'Unknown';
                Log::info("Stok ATK '{$namaAtk}' dikembalikan sebanyak {$jumlahPesan}");
            }
        }
    }

    /**
     * Handle the Pesanan "restored" event.
     */
    public function restored(Pesanan $pesanan): void
    {
        Log::info("Pesanan dengan ID {$pesanan->id} telah dipulihkan");
    }

    /**
     * Handle the Pesanan "force deleted" event.
     */
    public function forceDeleted(Pesanan $pesanan): void
    {
        Log::info("Pesanan dengan ID {$pesanan->id} telah dihapus secara permanen");
    }
}