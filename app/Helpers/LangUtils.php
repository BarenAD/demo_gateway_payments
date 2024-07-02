<?php

namespace App\Helpers;

use App\Enums\Langs;
use Illuminate\Support\Facades\Lang;

class LangUtils
{
    public static function getLocale(): Langs
    {
        return Langs::fromName(Lang::getLocale());
    }

    public static function getFallbackLocale(): Langs
    {
        return Langs::fromName(config('app.fallback_locale'));
    }

    public static function getLocaleId(): int
    {
        return Langs::fromName(Lang::getLocale())->value;
    }

    public static function getFallbackLocaleId(): int
    {
        return Langs::fromName(config('app.fallback_locale'))->value;
    }
}
