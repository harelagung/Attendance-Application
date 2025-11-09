<?php

namespace App\Providers;

use App\Models\Presensi;
use App\Observers\PresensiObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Presensi::observe(PresensiObserver::class);
    }
}
