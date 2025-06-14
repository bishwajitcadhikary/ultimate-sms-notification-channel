<?php

namespace Frolax\UltimateSms;

use Frolax\UltimateSms\Channels\UltimateSmsChannel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Notification;

class UltimateSmsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/ultimate-sms.php' => config_path('ultimate-sms.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../config/ultimate-sms.php', 'ultimate-sms'
        );

        // Register the notification channel
        Notification::extend('ultimate-sms', function ($app) {
            return new UltimateSmsChannel($app->make(UltimateSms::class));
        });
    }

    public function register()
    {
        $this->app->singleton(UltimateSms::class, function ($app) {
            return new UltimateSms(
                config('ultimate-sms.api_key'),
                config('ultimate-sms.base_url', 'https://sms.test/api/v3')
            );
        });
    }
} 