<?php

namespace LaravelEnso\IO\Enums;

use LaravelEnso\Enums\Services\Enum;

class IOStatuses extends Enum
{
    public const Started = 10;
    public const Processing = 20;
    public const Finalized = 30;
}
