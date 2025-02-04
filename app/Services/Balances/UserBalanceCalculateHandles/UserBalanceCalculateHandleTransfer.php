<?php

namespace App\Services\Balances\UserBalanceCalculateHandles;

use App\Enums\Transactions\TransactionStatues;
use App\Models\Transaction;

class UserBalanceCalculateHandleTransfer extends UserBalanceCalculateHandle
{

    public function handle(Transaction &$transaction, int $userId, int $currencyId): float
    {
        if ($transaction->status_id === TransactionStatues::ERROR)
            return 0;
        if ($transaction->user_from_id === $userId && $transaction->currency_from_id === $currencyId)
            return -$transaction->value_from;
        if ($transaction->user_to_id === $userId && $transaction->currency_to_id === $currencyId)
            return $transaction->status_id === TransactionStatues::SUCCESSFULLY ? $transaction->value_to : 0;
        throw new \Error('An unprocessed case!');
    }
}
