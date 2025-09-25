<?php

namespace App\Providers;

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
        // Add global helper for EAT timezone conversion
        if (!function_exists('toEAT')) {
            function toEAT($date, $format = 'F d, Y \a\t g:i A') {
                if (!$date) return 'Not available';
                return $date->setTimezone('Africa/Nairobi')->format($format);
            }
        }
    }
}
