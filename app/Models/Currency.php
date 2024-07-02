<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends ModelTranslations
{
    use HasFactory;

    protected $table = 'currencies';

    protected array $translateColumns = ['name'];
    protected string $translateTable = CurrencyTranslation::TABLE;
    protected string $translateClass = CurrencyTranslation::class;
    protected string $translateForeignColumn = 'currency_id';

    protected $fillable = [
        'identify',
        'name',
    ];
}
