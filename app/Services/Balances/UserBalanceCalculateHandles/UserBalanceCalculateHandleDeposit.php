<?php

namespace App\Services\Balances\UserBalanceCalculateHandles;

use App\Enums\Transactions\TransactionStatues;
use App\Models\Transaction;

class UserBalanceCalculateHandleDeposit extends UserBalanceCalculateHandle
{

    public function handle(Transaction &$transaction, int $userId, int $currencyId): float
    {
        if ($transaction->status_id === TransactionStatues::SUCCESSFULLY) {
            return $transaction->value_to;
        }
        return 0;
    }
}
