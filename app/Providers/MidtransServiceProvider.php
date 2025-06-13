<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config; // Assuming you have installed the Midtrans PHP SDK via Composer

class MidtransServiceProvider extends ServiceProvider
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
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = config('midtrans.sanitized', true);
        Config::$is3ds = config('midtrans.3ds', true);
    }
}
