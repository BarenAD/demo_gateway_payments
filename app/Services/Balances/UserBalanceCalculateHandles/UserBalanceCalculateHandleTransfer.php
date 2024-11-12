<?php

namespace App\Services\Balances\UserBalanceCalculateHandles;

use App\Enums\Transactions\TransactionStatues;
use App\Models\Transaction;

class UserBalanceCalculateHandleTransfer extends UserBalanceCalculateHandle
{

    public function handle(Transaction &$transaction, int $userId, int $currencyId): float
    {
        if (
            $transaction->user_from_id === $userId &&
            $transaction->currency_from_id === $currencyId
        ) {
            return -$transaction->value_from;
        } else if (
            $transaction->user_to_id === $userId &&
            $transaction->currency_to_id === $currencyId &&
            $transaction->status_id === TransactionStatues::SUCCESSFULLY
        ) {
            return $transaction->value_to;
        }
        throw new \Error('An unprocessed case!');
    }
}
