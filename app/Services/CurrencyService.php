<?php

namespace App\Services;

use App\DTO\CurrencyDTO;
use App\Models\Currency;
use App\Models\CurrencyRate;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CurrencyService
{
    private readonly string $mainCurrencyIdentify;
    public function __construct()
    {
        $this->mainCurrencyIdentify = config('app.main_currency_identify');
    }

    public function calculateRatesByMainCurrency(): void
    {
        $currencies = Currency::query()
            ->with('to_rates')
            ->with('from_rates')
            ->get();
        $mainCurrencyModel = $currencies->where('identify', $this->mainCurrencyIdentify)->first();
        $currencies = $currencies->where('identify', '!=', $this->mainCurrencyIdentify);
        DB::transaction(function () use ($currencies, $mainCurrencyModel) {
            $currencyRates = [];
            foreach ($currencies as $currency) {
                $currencyToMainRate = $currency->to_rates->where('currency_to_id', $mainCurrencyModel->id)->first();
                $currencyValueByMainCurrency = 1 / $currencyToMainRate->value;
                $currencyRates[] = [
                    'currency_from_id' => $mainCurrencyModel->id,
                    'currency_to_id' => $currency->id,
                    'value' => $currencyValueByMainCurrency,
                ];
                foreach ($currencies->where('identify', '!=', $currency->identify) as $currencyRate) {
                    $currencyRateToMainRate = $currencyRate->to_rates->where('currency_to_id', $mainCurrencyModel->id)->first();
                    $currencyRateValueByMainCurrency = 1 / $currencyRateToMainRate->value;
                    $currencyRates[] = [
                        'currency_from_id' => $currency->id,
                        'currency_to_id' => $currencyRate->id,
                        'value' => $currencyValueByMainCurrency * $currencyRateToMainRate->value,
                    ];
                    $currencyRates[] = [
                        'currency_from_id' => $currencyRate->id,
                        'currency_to_id' => $currency->id,
                        'value' => $currencyRateValueByMainCurrency * $currencyToMainRate->value,
                    ];
                }
            }
            CurrencyRate::query()->upsert(
                $currencyRates,
                [
                    'currency_from_id',
                    'currency_to_id'
                ],
                ['value'],
            );
        });
    }
    public function synchronizeCurrencies(array $currenciesDTOs, Carbon $date = null): void
    {
        DB::transaction(function () use ($currenciesDTOs) {
            Currency::query()->upsert(
                array_map(function (CurrencyDTO $currency) {
                    return $currency->only('name', 'identify')->toArray();
                }, $currenciesDTOs),
                ['identify'],
                ['name'],
            );
            $currencyModels = Currency::all();
            CurrencyRate::query()->upsert(
                array_map(function (CurrencyDTO $currency) use ($currencyModels) {
                    return [
                        'value' => $currency->rate_to_main_currency,
                        'currency_to_id' => $currencyModels->where('identify', $this->mainCurrencyIdentify)->first()->id,
                        'currency_from_id'=> $currencyModels->where('identify', $currency->identify)->first()->id,
                    ];
                }, $currenciesDTOs),
                [
                    'currency_from_id',
                    'currency_to_id'
                ],
                ['value'],
            );
        });
    }
}
