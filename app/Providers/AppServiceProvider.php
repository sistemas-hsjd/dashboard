<?php

namespace App\Providers;

use App\Services\VisitCounter;
use Illuminate\Support\Facades\View;
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
        View::composer('layouts.footer', function ($view) {
            $request = request();

            if (!$request->attributes->has('portalVisitTotal')) {
                try {
                    $total = app(VisitCounter::class)->increment();
                } catch (\Throwable $exception) {
                    report($exception);
                    $total = null;
                }

                $request->attributes->set('portalVisitTotal', $total);
            }

            $view->with('visitTotal', $request->attributes->get('portalVisitTotal'));
        });
    }
}
