<?php

namespace LaravelEnso\IO\app\Contracts;

interface IOOperation
{
    public function createdBy();

    public function name();

    public function type();

    public function status();

    public function entries();
}
