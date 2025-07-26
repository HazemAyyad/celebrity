<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class CelebrityViewServiceProvider extends ServiceProvider
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

        // مشاركة المتغير مع كل الـ views
        View::composer('*', function ($view) {
            $celebrity = Auth::guard('celebrity')->user();
            $view->with('celebrity', $celebrity);
        });

    }
}
