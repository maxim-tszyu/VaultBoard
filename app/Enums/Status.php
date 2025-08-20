<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum Status: string
{
    use EnumTrait;
    case ACTIVE = 'Active';
    case INACTIVE = 'Inactive';
    case ABORTED = 'Aborted';
    case COMPLETED = 'Completed';
}
