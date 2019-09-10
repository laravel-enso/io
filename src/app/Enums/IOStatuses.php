<?php

namespace LaravelEnso\IO\app\Enums;

use LaravelEnso\Enums\app\Services\Enum;

class IOStatuses extends Enum
{
    const Waiting = IOEvents::Started;
    const Processing = IOEvents::Updated;
    const Finalized = IOEvents::Stopped;
}
