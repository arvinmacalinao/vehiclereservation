<?php

namespace App\Providers;

use View;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
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
        View::composer('layouts.navbars.nav', function ($view) {
            $user = Auth::user()->u_id;
            
            $notifications = Notification::where('u_id', $user)
                ->orderBy('created_at', 'desc')
                ->get();
            $view->with('notifications', $notifications);
        });
    }
}
