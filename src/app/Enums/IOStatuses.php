<?php

namespace LaravelEnso\IO\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class IOStatuses extends Enum
{
    public const Waiting = IOEvents::Started;
    public const Processing = IOEvents::Updated;
    public const Finalized = IOEvents::Stopped;
}
