<?php

namespace LaravelEnso\IO\Enums;

use LaravelEnso\Enums\Services\Enum;

class IOTypes extends Enum
{
    public const Import = 1;
    public const Export = 2;

    protected static array $data = [
        self::Import => 'import',
        self::Export => 'export',
    ];
}
