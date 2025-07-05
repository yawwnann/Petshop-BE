<?php
// File: app/Http/Resources/ProdukResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProdukResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Pastikan relasi 'kategoriProduk' dimuat saat resource ini digunakan
        // Misalnya: Produk::with('kategoriProduk')->find($id);

        return [
            'id' => $this->id,
            'nama_produk' => $this->nama_produk,
            'slug' => $this->slug,
            'deskripsi' => $this->deskripsi,
            'harga' => (float) $this->harga,
            'stok' => (int) $this->stok,
            'status_ketersediaan' => $this->status_ketersediaan,
            'jenis_kelamin' => $this->jenis_kelamin,
            'umur_bulan' => $this->umur_bulan,
            'umur_formatted' => $this->umur_formatted,
            'warna' => $this->warna,
            'ras' => $this->ras,
            'gambar_utama' => $this->gambar_utama,
            'gambar_utama_url' => $this->gambar_utama_url,
            'kategori' => $this->kategoriProduk ? [
                'id' => $this->kategoriProduk->id,
                'nama_kategori' => $this->kategoriProduk->nama_kategori,
                'slug' => $this->kategoriProduk->slug,
            ] : null,
            'dibuat_pada' => $this->created_at->format('Y-m-d H:i:s'),
            'diupdate_pada' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}