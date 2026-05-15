<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Share $userRole to all views
        View::composer('*', function ($view) {
            $userRole = 'admin';
            if (Auth::guard('guru')->check()) {
                $userRole = 'guru';
            }
            $view->with('userRole', $userRole);
        });
    }
}
