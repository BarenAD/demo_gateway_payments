<?php

namespace App\Enums\Transactions;

use App\Traits\EnumExtensionTrait;

enum TransactionTypes: int
{
    use EnumExtensionTrait;

    case DEPOSIT = 1;
    case OUTPUT = 2;
    case TRANSFER = 3;
}
