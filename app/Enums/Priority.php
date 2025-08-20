<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum Priority: string
{
    use EnumTrait;

    case HIGH = 'High';
    case MEDIUM = 'Medium';
    case LOW = 'Low';
}
