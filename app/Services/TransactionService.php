<?php

namespace App\Services;

use App\Enums\Transactions\TransactionStatues;
use App\Enums\Transactions\TransactionTypes;
use App\Models\CurrencyRate;
use App\Models\Transaction;
use App\Services\Balances\BalanceService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    public function __construct(
        private readonly BalanceService $balanceService
    ){}

    public function transfer(
        int     $userFromId,
        int     $userToId,
        int     $currencyFromId,
        int     $currencyToId,
        float   $value,
        ?Carbon $datetime = null
    ): Model {
        $balance = $this->balanceService->getUserBalance($userFromId, $currencyFromId);
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
                'status_id' => TransactionStatues::SUCCESSFULLY,
                'user_to_id' => $userId,
                'currency_to_id' => $currencyId,
            ]);
    }

    public function output(int $userId, int $currencyId, float $value): Model
    {
        $balance = $this->balanceService->getUserBalance($userId, $currencyId);
        if ($balance < $value) {
            throw new \Error('Insufficient funds');
        }
        return DB::transaction(function () use ($userId, $currencyId, $value, $balance) {
            return Transaction::query()
                ->create([
                    'value_from' => $value,
                    'datetime' => now(),
                    'type_id' => TransactionTypes::OUTPUT,
                    'status_id' => TransactionStatues::SUCCESSFULLY,
                    'user_from_id' => $userId,
                    'currency_from_id' => $currencyId,
                ]);
        });
    }
}
