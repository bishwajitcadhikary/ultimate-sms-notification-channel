# Ultimate SMS Notification Channel for Laravel

This package provides a Laravel notification channel for sending SMS via the Ultimate SMS HTTP API.

## Installation

```bash
composer require frolax/ultimate-sms-notification-channel
```

Publish the config file:

```bash
php artisan vendor:publish --provider="UltimateSmsNotificationChannel\\UltimateSmsServiceProvider" --tag=config
```

## Configuration

Add the following to your `.env`:

```
ULTIMATE_SMS_BASE_URL=https://sms.frolax.net
ULTIMATE_SMS_API_KEY=your_api_key
ULTIMATE_SMS_SENDER_ID=YourName
ULTIMATE_SMS_DLT_TEMPLATE_ID=optional
```

- `ULTIMATE_SMS_BASE_URL` should be the website base URL only (e.g., `https://sms.frolax.net`).
- The package will automatically use the correct API endpoint for sending SMS.

## Usage

In your notification:

```php
use UltimateSmsNotificationChannel\UltimateSmsMessage;

public function via($notifiable)
{
    return ['ultimate_sms'];
}

public function toUltimateSms($notifiable)
{
    return UltimateSmsMessage::create('This is a test message')
        ->to('31612345678');
}
```

Or route notification:

```php
use Illuminate\Support\Facades\Notification;
use App\Notifications\YourNotification;

Notification::route('ultimate_sms', '31612345678')->notify(new YourNotification());
```

### Sending to Multiple Recipients

You can send to multiple numbers by passing a comma-separated string:

```php
UltimateSmsMessage::create('This is a test message')
    ->to('31612345678,880172145789');
```

### Optional Parameters
- `sender_id`: Override the default sender ID.
- `type`: Set the message type (default: `plain`).
- `schedule_time`: Schedule the SMS (format: `YYYY-MM-DD HH:MM`).
- `dlt_template_id`: Set a DLT template ID (optional).

## Testing

```bash
vendor/bin/pest
```

---

For more information, visit [Frolax SMS](https://sms.frolax.net) 