<?php

namespace App\Application\Constants;

enum MicrositeTypes: string
{
    case INVOICE = 'invoice';
    case SUBSCRIPTION = 'subscription';
    case PAYMENT = 'payment';
    case DONATION = 'donation';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
