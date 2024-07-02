<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'value',
        'datetime',
        'user_from_id',
        'user_to_id',
        'currency_id',
        'status_id',
    ];
}
