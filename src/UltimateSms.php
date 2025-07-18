<?php

namespace UltimateSmsNotificationChannel;

use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class UltimateSms
{
    /**
     * Send an SMS using the Ultimate SMS API.
     *
     * @param  array<string, string|null>  $payload
     * @return array<string, mixed>
     *
     * @throws Exception
     */
    public function send(array $payload): array
    {
        $baseUrl = Config::get('ultimate_sms.base_url');
        $apiKey = Config::get('ultimate_sms.api_key');

        if (empty($baseUrl)) {
            throw new Exception('Ultimate SMS base_url is not set. Please set ULTIMATE_SMS_BASE_URL in your .env.');
        }
        if (empty($apiKey)) {
            throw new Exception('Ultimate SMS api_key is not set. Please set ULTIMATE_SMS_API_KEY in your .env.');
        }

        $request = Http::baseUrl($baseUrl)
            ->withHeaders([
                'Authorization' => 'Bearer '.$apiKey,
                'Accept' => 'application/json',
            ]);

        $response = $request->post('/api/v3/sms/send', $payload);

        if ($response->successful()) {
           return $response->json();
        }

        $errorMessage = $response->json('message');
        if (! is_string($errorMessage)) {
            $errorMessage = 'Unknown error';
        }

        throw new Exception($errorMessage);
    }
}
