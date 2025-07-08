<?php

namespace App\Filament\Resources\KonsultasiResource\Pages;

use App\Filament\Resources\KonsultasiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKonsultasis extends ListRecords
{
    protected static string $resource = KonsultasiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
