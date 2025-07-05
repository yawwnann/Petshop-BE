<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

// --- IMPORT SEMUA MODEL & OBSERVER YANG DIGUNAKAN ---
use App\Models\Pesanan;
use App\Observers\PesananObserver;

// Jika Anda punya observer lain, import di sini. Contoh:
// use App\Models\KategoriPupuk;
// use App\Observers\KategoriPupukObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        //
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Daftarkan semua model observer Anda di sini.
        // Ini adalah cara yang direkomendasikan.
        Pesanan::observe(PesananObserver::class);

        // JIKA ANDA PUNYA OBSERVER LAIN, DAFTARKAN JUGA DI SINI. CONTOH:
        // KategoriPupuk::observe(KategoriPupukObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}