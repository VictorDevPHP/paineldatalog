<?php

namespace App\Services;

use GuzzleHttp\Client;

class CurrencyApiService
{
    protected $apiKey;
    protected $client;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
        $this->client = new Client([
            'base_uri' => 'https://currencyapi.net/api/v1/',
            'query' => [
                'key' => $this->apiKey,
            ],
        ]);
    }

    public function getExchangeRates($baseCurrency)
    {
        $response = $this->client->request('GET', 'rates', [
            'query' => [
                'base' => $baseCurrency,
            ],
        ]);

        $body = $response->getBody();
        $data = json_decode($body, true);

        return $data['rates'];
    }
}
