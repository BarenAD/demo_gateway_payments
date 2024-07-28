<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
Route::post('/currencies', [CurrencyController::class, 'synchronizeCurrencies'])->name('currencies.sync');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
