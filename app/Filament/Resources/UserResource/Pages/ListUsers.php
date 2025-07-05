<?php
// File: app/Filament/Resources/UserResource/Pages/ListUsers.php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords; // <-- Perbaiki ini

// Pastikan extends ListRecords (huruf besar)
class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        // Tombol default "New User" biasanya ditambahkan otomatis oleh base class jika create page terdaftar
        // Anda bisa menambahkannya manual jika perlu:
        return [
            Actions\CreateAction::make(),
        ];
    }

    // Anda bisa override method getTableQuery(), getTableColumns(), dll di sini jika perlu kustomisasi
    // tapi untuk awal biarkan kosong agar menggunakan definisi dari UserResource
}