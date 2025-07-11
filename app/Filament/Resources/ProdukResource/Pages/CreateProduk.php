<?php

namespace App\Filament\Resources\ProdukResource\Pages;

use App\Filament\Resources\ProdukResource;
use Filament\Resources\Pages\CreateRecord;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Log;

class CreateProduk extends CreateRecord
{
    protected static string $resource = ProdukResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!isset($data['gambar_utama']) || !$data['gambar_utama']) {
            \Log::warning('Field gambar_utama kosong saat create produk', $data);
            return $data;
        }
        if ($data['gambar_utama'] instanceof \Illuminate\Http\UploadedFile) {
            $uploadedFile = $data['gambar_utama'];
            \Log::info('MULAI upload gambar ke Cloudinary', [
                'original_name' => $uploadedFile->getClientOriginalName(),
                'size' => $uploadedFile->getSize(),
                'mime' => $uploadedFile->getMimeType(),
            ]);
            try {
                $cloudinaryUpload = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::upload($uploadedFile->getRealPath(), [
                    'folder' => 'produk',
                    'resource_type' => 'image',
                ]);
                \Log::info('HASIL upload ke Cloudinary', ['result' => $cloudinaryUpload]);
                $data['gambar_utama'] = $cloudinaryUpload->getPublicId();
                if (!$data['gambar_utama']) {
                    \Log::error('Upload ke Cloudinary sukses tapi public_id kosong', ['cloudinaryUpload' => $cloudinaryUpload]);
                } else {
                    \Log::info('Gambar produk BERHASIL di-upload ke Cloudinary', [
                        'public_id' => $data['gambar_utama'],
                        'original_name' => $uploadedFile->getClientOriginalName(),
                    ]);
                }
            } catch (\Exception $e) {
                \Log::error('GAGAL upload gambar ke Cloudinary', [
                    'error' => $e->getMessage(),
                    'original_name' => $uploadedFile->getClientOriginalName(),
                ]);
            }
        } else {
            \Log::warning('Field gambar_utama bukan UploadedFile saat create produk', [
                'type' => gettype($data['gambar_utama']),
                'value' => $data['gambar_utama'],
            ]);
        }
        return $data;
    }
}