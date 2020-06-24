<?php

namespace LaravelEnso\IO\Traits;

use LaravelEnso\IO\Enums\IOStatuses;

trait HasIOStatuses
{
    public function name()
    {
        return $this->name;
    }

    public function entries()
    {
        return $this->entries;
    }

    public function status()
    {
        return $this->status;
    }

    public function startProcessing()
    {
        $this->setStatus(IOStatuses::Processing);
    }

    public function endOperation()
    {
        $this->setStatus(IOStatuses::Finalized);
    }

    public function setStatus($status)
    {
        $this->update(['status' => $status]);
    }
}
