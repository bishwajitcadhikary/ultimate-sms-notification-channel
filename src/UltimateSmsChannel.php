<?php

namespace UltimateSmsNotificationChannel;

use Exception;
use Illuminate\Notifications\Notification;

class UltimateSmsChannel
{
    protected UltimateSms $sms;

    public function __construct(UltimateSms $sms)
    {
        $this->sms = $sms;
    }

    /**
     * Send the given notification.
     *
     * @return array<string, mixed>|null
     *
     * @throws Exception
     */
    public function send(object $notifiable, Notification $notification): ?array
    {
        if (! method_exists($notification, 'toUltimateSms')) {
            return [];
        }

        $message = $notification->toUltimateSms($notifiable);
        if (is_string($message)) {
            $recipient = method_exists($notifiable, 'routeNotificationFor')
                ? $notifiable->routeNotificationFor('ultimate_sms', $notification)
                : null;
            $recipient = is_string($recipient) ? $recipient : '';
            $message = UltimateSmsMessage::create($message)->to($recipient);
        }

        if ($message instanceof UltimateSmsMessage) {
            if (empty($message->recipient)) {
                $recipient = method_exists($notifiable, 'routeNotificationFor')
                    ? $notifiable->routeNotificationFor('ultimate_sms', $notification)
                    : null;
                if (is_string($recipient) && $recipient !== '') {
                    $message->to($recipient);
                }
            }
            $payload = $message->toArray();

            return $this->sms->send($payload);
        }

        return null;
    }
}
