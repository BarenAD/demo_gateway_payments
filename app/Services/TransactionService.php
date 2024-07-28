<?php

namespace App\Services;

use App\Enums\Transactions\TransactionStatues;
use App\Enums\Transactions\TransactionTypes;
use App\Models\CurrencyRate;
use App\Models\Transaction;
use App\Models\UserBalance;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function transfer(
        int     $userFromId,
        int     $userToId,
        int     $currencyFromId,
        int     $currencyToId,
        float   $value,
        ?Carbon $datetime = null
    ): Model {
        $balance = $this->getUserBalance($userFromId, $currencyFromId);
        if ($balance < $value) {
            throw new \Error('Insufficient funds');
        }
        return DB::transaction(function () use (
            $userFromId,
            $userToId,
            $currencyFromId,
            $currencyToId,
            $value,
            $datetime
        ) {
            $currencyRate =
                $currencyFromId === $currencyToId ? 1 :
                    CurrencyRate::query()
                    ->where('currency_from_id', $currencyFromId)
                    ->where('currency_to_id', $currencyToId)
                    ->firstOrFail()
                    ->value;

            return Transaction::query()
                ->create([
                    'value_from' => $value,
                    'value_to' => $currencyRate * $value,
                    'datetime' => $datetime ?? now(),
                    'user_from_id' => $userFromId,
                    'user_to_id' => $userToId,
                    'currency_from_id' => $currencyFromId,
                    'currency_to_id' => $currencyToId,
                    'status_id' => TransactionStatues::NEW,
                    'type_id' => TransactionTypes::TRANSFER,
                ]);
        });
    }
    public function deposit(int $userId, int $currencyId, float $value): Model
    {
        return Transaction::query()
            ->create([
                'value_to' => $value,
                'datetime' => now(),
                'type_id' => TransactionTypes::DEPOSIT,
                'status_id' => TransactionStatues::NEW,
                'user_to_id' => $userId,
                'currency_to_id' => $currencyId,
            ]);
    }

    public function output(int $userId, int $currencyId, float $value): Model
    {
        $balance = $this->getUserBalance($userId, $currencyId);
        if ($balance < $value) {
            throw new \Error('Insufficient funds');
        }
        return DB::transaction(function () use ($userId, $currencyId, $value, $balance) {
            return Transaction::query()
                ->create([
                    'value_from' => $value,
                    'datetime' => now(),
                    'type_id' => TransactionTypes::OUTPUT,
                    'status_id' => TransactionStatues::NEW,
                    'user_from_id' => $userId,
                    'currency_from_id' => $currencyId,
                ]);
        });
    }
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

        $lastConsiderTransactionDatetime = null;
        $query->chunk(500, function (Collection $transactions) use (
            &$result,
            &$lastConsiderTransactionDatetime,
            $userId,
            $currencyId
        ) {
            foreach ($transactions as $transaction) {
                switch ($transaction->type_id) {
                    case TransactionTypes::TRANSFER:
                        if (
                            $transaction->user_from_id === $userId &&
                            $transaction->currency_from_id === $currencyId
                        ) {
                            $result -= $transaction->value_from;
                        } else if (
                            $transaction->user_to_id === $userId &&
                            $transaction->currency_to_id === $currencyId &&
                            $transaction->status_id === TransactionStatues::SUCCESSFULLY
                        ) {
                            $result += $transaction->value_to;
                        }
                        break;
                    case TransactionTypes::DEPOSIT:
                        $result += $transaction->value_to;
                        break;
                    case TransactionTypes::OUTPUT:
                        $result -= $transaction->value_from;
                        break;
                    default:
                        throw new \Error('Unknown transaction type!');
                }
                if ($transaction->status_id === TransactionStatues::SUCCESSFULLY) {
                    $lastConsiderTransactionDatetime = $transaction->datetime;
                }
            }
        });

        if (!empty($lastConsiderTransactionDatetime)) {
            $this->updateUserBalance(
                $userId,
                $currencyId,
                $result,
                $lastConsiderTransactionDatetime
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
        $params = [
            'user_id' => $userId,
            'currency_id' => $currencyId,
        ];
        UserBalance::query()->updateOrCreate(
            $params,
            [
                ...$params,
                'value' => $value,
                'last_synchronize' => $lastConsiderTransactionDatetime,
            ]
        );
    }
}
