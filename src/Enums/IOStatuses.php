<?php

namespace LaravelEnso\IO\Enums;

use LaravelEnso\Enums\Services\Enum;

class IOStatuses extends Enum
{
    public const Waiting = IOEvents::Started;
    public const Processing = IOEvents::Updated;
    public const Finalized = IOEvents::Stopped;
}
