<?php

use Illuminate\Notifications\Notification;
use UltimateSmsNotificationChannel\UltimateSms;
use UltimateSmsNotificationChannel\UltimateSmsChannel;
use UltimateSmsNotificationChannel\UltimateSmsMessage;

test('it can send an sms', function () {
    $sms = Mockery::mock(UltimateSms::class);
    $sms->shouldReceive('send')->once()->andReturn([
        'status' => 'success',
        'data' => 'sms reports with all details',
    ]);

    $channel = new UltimateSmsChannel($sms);
    $notifiable = new class
    {
        public function routeNotificationFor($driver, $notification = null): string
        {
            return '31612345678';
        }
    };
    $notification = new class extends Notification
    {
        public function toUltimateSms($notifiable)
        {
            return UltimateSmsMessage::create('Test message')->to('31612345678');
        }
    };

    $result = $channel->send($notifiable, $notification);
    expect($result['status'])->toBe('success');
});

test('it throws on error', function () {
    $sms = Mockery::mock(UltimateSms::class);
    $sms->shouldReceive('send')->once()->andThrow(new Exception('A human-readable description of the error.'));

    $channel = new UltimateSmsChannel($sms);
    $notifiable = new class
    {
        public function routeNotificationFor($driver, $notification = null): string
        {
            return '31612345678';
        }
    };
    $notification = new class extends Notification
    {
        public function toUltimateSms($notifiable)
        {
            return UltimateSmsMessage::create('Test message')->to('31612345678');
        }
    };

    expect(fn () => $channel->send($notifiable, $notification))->toThrow(Exception::class);
});
