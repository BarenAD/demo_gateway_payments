<?php

use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/currencies', [CurrencyController::class, 'index'])->name('currencies.index');
Route::post('/currencies', [CurrencyController::class, 'synchronizeCurrencies'])->name('currencies.sync');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{userId}/balances', [UserController::class, 'getBalances']);

Route::post('/users/{userId}/balance/transfer', [TransactionController::class, 'transfer']);
Route::post('/users/{userId}/balance/deposit', [TransactionController::class, 'deposit']);
Route::post('/users/{userId}/balance/output', [TransactionController::class, 'output']);
