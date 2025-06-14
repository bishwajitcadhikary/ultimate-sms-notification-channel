<?php

namespace Frolax\UltimateSms\Channels;

use Frolax\UltimateSms\UltimateSms;
use Frolax\UltimateSms\Messages\UltimateSmsMessage;
use Illuminate\Notifications\Notification;
use BadMethodCallException;

class UltimateSmsChannel
{
    protected UltimateSms $ultimateSms;

    public function __construct(UltimateSms $ultimateSms)
    {
        $this->ultimateSms = $ultimateSms;
    }

    public function send($notifiable, Notification $notification)
    {
        $message = $this->getMessageFromNotification($notification, $notifiable);

        return $this->ultimateSms->send(
            $message->recipient,
            $message->content,
            $message->senderId,
            $message->scheduleTime
        );
    }

    protected function getMessageFromNotification(Notification $notification, $notifiable): UltimateSmsMessage
    {
        // First try the explicit toUltimateSms method
        if (method_exists($notification, 'toUltimateSms')) {
            return $notification->toUltimateSms($notifiable);
        }

        // Then try dynamic method handling
        if (method_exists($notification, '__call')) {
            try {
                $content = $notification->__call('toUltimateSms', [$notifiable]);
                
                // If the content is a string, create a message with default settings
                if (is_string($content)) {
                    return UltimateSmsMessage::create(
                        $notifiable->phone_number ?? $notifiable->phone ?? $notifiable->mobile,
                        $content
                    );
                }

                // If the content is already a message object, return it
                if ($content instanceof UltimateSmsMessage) {
                    return $content;
                }
            } catch (BadMethodCallException $e) {
                // If __call throws an exception, we'll fall through to the final error
            }
        }

        throw new BadMethodCallException(
            'Notification does not have a toUltimateSms method or __call method that can handle toUltimateSms.'
        );
    }
} 