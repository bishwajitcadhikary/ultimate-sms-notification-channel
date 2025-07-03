<?php

namespace UltimateSmsNotificationChannel;

use Illuminate\Support\Facades\Config;

class UltimateSmsMessage
{
    public ?string $recipient = null;

    public ?string $message = null;

    public ?string $sender_id = null;

    public string $type = 'plain';

    public ?string $schedule_time = null;

    public ?string $dlt_template_id = null;

    /**
     * Create a new UltimateSmsMessage instance.
     */
    public static function create(?string $message = null): static
    {
        $instance = new static;
        if ($message !== null) {
            $instance->message($message);
        }

        return $instance;
    }

    /**
     * Set the recipient for the SMS message.
     *
     * @return $this
     */
    public function to(string $recipient): static
    {
        $this->recipient = $recipient;

        return $this;
    }

    /**
     * Set the message content for the SMS.
     *
     * @return $this
     */
    public function message(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Set the message content for the SMS (alias for message).
     *
     * @return $this
     */
    public function content(string $content): static
    {
        return $this->message($content);
    }

    /**
     * Set the sender ID for the SMS.
     *
     * @return $this
     */
    public function sender(string $sender_id): static
    {
        $this->sender_id = $sender_id;

        return $this;
    }

    /**
     * Set the type of the SMS message.
     *
     * @return $this
     */
    public function type(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Schedule the SMS message to be sent at a later time.
     *
     * @return $this
     */
    public function schedule(string $time): static
    {
        $this->schedule_time = $time;

        return $this;
    }

    /**
     * Set the DLT template ID for the SMS message.
     *
     * @return $this
     */
    public function dltTemplate(string $templateId): static
    {
        $this->dlt_template_id = $templateId;

        return $this;
    }

    /**
     * Convert the message to an array format suitable for sending.
     *
     * @return array<string, string|null>
     */
    public function toArray(): array
    {
        $data = [
            'recipient' => $this->recipient ?? null,
            'sender_id' => $this->sender_id ?? Config::get('ultimate_sms.sender_id'),
            'type' => $this->type ?? null,
            'message' => $this->message ?? null,
        ];
        if ($this->schedule_time) {
            $data['schedule_time'] = $this->schedule_time;
        }
        $dlt = $this->dlt_template_id ?? Config::get('ultimate_sms.dlt_template_id');
        if ($dlt) {
            $data['dlt_template_id'] = $dlt;
        }

        return $data;
    }
}
