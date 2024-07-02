<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends ModelTranslations
{
    use HasFactory;

    protected $table = 'transaction_statuses';

    protected array $translateColumns = ['name'];
    protected string $translateTable = TransactionStatusTranslation::TABLE;
    protected string $translateClass = TransactionStatusTranslation::class;
    protected string $translateForeignColumn = 'status_id';

    protected $fillable = [
        'name',
    ];
}
