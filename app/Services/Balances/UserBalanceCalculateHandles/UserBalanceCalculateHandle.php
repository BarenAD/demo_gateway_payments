<?php

namespace App\Services\Balances\UserBalanceCalculateHandles;

use App\Enums\Transactions\TransactionTypes;
use App\Models\Transaction;

abstract class UserBalanceCalculateHandle
{
    abstract public function handle(Transaction &$transaction, int $userId, int $currencyId): float;

    public static function make(TransactionTypes $transactionType): UserBalanceCalculateHandle
    {
        $actionClass = config("strategy_dependencies.balances.user_balance_calculate_actions.$transactionType->value");
        if (!$actionClass) {
            throw new \ValueError('Invalid action config');
        }
        return app()->make($actionClass);
    }
}
