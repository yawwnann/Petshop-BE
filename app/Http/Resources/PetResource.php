<?php
// File: app/Http/Resources/Api/PetResource.php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Pastikan relasi 'kategoriPet' dimuat saat resource ini digunakan
        // Misalnya: Pet::with('kategoriPet')->find($id);

        return [
            'id' => $this->id,
            'nama_pet' => $this->nama_pet,
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

            // Kolom gambar_utama akan mengembalikan URL Cloudinary yang disimpan di database
            'gambar_utama' => $this->gambar_utama,
            'gambar_utama_url' => $this->gambar_utama_url,

            'dibuat_pada' => $this->created_at->format('Y-m-d H:i:s'),
            'diupdate_pada' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}