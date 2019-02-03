<?php

namespace LaravelEnso\IO\app\Observers;

use LaravelEnso\IO\app\Enums\IOEvents;
use LaravelEnso\IO\app\Events\IOEvent;
use LaravelEnso\IO\app\Contracts\IOOperation;

class IOObserver
{
    public function created(IOOperation $operation)
    {
        $this->event($operation);
    }

    public function updated(IOOperation $operation)
    {
        $this->event($operation);
    }

    private function event($operation)
    {
        if (IOEvents::has($operation->status())) {
            event(new IOEvent(
                $operation, IOEvents::get($operation->status())
            ));
        }
    }
}
