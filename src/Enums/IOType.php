<?php

namespace LaravelEnso\IO\Enums;

use LaravelEnso\Enums\Contracts\Frontend;

enum IOType: int implements Frontend
{
    case Import = 1;
    case Export = 2;
    case Task = 3;

    public static function registerBy(): string
    {
        return  'ioTypes';
    }

    // protected static array $data = [
    //     self::Import => 'import',
    //     self::Export => 'export',
    //     self::Task => 'task',
    // ];
}
