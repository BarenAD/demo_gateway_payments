<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStatusTranslation extends Model
{
    use HasFactory;

    const TABLE = 'transaction_status_translations';
    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'lang_id',
        'status_id',
    ];
}
