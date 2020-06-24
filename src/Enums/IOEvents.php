<?php

namespace LaravelEnso\IO\Enums;

use LaravelEnso\Enums\Services\Enum;

class IOEvents extends Enum
{
    public const Started = 10;
    public const Updated = 20;
    public const Stopped = 30;

    protected static array $data = [
        self::Started => 'io-started',
        self::Updated => 'io-updated',
        self::Stopped => 'io-stopped',
    ];
}
