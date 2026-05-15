<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

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
        View::composer('*', function ($view) {
            $userRole = 'admin'; // default
            
            if (Auth::guard('admin')->check()) {
                $userRole = 'admin';
            } elseif (Auth::guard('guru')->check()) {
                $userRole = 'guru';
            } elseif (Auth::guard('siswa')->check()) {
                $userRole = 'siswa';
            }
            
            $view->with('userRole', $userRole);
        });
    }
}
