<?php

namespace App\Models;

use App\Enums\Transactions\TransactionStatues;
use App\Enums\Transactions\TransactionTypes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'value_from',
        'value_to',
        'datetime',
        'datetime_completed',
        'user_from_id',
        'user_to_id',
        'currency_from_id',
        'currency_to_id',
        'status_id',
        'type_id',
    ];

    protected $casts = [
        'type_id' => TransactionTypes::class,
        'status_id' => TransactionStatues::class,
        'datetime' => 'datetime',
        'datetime_completed' => 'datetime',
    ];
}
