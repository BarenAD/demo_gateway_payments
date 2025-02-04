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
        /*
         * Ввиду того, что клиент всего 1 и не планируется пока добавлять другие - тут жестко завязан клиент.
         * В дальнейшем можно расширить роут, указав тип синхронизации, разделив это на различные клиенты.
         */
        $service->synchronizeCurrencies(
            $client->getCurrencies(now())
        );
        $service->calculateRatesByMainCurrency();
        return redirect(route('currencies.index'));
    }
}
