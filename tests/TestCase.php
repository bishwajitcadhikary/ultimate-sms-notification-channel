<?php

namespace Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use UltimateSmsNotificationChannel\UltimateSmsServiceProvider;

abstract class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app): array
    {
        return [UltimateSmsServiceProvider::class];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('ultimate_sms.base_url', 'https://sms.frolax.net');
        $app['config']->set('ultimate_sms.api_key', 'test_api_key');
        $app['config']->set('ultimate_sms.sender_id', 'TestSender');
    }
}
