<?php

namespace LaravelEnso\IO\Observers;

use Illuminate\Support\Facades\Event;
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
        Event::dispatch(new IOEvent($operation));
    }
}
