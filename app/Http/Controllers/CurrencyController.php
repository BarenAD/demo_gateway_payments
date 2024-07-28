<?php

namespace App\Http\Controllers;

use App\Clients\CurrencyCBRClient;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index(Request $request)
    {
        $currencies = Currency::query()
            ->with('from_rates')
            ->get();
        return view('currencies', ['currencies' => $currencies]);
    }

    public function synchronizeCurrencies(
        Request $request,
        CurrencyCBRClient $client,
        CurrencyService $service
    ) {
        $service->synchronizeCurrencies(
            $client->getCurrencies(now())
        );
        $service->calculateRatesByMainCurrency();
        return redirect(route('currencies.index'));
    }
}
