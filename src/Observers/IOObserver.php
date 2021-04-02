<?php

namespace LaravelEnso\IO\Observers;

use LaravelEnso\IO\Contracts\IOOperation;
use LaravelEnso\IO\Events\IOEvent;

class IOObserver
{
    public function created(IOOperation $operation)
    {
        $this->dispatch($operation);
    }

    public function updated(IOOperation $operation)
    {
        $this->dispatch($operation);
    }

    private function dispatch($operation)
    {
        IOEvent::dispatch($operation);
    }
}
