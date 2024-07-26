<?php

namespace App\Http\Controllers;

use App\Clients\Currencies\CurrencyCBRClient;
use App\Models\Currency;
use App\Services\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

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
        $service->synchronizeCurrencies($client);
    }

    public function calculateRatesByMainCurrency(
        Request $request,
        CurrencyCBRClient $client,
        CurrencyService $service
    ) {
        $service->calculateRatesByMainCurrency();
    }
}
