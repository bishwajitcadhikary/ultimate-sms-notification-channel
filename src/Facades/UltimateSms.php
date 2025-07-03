<?php

namespace UltimateSmsNotificationChannel\Facades;

use Illuminate\Support\Facades\Facade;

class UltimateSms extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'ultimate_sms';
    }
}
