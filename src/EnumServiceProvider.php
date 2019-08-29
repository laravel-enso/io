<?php

namespace LaravelEnso\IO;

use LaravelEnso\IO\app\Enums\IOStatuses;
use LaravelEnso\Enums\EnumServiceProvider as ServiceProvider;

class EnumServiceProvider extends ServiceProvider
{
    protected $register = [
        'ioStatuses' => IOStatuses::class,
    ];
}
