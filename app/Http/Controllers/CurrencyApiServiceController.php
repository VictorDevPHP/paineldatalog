<?php

namespace App\Http\Controllers;

use App\Services\CurrencyApiService;

class CurrencyController extends Controller
{
    protected $currencyApi;

    public function __construct(CurrencyApiService $currencyApi)
    {
        $this->currencyApi = $currencyApi;
    }

    public function index()
    {
        $baseCurrency = 'USD';
        $rates = $this->currencyApi->getExchangeRates($baseCurrency);

        // Faça o que quiser com as taxas de câmbio

        return view('pages', compact('rates'));
    }
}
