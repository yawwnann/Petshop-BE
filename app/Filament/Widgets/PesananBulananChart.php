<?php

namespace App\Filament\Widgets;

use App\Models\Pesanan;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PesananBulananChart extends ChartWidget
{
    protected static ?string $heading = 'Total Pemasukan per Bulan (Status Selesai)';
    protected static ?int $sort = 2;

    // Properti ini akan menampung nilai filter aktif
    public ?string $filter = '12_bulan';

    protected function getFilters(): ?array
    {
        return [
            '6_bulan' => '6 Bulan Terakhir',
            '12_bulan' => '12 Bulan Terakhir',
            'tahun_ini' => 'Tahun Ini',
        ];
    }

    protected function getData(): array
    {
        // Tentukan tanggal mulai berdasarkan filter
        $startDate = match ($this->filter) {
            '6_bulan' => Carbon::now()->subMonths(5)->startOfMonth(),
            'tahun_ini' => Carbon::now()->startOfYear(),
            default => Carbon::now()->subMonths(11)->startOfMonth(), // default '12_bulan'
        };
        $endDate = Carbon::now()->endOfMonth();

        // Query data pesanan selesai per bulan
        $data = Pesanan::query()
            ->select(
                // DIUBAH: Menggunakan nama kolom yang benar
                DB::raw('YEAR(tanggal_pesanan) as year'),
                DB::raw('MONTH(tanggal_pesanan) as month'),
                DB::raw('SUM(total_harga) as aggregate')
            )
            ->where('status', 'selesai') // Pastikan status 'selesai' dalam huruf kecil
            // DIUBAH: Menggunakan nama kolom yang benar
            ->whereBetween('tanggal_pesanan', [$startDate, $endDate])
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        // Siapkan label bulan dan nilai data untuk chart
        $labels = [];
        $values = [];
        $currentDate = $startDate->copy();

        while ($currentDate <= $endDate) {
            $monthYear = $currentDate->format('M Y');
            $labels[] = $monthYear;

            $monthlyData = $data->first(function ($item) use ($currentDate) {
                return $item->year == $currentDate->year && $item->month == $currentDate->month;
            });

            $values[] = $monthlyData ? $monthlyData->aggregate : 0;

            $currentDate->addMonth();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pemasukan (Rp)',
                    'data' => $values,
                    'borderColor' => '#36A2EB',
                    'backgroundColor' => '#9BD0F5',
                    'tension' => 0.1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}