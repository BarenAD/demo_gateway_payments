<?php

use App\Enums\Transactions\TransactionTypes;
use App\Services\Balances\UserBalanceCalculateHandles\UserBalanceCalculateHandleDeposit;
use App\Services\Balances\UserBalanceCalculateHandles\UserBalanceCalculateHandleOutput;
use App\Services\Balances\UserBalanceCalculateHandles\UserBalanceCalculateHandleTransfer;

return [
    'balances' => [
        'user_balance_calculate_actions' => [
            TransactionTypes::DEPOSIT->value => UserBalanceCalculateHandleDeposit::class,
            TransactionTypes::OUTPUT->value => UserBalanceCalculateHandleOutput::class,
            TransactionTypes::TRANSFER->value => UserBalanceCalculateHandleTransfer::class,
        ],
    ],
];
