<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurrencyTranslation extends Model
{
    use HasFactory;

    const TABLE = 'currency_translations';
    protected $table = self::TABLE;

    protected $fillable = [
        'name',
        'lang_id',
        'currency_id',
    ];
}
