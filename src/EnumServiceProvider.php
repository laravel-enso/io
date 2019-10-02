<?php

namespace LaravelEnso\IO;

use LaravelEnso\IO\app\Enums\IOStatuses;
use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    public $register = [
        'ioStatuses' => IOStatuses::class,
    ];
}
