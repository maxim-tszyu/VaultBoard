<?php

namespace App\Traits;

trait EnumTrait
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function cases(): array
    {
        return array_map(fn ($case, $value) => $case, $value);
    }
}
