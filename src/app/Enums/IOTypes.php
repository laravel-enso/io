<?php

namespace LaravelEnso\IO\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class IOTypes extends Enum
{
    const Import = 1;
    const Export = 2;

    protected static $data = [
        self::Import => 'import',
        self::Export => 'export',
    ];
}
