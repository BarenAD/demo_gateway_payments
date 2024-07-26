<?php

namespace App\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class CurrencyDTO extends DataTransferObject
{
    public readonly string $name;
    public readonly string $identify;
    public readonly ?float $rate_to_main_currency;

    public static function make(
        string $name,
        string $identify,
        float $rate_to_main_currency = null,
    ): self {
        return new self([
            'name' => $name,
            'identify' => $identify,
            'rate_to_main_currency' => $rate_to_main_currency,
        ]);
    }
}
