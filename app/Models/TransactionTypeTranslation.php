<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionTypeTranslation extends Model
{
    use HasFactory;

    const TABLE = 'transaction_type_translations';
    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'lang_id',
        'type_id',
    ];
}
