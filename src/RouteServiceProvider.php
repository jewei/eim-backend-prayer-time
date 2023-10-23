<?php

declare(strict_types=1);

namespace App;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->routes(function () {
            Route::get(
                uri: '/',
                action: fn () => PrayerTimeService::viewAll()
            );

            Route::get(
                uri: '/subscriber/{id}',
                action: fn (int $id) => PrayerTimeService::viewSubscriber($id)
            );

            Route::fallback(
                action: fn () => response('Page not found.', 404)
            );
        });
    }
}
