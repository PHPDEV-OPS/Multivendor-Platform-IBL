<?php

namespace App\Providers;

use App\Http\Middleware\CheckAnyRole;
use App\Http\Middleware\CheckRole;
use App\Http\Middleware\CheckVendorVerification;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $router = $this->app['router'];

        $router->aliasMiddleware('role', CheckRole::class);
        $router->aliasMiddleware('any.role', CheckAnyRole::class);
        $router->aliasMiddleware('vendor.verified', CheckVendorVerification::class);
        $router->aliasMiddleware('redirect.if.authenticated', RedirectIfAuthenticated::class);
    }
}
