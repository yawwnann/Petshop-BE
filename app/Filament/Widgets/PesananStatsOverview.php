<?php
// File: app/Filament/Widgets/PesananStatsOverview.php

namespace App\Filament\Widgets; // Pastikan namespace benar

use App\Models\Pesanan; // Import model Pesanan
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number; // Untuk format angka (jika pakai Laravel 10+)

class PesananStatsOverview extends BaseWidget
{
    // Atur urutan tampil widget (angka kecil tampil lebih atas)
    protected static ?int $sort = 1; // Buat agar tampil sebelum chart

    /**
     * Get the statistics data for the widget.
     *
     * @return array<int, Stat>
     */
    protected function getStats(): array
    {
        // Ambil data jumlah pesanan per status
        $statusCounts = Pesanan::query()
            ->selectRaw("status, count(*) as count")
            ->groupBy('status')
            ->pluck('count', 'status'); // Hasil: ['Baru' => 5, 'Diproses' => 2, ...]

        // Ambil data total pemasukan dari status 'Selesai'
        $totalPemasukan = Pesanan::query()
            ->where('status', 'Selesai')
            ->sum('total_harga');

        // Kembalikan array berisi objek Stat
        return [
            Stat::make('Total Pemasukan (Selesai)', 'Rp ' . number_format($totalPemasukan ?? 0, 0, ',', '.')) // Format angka
                ->description('Dari pesanan yang sudah selesai')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Pesanan Baru', $statusCounts['Baru'] ?? 0)
                ->description('Pesanan belum diproses')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('warning'),

            Stat::make('Pesanan Diproses', $statusCounts['Diproses'] ?? 0)
                ->description('Pesanan sedang disiapkan')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('primary'),

            Stat::make('Pesanan Dikirim', $statusCounts['Dikirim'] ?? 0)
                ->description('Pesanan dalam pengiriman')
                ->descriptionIcon('heroicon-m-truck')
                ->color('info'),

            Stat::make('Pesanan Selesai', $statusCounts['Selesai'] ?? 0)
                ->description('Total pesanan selesai')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Pesanan Batal', $statusCounts['Batal'] ?? 0)
                ->description('Pesanan yang dibatalkan')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}