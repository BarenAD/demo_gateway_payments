<?php

namespace App\Enums\Transactions;

use App\Traits\EnumExtensionTrait;

enum TransactionStatues: int
{
    use EnumExtensionTrait;

    case NEW = 1;
    case IN_QUEUE = 2;
    case IN_PROGRESS = 3;
    case SUCCESSFULLY = 4;
    case ERROR = 5;
}
