<?php

namespace App\Enums;

use App\Traits\EnumExtensionTrait;

enum Langs: int
{
    use EnumExtensionTrait;

    case en = 1;
    case ru = 2;
}
