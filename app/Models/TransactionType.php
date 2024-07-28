<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionType extends ModelTranslations
{
    use HasFactory;

    protected $table = 'transaction_types';

    protected array $translateColumns = ['name'];
    protected string $translateTable = TransactionTypeTranslation::TABLE;
    protected string $translateClass = TransactionTypeTranslation::class;
    protected string $translateForeignColumn = 'type_id';

    protected $fillable = [
        'name',
    ];
}
