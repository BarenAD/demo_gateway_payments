<?php

namespace App\Traits;

use Illuminate\Support\Facades\Lang;

trait EnumExtensionTrait
{
    public static function fromName(string $name): static
    {
        foreach (static::cases() as $status) {
            if (strtolower($name) === strtolower($status->name)) {
                return $status;
            }
        }
        throw new \ValueError($name . ' ' . Lang::get('Invalid Name Enum') . ' ' . static::class);
    }
}
