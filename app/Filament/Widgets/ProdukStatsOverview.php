<?php

namespace App\Filament\Widgets;

use App\Models\Produk;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProdukStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalProduk = Produk::count();
        $produkTersedia = Produk::where('status_ketersediaan', 'Tersedia')->count();
        $produkHabis = Produk::where('status_ketersediaan', 'Habis')->count();
        $produkExpired = Produk::whereNotNull('expired')->whereDate('expired', '<', now())->count();

        return [
            Stat::make('Total Produk', $totalProduk)
                ->description('Semua produk di katalog')
                ->descriptionIcon('heroicon-m-cube')
                ->color('primary'),

            Stat::make('Produk Tersedia', $produkTersedia)
                ->description('Produk yang tersedia')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Produk Habis', $produkHabis)
                ->description('Produk yang stoknya habis')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make('Produk Expired', $produkExpired)
                ->description('Produk yang sudah expired')
                ->descriptionIcon('heroicon-m-exclamation-triangle')
                ->color('warning'),
        ];
    }
}