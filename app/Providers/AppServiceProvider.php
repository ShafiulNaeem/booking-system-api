<?php

namespace App\Providers;

use App\Service\TimezoneService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TimezoneService::class, function ($app) {
            return new TimezoneService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Request $request): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()->id ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return sendError(
                        'Too Many Requests',
                        ['error' => $headers],
                        429
                    );
                });
        });
    }
}
