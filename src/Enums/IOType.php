<?php

namespace LaravelEnso\IO\Enums;

use LaravelEnso\Enums\Contracts\Frontend;
use LaravelEnso\Enums\Contracts\Mappable;

enum IOType: int implements Mappable, Frontend
{
    case Import = 1;
    case Export = 2;
    case Task = 3;

    public static function registerBy(): string
    {
        return 'ioTypes';
    }

    public function map(): string
    {
        return match ($this) {
            self::Import => 'import',
            self::Export => 'export',
            self::Task => 'task',
        };
    }
}
