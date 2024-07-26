<?php

namespace App\Clients\Currencies;

use Carbon\Carbon;
use GuzzleHttp\Client;

abstract class CurrencyClient
{
    private readonly string $url;
    private readonly Client $client;

    abstract public function getCurrencies(Carbon $date): array;
}
