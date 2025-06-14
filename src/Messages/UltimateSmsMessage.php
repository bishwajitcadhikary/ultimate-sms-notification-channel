<?php

namespace Frolax\UltimateSms\Messages;

class UltimateSmsMessage
{
    public string $recipient;
    public string $content;
    public ?string $senderId;
    public ?string $scheduleTime;

    public function __construct(string $recipient, string $content, ?string $senderId = null, ?string $scheduleTime = null)
    {
        $this->recipient = $recipient;
        $this->content = $content;
        $this->senderId = $senderId;
        $this->scheduleTime = $scheduleTime;
    }

    public static function create(string $recipient, string $content, ?string $senderId = null, ?string $scheduleTime = null): self
    {
        return new static($recipient, $content, $senderId, $scheduleTime);
    }

    public function toArray(): array
    {
        return [
            'recipient' => $this->recipient,
            'sender_id' => $this->senderId,
            'type' => 'plain',
            'message' => $this->content,
            'schedule_time' => $this->scheduleTime,
        ];
    }
} 