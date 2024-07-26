<?php


namespace App\Clients\Currencies;


use App\DTO\CurrencyDTO;
use Carbon\Carbon;
use GuzzleHttp\Client;

class CurrencyCBRClient extends CurrencyClient
{
    private readonly string $url;
    private readonly Client $client;
    public function __construct()
    {
        $this->url = config('http.clients.currency.cbr.url');
        $this->client = new Client(
            [
                'verify' => false,
                'headers' => [
                    'Accept' => 'application/xml'
                ],
            ]
        );
    }

    public function getCurrencies(Carbon $date): array
    {
        $response = $this->client->request('GET', $this->url . '/scripts/XML_daily.asp?date_req=' . $date->format('d/m/Y'));
        $xml = simplexml_load_string($response->getBody());
        $result = [];
        foreach (json_decode(json_encode($xml), true)['Valute'] as $currency) {
            $result[] = CurrencyDTO::make(
                $currency['Name'],
                $currency['CharCode'],
                floatval(str_replace(',','.',$currency['VunitRate'])),
            );
        }
        return $result;
    }
}
