<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // Memastikan pustaka Paginator terpanggil

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
        /**
         * Menginstruksikan Laravel untuk menggunakan styling Tailwind
         * pada komponen pagination, sesuai dengan kemegahan antarmuka Paduka.
         */
        Paginator::useTailwind();
    }
}
