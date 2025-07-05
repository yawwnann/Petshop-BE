<?php
// File: app/Filament/Resources/PesananResource/Pages/EditPesanan.php

namespace App\Filament\Resources\PesananResource\Pages;

use App\Filament\Resources\PesananResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Filament\Notifications\Notification;

class EditPesanan extends EditRecord
{
    protected static string $resource = PesananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        /** @var \App\Models\Pesanan $pesananRecord */
        $pesananRecord = $this->getRecord();
        $pesananRecord->loadMissing('items');

        $itemsDataFormatted = [];
        if ($pesananRecord->relationLoaded('items') && $pesananRecord->items->isNotEmpty()) {
            foreach ($pesananRecord->items as $itemPesanan) {
                $itemsDataFormatted[] = [
                    'produk_id' => $itemPesanan->getAttribute('produk_id'),
                    'jumlah' => $itemPesanan->getAttribute('jumlah'),
                    'harga_saat_pesanan' => $itemPesanan->getAttribute('harga_saat_pesanan'),
                ];
            }
        }
        $data['items'] = $itemsDataFormatted;

        $total = 0;
        foreach ($itemsDataFormatted as $item) {
            $jumlah = $item['jumlah'] ?? 0;
            $harga = $item['harga_saat_pesanan'] ?? 0;
            if (is_numeric($jumlah) && is_numeric($harga)) {
                $total += $jumlah * $harga;
            }
        }
        $data['total_harga'] = $total;

        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        return DB::transaction(function () use ($record, $data) {
            /** @var \App\Models\Pesanan $record */
            $itemsDataFromForm = $data['items'] ?? [];
            $pesananDataToUpdate = Arr::except($data, ['items']);

            $calculatedTotal = 0;
            $pivotDataForSync = [];
            if (is_array($itemsDataFromForm)) {
                foreach ($itemsDataFromForm as $item) {
                    // GUNAKAN 'produk_id'
                    $produkId = $item['produk_id'] ?? null;
                    $jumlah = $item['jumlah'] ?? 0;
                    $harga = $item['harga_saat_pesanan'] ?? 0;

                    if ($produkId && is_numeric($jumlah) && $jumlah > 0 && is_numeric($harga)) {
                        $calculatedTotal += $jumlah * $harga;
                        $pivotDataForSync[$produkId] = [
                            'jumlah' => $jumlah,
                            'harga_saat_pesanan' => $harga,
                        ];
                    }
                }
            }
            $pesananDataToUpdate['total_harga'] = $calculatedTotal;

            $record->fill($pesananDataToUpdate);
            $record->save();

            // Hitung ulang total_harga
            if (!empty($data['items'])) {
                $record->items()->delete();
                $record->items()->createMany($data['items']);
                $totalHarga = collect($data['items'])->sum(function ($item) {
                    return ($item['jumlah'] ?? 0) * ($item['harga_saat_pesanan'] ?? 0);
                });
            } else {
                // Jika items tidak dikirim, hitung dari relasi
                $totalHarga = collect($record->items)->sum(function ($item) {
                    return ($item->getAttribute('jumlah') ?? 0) * ($item->getAttribute('harga_saat_pesanan') ?? 0);
                });
            }
            $record->total_harga = $totalHarga;
            $record->save();

            Notification::make()
                ->title('Pesanan berhasil diperbarui')
                ->success()
                ->send();

            return $record;
        });
    }
}
