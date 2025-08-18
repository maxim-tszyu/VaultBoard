<?php

namespace App\Enums;

use App\Traits\EnumTrait;

enum Expense: string
{
    use EnumTrait;

    case INCOME = 'income';
    case OUTCOME = 'outcome';
}
