<?php

namespace App\Services\Balances\UserBalanceCalculateHandles;

use App\Models\Transaction;

class UserBalanceCalculateHandleOutput extends UserBalanceCalculateHandle
{

    public function handle(Transaction &$transaction, int $userId, int $currencyId): float
    {
        return -$transaction->value_from;
    }
}
