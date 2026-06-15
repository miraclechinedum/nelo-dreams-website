<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Some shared-hosting MySQL/MariaDB builds cap InnoDB index keys at
        // 767 / 1000 bytes. Default Laravel VARCHAR(255) + utf8mb4 = 1020 bytes,
        // which trips the "Specified key was too long" error during migrations.
        // Trimming the default string length to 191 keeps every indexed column
        // under that ceiling (191 × 4 = 764 bytes).
        Schema::defaultStringLength(191);
    }
}
