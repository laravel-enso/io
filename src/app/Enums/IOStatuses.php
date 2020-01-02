<?php

namespace LaravelEnso\IO\App\Enums;

use LaravelEnso\Enums\App\Services\Enum;

class IOStatuses extends Enum
{
    public const Waiting = IOEvents::Started;
    public const Processing = IOEvents::Updated;
    public const Finalized = IOEvents::Stopped;
}
