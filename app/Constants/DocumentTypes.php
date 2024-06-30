<?php

namespace App\Constants;

enum DocumentTypes: string
{
    case CC = 'CC';
    case NIT = 'NIT';
    case TI = 'TI';
    case PPT = 'PT';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
