# UltimateSms Notification Channel for Laravel

This package provides a Laravel notification channel for UltimateSms.

## Installation

You can install the package via composer:

```bash
composer require frolax/ultimate-sms-notification-channel
```

The package will automatically register itself.

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Frolax\UltimateSms\UltimateSmsServiceProvider" --tag="config"
```

This will create a `config/ultimate-sms.php` file in your config directory.

## Configuration

Add the following to your `.env` file:

```
ULTIMATE_SMS_API_KEY=your-api-key
ULTIMATE_SMS_BASE_URL=https://sms.test/api/v3
ULTIMATE_SMS_DEFAULT_SENDER_ID=YourName
```

## Usage

### Using the Facade

You can use the UltimateSms Facade to send messages directly:

```php
use Frolax\UltimateSms\Facades\UltimateSms;

// Send to a single recipient
UltimateSms::send(
    '31612345678',
    'Your message here',
    'OptionalSenderId'
);

// Send to multiple recipients
UltimateSms::sendToMany(
    ['31612345678', '880172145789'],
    'Your message here',
    'OptionalSenderId'
);

// Schedule a message
UltimateSms::send(
    '31612345678',
    'Your message here',
    'OptionalSenderId',
    '2021-12-20 07:00'
);
```

### Using Notifications

To use the UltimateSms channel in your notification, add the `toUltimateSms` method to your notification class:

```php
use Frolax\UltimateSms\Messages\UltimateSmsMessage;
use Illuminate\Notifications\Notification;

class YourNotification extends Notification
{
    public function via($notifiable)
    {
        return ['ultimate-sms'];
    }

    public function toUltimateSms($notifiable)
    {
        return UltimateSmsMessage::create(
            $notifiable->phone_number, // The recipient's phone number
            'Your message here', // The message content
            'OptionalSenderId' // Optional sender ID
        );
    }
}
```

### Multiple Recipients

To send a message to multiple recipients, you can provide a comma-separated list of phone numbers:

```php
public function toUltimateSms($notifiable)
{
    return UltimateSmsMessage::create(
        '31612345678,880172145789', // Multiple recipients
        'Your message here',
        'OptionalSenderId'
    );
}
```

### Scheduled Messages

To schedule a message for later delivery, provide a schedule time in the format 'YYYY-MM-DD HH:mm':

```php
public function toUltimateSms($notifiable)
{
    return UltimateSmsMessage::create(
        $notifiable->phone_number,
        'Your message here',
        'OptionalSenderId',
        '2021-12-20 07:00' // Schedule time
    );
}
```

### Response Format

The API will return a response in the following format:

```json
{
    "status": "success",
    "data": "sms reports with all details"
}
```

If the request fails, it will return:

```json
{
    "status": "error",
    "message": "A human-readable description of the error"
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information. 