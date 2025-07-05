<?php
// File: app/Filament/Resources/UserResource/Pages/EditUser.php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord; // Pastikan extends class yang benar

class EditUser extends EditRecord
{
    // Tentukan Resource yang digunakan oleh halaman ini
    protected static string $resource = UserResource::class;

    /**
     * Mendapatkan actions yang ada di header halaman (seperti tombol Delete).
     *
     * @return array<int, \Filament\Actions\Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            // Tombol Hapus standar
            Actions\DeleteAction::make(),
        ];
    }

    // Anda bisa menambahkan method lain di sini jika perlu kustomisasi lebih lanjut
    // seperti mutateFormDataBeforeSave, getRedirectUrl, dll.
    // Contoh: Redirect ke halaman index setelah save
    // protected function getRedirectUrl(): string
    // {
    //     return $this->getResource()::getUrl('index');
    // }
}