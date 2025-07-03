<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SMS API Base URL
    |--------------------------------------------------------------------------
    |
    | This is the base URL of your Ultimate SMS provider (e.g., https://sms.example.com).
    | The package will automatically use the correct API endpoint for sending SMS.
    |
    */
    'base_url' => env('ULTIMATE_SMS_BASE_URL'),

    /*
    |--------------------------------------------------------------------------
    | API Key
    |--------------------------------------------------------------------------
    |
    | Your Ultimate SMS API key. This will be used for authenticating requests
    | to the SMS provider.
    |
    */
    'api_key' => env('ULTIMATE_SMS_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Default Sender ID
    |--------------------------------------------------------------------------
    |
    | The sender ID that will be used by default for all outgoing SMS messages.
    | You can override this per message if needed.
    |
    */
    'sender_id' => env('ULTIMATE_SMS_SENDER_ID'),

    /*
    |--------------------------------------------------------------------------
    | DLT Template ID (Optional)
    |--------------------------------------------------------------------------
    |
    | If your SMS provider requires a DLT template ID, you can set it here.
    | This is optional and can be overridden per message.
    |
    */
    'dlt_template_id' => env('ULTIMATE_SMS_DLT_TEMPLATE_ID'),
];
