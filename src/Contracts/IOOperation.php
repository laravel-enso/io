<?php

namespace LaravelEnso\IO\Contracts;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;

interface IOOperation
{
    public function operationType(): int;

    public function status(): int;

    public function progress(): ?int;

    public function broadcastWith(): array;

    public function createdBy(): Relation;

    public function createdAt(): Carbon;
}
