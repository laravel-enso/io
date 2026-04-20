<?php

namespace LaravelEnso\IO\Enums;

use LaravelEnso\Enums\Contracts\Frontend;

enum IOStatus: int implements Frontend
{
    case Started = 10;
    case Processing = 20;
    case Finalized = 30;

    public static function registerBy(): string
    {
        return 'ioStatuses';
    }
}
