<?php

return [
    'base_url' => env('ULTIMATE_SMS_BASE_URL', 'https://sms.frolax.net'),
    'api_key' => env('ULTIMATE_SMS_API_KEY'),
    'sender_id' => env('ULTIMATE_SMS_SENDER_ID'),
    'dlt_template_id' => env('ULTIMATE_SMS_DLT_TEMPLATE_ID'), // optional
];
