<?php
// File: app/Filament/Resources/UserResource/Pages/CreateUser.php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord; // <-- Perbaiki ini

// Pastikan extends CreateRecord (huruf besar)
class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // Redirect ke halaman index setelah create (opsional)
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}