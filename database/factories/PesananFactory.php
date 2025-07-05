<?php

namespace Database\Factories;

use App\Models\User; // Import model User
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PesananFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statusPembayaran = ['Belum Dibayar', 'Dibayar', 'Gagal'];
        $statusPesanan = ['Menunggu Konfirmasi', 'Diproses', 'Dikirim', 'Selesai', 'Dibatalkan'];

        return [
            // Cerdas: Pilih User acak, atau buat User baru jika belum ada
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'nama_pelanggan' => fake()->name(),
            'nomor_whatsapp' => fake()->e164PhoneNumber(),
            'alamat_pengiriman' => fake()->address(),
            'total_harga' => fake()->numberBetween(50000, 1000000),
            'metode_pembayaran' => 'Transfer Bank',
            'status_pembayaran' => fake()->randomElement($statusPembayaran),
            'tanggal_pesanan' => Carbon::today()->subDays(rand(0, 30 * 5)), // Tanggal acak dalam 5 bulan terakhir
            'status' => fake()->randomElement($statusPesanan),
            'nomor_resi' => null, // Awalnya null
            'payment_proof_path' => null, // Awalnya null
            'catatan' => fake()->optional()->sentence(),
            'catatan_admin' => null,
        ];
    }
}