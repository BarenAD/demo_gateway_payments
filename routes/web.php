<?php

use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/currencies', [CurrencyController::class, 'index']);
Route::post('/currencies/sync', [CurrencyController::class, 'synchronizeCurrencies']);
Route::post('/currencies/calculate-rates', [CurrencyController::class, 'calculateRatesByMainCurrency']);
