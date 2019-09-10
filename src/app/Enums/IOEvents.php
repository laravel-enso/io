<?php

namespace LaravelEnso\IO\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class IOEvents extends Enum
{
    const Started = 10;
    const Updated = 20;
    const Stopped = 30;

    protected static $data = [
        self::Started => 'io-started',
        self::Updated => 'io-updated',
        self::Stopped => 'io-stopped',
    ];
}
