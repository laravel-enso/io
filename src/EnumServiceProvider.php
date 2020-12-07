<?php

namespace LaravelEnso\IO;

use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;
use LaravelEnso\IO\Enums\IOStatuses;
use LaravelEnso\IO\Enums\IOTypes;

class EnumServiceProvider extends ServiceProvider
{
    public $register = [
        'ioStatuses' => IOStatuses::class,
        'ioTypes' => IOTypes::class,
    ];
}
