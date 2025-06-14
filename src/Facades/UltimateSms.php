<?php

namespace Frolax\UltimateSms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static array send(string $recipient, string $message, ?string $senderId = null, ?string $scheduleTime = null)
 * @method static array sendToMany(array $recipients, string $message, ?string $senderId = null, ?string $scheduleTime = null)
 * 
 * @see \Frolax\UltimateSms\UltimateSms
 */
class UltimateSms extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Frolax\UltimateSms\UltimateSms';
    }
} 