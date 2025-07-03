<?php

namespace UltimateSmsNotificationChannel;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\ServiceProvider;

class UltimateSmsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/ultimate_sms.php' => config_path('ultimate_sms.php'),
        ], 'config');

        Notification::extend('ultimate_sms', function ($app) {
            return new UltimateSmsChannel($app->make(UltimateSms::class));
        });
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/ultimate_sms.php', 'ultimate_sms'
        );

        // Bind the UltimateSms class to the 'ultimate_sms' key for the facade
        $this->app->singleton('ultimate_sms', function ($app) {
            return new UltimateSms();
        });
    }
}
