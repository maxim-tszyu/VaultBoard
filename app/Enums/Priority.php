<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum Priority: string
{
    use EnumTrait;

    case HIGH = 'high';
    case MEDIUM = 'medium';
    case LOW = 'low';
}
