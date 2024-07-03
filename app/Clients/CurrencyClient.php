<?php


namespace App\Clients;


use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Orchestra\Parser\Xml\Facade as XmlParser;

class CurrencyClient
{
    private string $url;
    private Client $client;

    public function __construct()
    {
        $this->url = config('http.clients.currency.url');
        $this->client = new Client(
            [
                'verify' => false,
                'headers' => [
                    'Accept' => 'application/xml'
                ],
            ]
        );
    }

    public function getCurrencies(Carbon $date)
    {
        $response = $this->client->request('GET', $this->url . '/scripts/XML_daily.asp?date_req=' . $date->format('d/m/Y'));
        $xml = XmlParser::extract($response->getBody()->getContents());
        $xml->parse([
            'currency_id' => ['uses' => 'Valute::ID'],
            'currency_identify' => ['uses' => 'Valute.CharCode'],
            'nominal' => ['uses' => 'Valute.Nominal'],
            'name' => ['uses' => 'Valute.Name'],
            'value' => ['uses' => 'Valute.Value'],
            'vunit_rate' => ['uses' => 'Valute.VunitRate'],
        ]);
        return $xml->parse([
            'currency_id' => ['uses' => 'Valute::ID'],
            'currency_identify' => ['uses' => 'Valute.CharCode'],
            'nominal' => ['uses' => 'Valute.Nominal'],
            'name' => ['uses' => 'Valute.Name'],
            'value' => ['uses' => 'Valute.Value'],
            'vunit_rate' => ['uses' => 'Valute.VunitRate'],
        ]);
    }
}
