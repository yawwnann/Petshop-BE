<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->generateIndonesianName(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Generate Indonesian names
     */
    private function generateIndonesianName(): string
    {
        $namaDepanPria = [
            'Ahmad',
            'Muhammad',
            'Abdul',
            'Agus',
            'Andi',
            'Budi',
            'Dedi',
            'Eko',
            'Fajar',
            'Hadi',
            'Indra',
            'Joko',
            'Kurnia',
            'Lukman',
            'Made',
            'Nanda',
            'Oka',
            'Putu',
            'Rahmat',
            'Sigit',
            'Tono',
            'Umar',
            'Vino',
            'Wahyu',
            'Yoga',
            'Zulfi',
            'Arif',
            'Bayu',
            'Cahyo',
            'Darmawan',
            'Fauzi',
            'Gunawan',
            'Hendri',
            'Irfan',
            'Jaka',
            'Krisna',
            'Luthfi',
            'Maulana',
            'Nugroho',
            'Pandu',
            'Reza',
            'Satria',
            'Tri',
            'Yudi',
            'Zainal',
            'Bambang',
            'Didik',
            'Ferdi',
            'Gilang'
        ];

        $namaDepanWanita = [
            'Ayu',
            'Bella',
            'Citra',
            'Dewi',
            'Eka',
            'Fitri',
            'Gita',
            'Hesti',
            'Indah',
            'Juliana',
            'Kartika',
            'Lina',
            'Maya',
            'Nita',
            'Octavia',
            'Putri',
            'Ratna',
            'Sari',
            'Tuti',
            'Umi',
            'Vina',
            'Wati',
            'Yanti',
            'Zahra',
            'Ani',
            'Bunga',
            'Dian',
            'Elsa',
            'Febri',
            'Galuh',
            'Hana',
            'Ira',
            'Jihan',
            'Kirana',
            'Laila',
            'Mira',
            'Nova',
            'Olivia',
            'Prima',
            'Rina',
            'Sinta',
            'Tika',
            'Ulin',
            'Vera',
            'Wulan',
            'Yuli',
            'Zita',
            'Astri',
            'Bintang',
            'Citra'
        ];

        $namaBelakang = [
            'Santoso',
            'Wijaya',
            'Kurniawan',
            'Sari',
            'Utama',
            'Pratama',
            'Wibowo',
            'Setiawan',
            'Handayani',
            'Lestari',
            'Permana',
            'Suryani',
            'Maharani',
            'Kusuma',
            'Rahayu',
            'Nugraha',
            'Safitri',
            'Purnomo',
            'Melati',
            'Anggraini',
            'Budiman',
            'Susanto',
            'Hartono',
            'Cahyadi',
            'Firmansyah',
            'Rizkiawan',
            'Andrianto',
            'Febrianto',
            'Kurniawati',
            'Rahmawati',
            'Setiawati',
            'Nurjanah',
            'Mahmudah',
            'Sulistiowati',
            'Purwanti',
            'Susilowarni',
            'Hasanah',
            'Khoiriyah',
            'Fadhilah',
            'Syarifah',
            'Mardiyah',
            'Hidayati',
            'Amalia',
            'Fitriani',
            'Nurhasanah',
            'Sulastri',
            'Indrayani',
            'Sumarni',
            'Widodo',
            'Susilo',
            'Darmawan',
            'Hermawan',
            'Setiabudi',
            'Trianto',
            'Nugroho',
            'Kartono'
        ];

        $gelarDepan = [
            '',
            '',
            '',
            '',
            '',
            '',
            '', // Mayoritas tanpa gelar
            'Drs. ',
            'Dr. ',
            'Ir. ',
            'H. ',
            'Hj. ',
            'Prof. ',
            'Dra. ',
        ];

        $gelarBelakang = [
            '',
            '',
            '',
            '',
            '',
            '',
            '', // Mayoritas tanpa gelar
            ', S.E.',
            ', S.Kom.',
            ', S.T.',
            ', S.Pd.',
            ', S.H.',
            ', S.Ag.',
            ', M.M.',
            ', M.Pd.',
            ', M.T.',
            ', S.Si.',
            ', S.Sos.',
            ', S.Psi.',
            ', S.K.M.',
        ];

        // Tentukan gender secara random
        $isWanita = $this->faker->boolean();

        $namaDepan = $isWanita ?
            $this->faker->randomElement($namaDepanWanita) :
            $this->faker->randomElement($namaDepanPria);

        $namaBelakangTerpilih = $this->faker->randomElement($namaBelakang);
        $gelarDepanTerpilih = $this->faker->randomElement($gelarDepan);
        $gelarBelakangTerpilih = $this->faker->randomElement($gelarBelakang);

        // Kadang-kadang gunakan nama tengah
        $namaTengah = '';
        if ($this->faker->boolean(30)) { // 30% chance ada nama tengah
            $namaTengahOptions = [
                'Budi',
                'Dwi',
                'Tri',
                'Adi',
                'Putra',
                'Putri',
                'Nur',
                'Sri',
                'Siti',
                'Agung',
                'Bayu',
                'Candra',
                'Dian',
                'Eka',
                'Fajar',
                'Galih',
                'Hendra'
            ];
            $namaTengah = ' ' . $this->faker->randomElement($namaTengahOptions);
        }

        return $gelarDepanTerpilih . $namaDepan . $namaTengah . ' ' . $namaBelakangTerpilih . $gelarBelakangTerpilih;
    }
}