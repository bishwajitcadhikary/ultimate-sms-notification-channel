<?php

return [
    /*
    |--------------------------------------------------------------------------
    | UltimateSms API Key
    |--------------------------------------------------------------------------
    |
    | This is the API key that you can find in your UltimateSms dashboard.
    |
    */
    'api_key' => env('ULTIMATE_SMS_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | UltimateSms Base URL
    |--------------------------------------------------------------------------
    |
    | This is the base URL for the UltimateSms API.
    |
    */
    'base_url' => env('ULTIMATE_SMS_BASE_URL', 'https://sms.test/api/v3'),

    /*
    |--------------------------------------------------------------------------
    | Default Sender ID
    |--------------------------------------------------------------------------
    |
    | This is the default sender ID that will be used if none is specified.
    |
    */
    'default_sender_id' => env('ULTIMATE_SMS_DEFAULT_SENDER_ID', 'YourName'),
]; 