<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- Tambahkan ini

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // PENTING: Paksa HTTPS jika di production/cloud
        if($this->app->environment('production') || $this->app->environment('local')) { // Sesuaikan environment
            URL::forceScheme('https');
        }
    }
}