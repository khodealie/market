<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $this->mapUserApiRoutes();
        $this->mapProductApiRoutes();
        $this->mapInvoiceApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapUserApiRoutes()
    {
        Route::middleware(['api'])
            ->prefix('api/users')
            ->group(base_path('routes/apis/userApi.php'));
    }

    protected function mapProductApiRoutes()
    {
        Route::middleware(['api', 'auth:sanctum'])
            ->prefix('api/products')
            ->group(base_path('routes/apis/productApi.php'));
    }

    protected function mapInvoiceApiRoutes()
    {
        Route::middleware(['api'])
            ->prefix('api/invoices')
            ->group(base_path('routes/apis/invoiceApi.php'));
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
