<?php

namespace Frolax\UltimateSms\Tests;

use Frolax\UltimateSms\Channels\UltimateSmsChannel;
use Frolax\UltimateSms\Messages\UltimateSmsMessage;
use Frolax\UltimateSms\UltimateSms;
use Illuminate\Notifications\Notification;
use Mockery;
use Orchestra\Testbench\TestCase;

class UltimateSmsChannelTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            'Frolax\UltimateSms\UltimateSmsServiceProvider',
        ];
    }

    public function testChannelSendsMessage()
    {
        $ultimateSms = Mockery::mock(UltimateSms::class);
        $ultimateSms->shouldReceive('send')
            ->once()
            ->with('31612345678', 'Test message', 'TestSender', null)
            ->andReturn(['status' => 'success', 'data' => 'sms reports with all details']);

        $channel = new UltimateSmsChannel($ultimateSms);
        $notification = new TestNotification();
        $notifiable = new TestNotifiable();

        $channel->send($notifiable, $notification);
    }

    public function testChannelSendsMessageToMultipleRecipients()
    {
        $ultimateSms = Mockery::mock(UltimateSms::class);
        $ultimateSms->shouldReceive('send')
            ->once()
            ->with('31612345678,880172145789', 'Test message', 'TestSender', null)
            ->andReturn(['status' => 'success', 'data' => 'sms reports with all details']);

        $channel = new UltimateSmsChannel($ultimateSms);
        $notification = new TestMultiRecipientNotification();
        $notifiable = new TestMultiRecipientNotifiable();

        $channel->send($notifiable, $notification);
    }

    public function testChannelSendsScheduledMessage()
    {
        $ultimateSms = Mockery::mock(UltimateSms::class);
        $ultimateSms->shouldReceive('send')
            ->once()
            ->with('31612345678', 'Test message', 'TestSender', '2021-12-20 07:00')
            ->andReturn(['status' => 'success', 'data' => 'sms reports with all details']);

        $channel = new UltimateSmsChannel($ultimateSms);
        $notification = new TestScheduledNotification();
        $notifiable = new TestNotifiable();

        $channel->send($notifiable, $notification);
    }
}

class TestNotification extends Notification
{
    public function via($notifiable)
    {
        return ['ultimate-sms'];
    }

    public function toUltimateSms($notifiable)
    {
        return UltimateSmsMessage::create(
            '31612345678',
            'Test message',
            'TestSender'
        );
    }
}

class TestMultiRecipientNotification extends Notification
{
    public function via($notifiable)
    {
        return ['ultimate-sms'];
    }

    public function toUltimateSms($notifiable)
    {
        return UltimateSmsMessage::create(
            '31612345678,880172145789',
            'Test message',
            'TestSender'
        );
    }
}

class TestScheduledNotification extends Notification
{
    public function via($notifiable)
    {
        return ['ultimate-sms'];
    }

    public function toUltimateSms($notifiable)
    {
        return UltimateSmsMessage::create(
            '31612345678',
            'Test message',
            'TestSender',
            '2021-12-20 07:00'
        );
    }
}

class TestNotifiable
{
    public $phone_number = '31612345678';
}

class TestMultiRecipientNotifiable
{
    public $phone_numbers = ['31612345678', '880172145789'];
}
