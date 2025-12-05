<?php

namespace App\Providers;

use App\Mail\UseSendTransport;
use Illuminate\Support\Facades\Mail;
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
        Mail::extend('usesend', function (array $config) {
            return new UseSendTransport($config['api_key']);
        });
    }
}
