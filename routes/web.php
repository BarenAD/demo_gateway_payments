<?php

use App\Http\Controllers\CurrencyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
Route::post('/currencies', [CurrencyController::class, 'synchronizeCurrencies'])->name('currencies.sync');
