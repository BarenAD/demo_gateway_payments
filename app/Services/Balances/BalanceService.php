<?php

namespace App\Services\Balances;

use App\Enums\Transactions\TransactionStatues;
use App\Models\Transaction;
use App\Models\UserBalance;
use App\Services\Balances\UserBalanceCalculateHandles\UserBalanceCalculateHandle;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class BalanceService
{
    public function getUserBalance(int $userId, int $currencyId): float
    {
        $result = 0.0;
        $balance = UserBalance::query()
            ->where('user_id', $userId)
            ->where('currency_id', $currencyId)
            ->first();
        $query = Transaction::query()
            ->where(function (Builder $query) use ($userId) {
                $query->where('user_from_id', $userId);
                $query->orWhere('user_to_id', $userId);
            })
            ->where(function (Builder $query) use ($currencyId) {
                $query->where('currency_from_id', $currencyId);
                $query->orWhere('currency_to_id', $currencyId);
            })
            ->whereIn('status_id', [
                TransactionStatues::SUCCESSFULLY,
                TransactionStatues::IN_QUEUE,
                TransactionStatues::NEW,
                TransactionStatues::IN_PROGRESS,
            ])
            ->orderBy('datetime');
        if (!empty($balance)) {
            $query->where('datetime', '>', $balance->last_synchronize);
            $result = $balance->value;
        }

        $hasUncompletedTransaction = false;
        $lastConsiderTransaction = null;
        $query->chunk(500, function (Collection $transactions) use (
            &$result,
            &$lastConsiderTransaction,
            &$hasUncompletedTransaction,
            $userId,
            $currencyId
        ) {
            foreach ($transactions as $transaction) {
                $handleAction = UserBalanceCalculateHandle::make($transaction->type_id);
                $result += $handleAction->handle($transaction, $userId, $currencyId);
                $transactionCompleted = in_array($transaction->status_id, [
                    TransactionStatues::SUCCESSFULLY,
                    TransactionStatues::ERROR,
                ]);
                if (!$hasUncompletedTransaction && !$transactionCompleted) {
                    $hasUncompletedTransaction = true;
                }
                if (!$hasUncompletedTransaction && $transactionCompleted) {
                    $lastConsiderTransaction = [
                        'result' => $result,
                        'datetime' => $transaction->datetime,
                    ];
                }
            }
        });

        if (!empty($lastConsiderTransactionDatetime)) {
            $this->updateUserBalance(
                $userId,
                $currencyId,
                $lastConsiderTransaction['result'],
                $lastConsiderTransaction['datetime']
            );
        }
        return $result;
    }

    private function updateUserBalance(
        int $userId,
        int $currencyId,
        float $value,
        Carbon $lastConsiderTransactionDatetime
    ): void {
        UserBalance::query()->updateOrCreate(
            [
                'user_id' => $userId,
                'currency_id' => $currencyId,
            ],
            [
                'value' => $value,
                'last_synchronize' => $lastConsiderTransactionDatetime,
            ]
        );
    }
}
