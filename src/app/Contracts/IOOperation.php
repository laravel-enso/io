<?php

namespace LaravelEnso\IO\app\Contracts;

use Illuminate\Database\Eloquent\Relations\Relation;

interface IOOperation
{
    public function createdBy() : Relation;

    public function name();

    public function type();

    public function status();

    public function entries();

    public function setStatus($status);

    public function startProcessing();

    public function endOperation();
}
