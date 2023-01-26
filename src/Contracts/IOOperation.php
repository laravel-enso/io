<?php

namespace LaravelEnso\IO\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use LaravelEnso\IO\Enums\IOStatus;
use LaravelEnso\IO\Enums\IOType;

interface IOOperation
{
    public function operationType(): IOType;

    public function status(): IOStatus;

    public function progress(): ?int;

    public function broadcastWith(): array;

    public function createdBy(): Relation;

    public function createdAt(): Carbon;
}
