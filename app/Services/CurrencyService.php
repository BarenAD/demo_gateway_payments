<?php

namespace App\Services;

use App\Clients\Currencies\CurrencyClient;
use App\Models\Currency;
use App\Models\CurrencyRate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;

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
            foreach ($currencies as $currency) {
                $currencyToMainRate = $currency->to_rates->where('currency_to_id', $mainCurrencyModel->id)->first();
                $currencyValueByMainCurrency = 1 / $currencyToMainRate->value;
                $this->createOrUpdateCurrencyRate(
                    $mainCurrencyModel->id,
                    $currency->id,
                    $currencyValueByMainCurrency
                );
                foreach ($currencies->where('identify', '!=', $currency->identify) as $currencyRate) {
                    $currencyRateToMainRate = $currencyRate->to_rates->where('currency_to_id', $mainCurrencyModel->id)->first();
                    $currencyRateValueByMainCurrency = 1 / $currencyRateToMainRate->value;
                    $this->createOrUpdateCurrencyRate(
                        $currency->id,
                        $currencyRate->id,
                        $currencyValueByMainCurrency * $currencyRateToMainRate->value
                    );
                    $this->createOrUpdateCurrencyRate(
                        $currencyRate->id,
                        $currency->id,
                        $currencyRateValueByMainCurrency * $currencyToMainRate->value
                    );
                }
            }
        });
    }
    public function synchronizeCurrencies(CurrencyClient $client, Carbon $date = null): void
    {
        $currencies = $client->getCurrencies($date ?? now());
        DB::transaction(function () use ($currencies) {
            $mainCurrencyModel = $this->createOrFirstCurrency(
                $this->mainCurrencyIdentify,
                Lang::get("currencies.$this->mainCurrencyIdentify")
            );
            foreach ($currencies as $currency) {
                $currencyModel = $this->createOrFirstCurrency(
                    $currency->identify,
                    $currency->name,
                );
                $this->createOrUpdateCurrencyRate(
                    $currencyModel->id,
                    $mainCurrencyModel->id,
                    $currency->rate_to_main_currency
                );
            }
        });
    }

    private function createOrFirstCurrency(string $identify, string $name): Model
    {
        $model = Currency::query()->where('identify', $identify)->first();
        if (empty($model)) {
            $model = Currency::query()->create([
                'identify' => $identify,
                'name' => $name
            ]);
        }
        return $model;
    }

    private function createOrUpdateCurrencyRate(
        int $currencyFromId,
        int $currencyToId,
        float $value
    ): void {
        $params = [
            'currency_from_id' => $currencyFromId,
            'currency_to_id' => $currencyToId,
        ];
        CurrencyRate::query()->updateOrCreate(
            $params,
            [
                ...$params,
                'value' => $value,
            ]
        );
    }
}
