<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum Status: string
{
	use EnumTrait;
	case ACTIVE = 'active';
	case INACTIVE = 'inactive';
	case ABORTED = 'aborted';
	case COMPLETED = 'completed';
}
