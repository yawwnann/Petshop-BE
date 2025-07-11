<?php

namespace App\Filament\Resources\ProdukResource\Pages;

use App\Filament\Resources\ProdukResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions\CreateAction;
use App\Filament\Widgets\ProdukStatsOverview;

class ListProduks extends ListRecords
{
    protected static string $resource = ProdukResource::class;

    public function getHeaderWidgets(): array
    {
        return [
            ProdukStatsOverview::class,
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}