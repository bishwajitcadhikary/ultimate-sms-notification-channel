<?php

namespace Frolax\UltimateSms;

use Illuminate\Support\Facades\Http;

class UltimateSms
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct(string $apiKey, string $baseUrl)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $baseUrl;
    }

    public function send(string $recipient, string $message, ?string $senderId = null, ?string $scheduleTime = null): array
    {
        $response = Http::baseUrl($this->baseUrl)
            ->withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])->post('/sms/send', [
            'recipient' => $recipient,
            'sender_id' => $senderId ?? config('ultimate-sms.default_sender_id'),
            'type' => 'plain',
            'message' => $message,
            'schedule_time' => $scheduleTime,
        ]);

        if (!$response->successful()) {
            return [
                'status' => 'error',
                'message' => $response->json()['message'] ?? 'Failed to send SMS',
            ];
        }

        return [
            'status' => 'success',
            'data' => $response->json(),
        ];
    }

    public function sendToMany(array $recipients, string $message, ?string $senderId = null, ?string $scheduleTime = null): array
    {
        return $this->send(
            implode(',', $recipients),
            $message,
            $senderId,
            $scheduleTime
        );
    }
} 