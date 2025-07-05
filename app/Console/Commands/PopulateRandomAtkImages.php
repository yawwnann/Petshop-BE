<?php

namespace App\Console\Commands;

use App\Models\Atk;
use Illuminate\Console\Command;

class PopulateRandomAtkImages extends Command
{
    protected $signature = 'atk:populate-images';
    protected $description = 'Populate ATK records with random office supply images';

    public function handle()
    {
        $this->info('Populating ATK images...');

        $atkImages = [
            'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=640&h=480&fit=crop',
            'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=640&h=480&fit=crop',
            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=640&h=480&fit=crop',
            'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=640&h=480&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=640&h=480&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=640&h=480&fit=crop&auto=format',
            'https://images.unsplash.com/photo-1586953208448-b95a79798f07?w=640&h=480&fit=crop&q=80',
            'https://images.unsplash.com/photo-1513475382585-d06e58bcb0e0?w=640&h=480&fit=crop&q=80',
            'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=640&h=480&fit=crop&q=80',
        ];

        $atkRecords = Atk::whereNull('gambar_utama')->orWhere('gambar_utama', '')->get();

        foreach ($atkRecords as $atk) {
            $randomImage = $atkImages[array_rand($atkImages)];
            $atk->update(['gambar_utama' => $randomImage]);
            $this->line("Updated ATK: {$atk->nama_atk}");
        }

        $this->info('ATK images populated successfully!');
    }
}