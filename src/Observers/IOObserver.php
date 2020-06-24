<?php

namespace LaravelEnso\IO\Observers;

use Illuminate\Support\Facades\Event;
use LaravelEnso\IO\Contracts\IOOperation;
use LaravelEnso\IO\Enums\IOEvents;
use LaravelEnso\IO\Enums\IOStatuses;
use LaravelEnso\IO\Events\IOEvent;

class IOObserver
{
    public function creating(IOOperation $operation)
    {
        $operation->status = IOStatuses::Waiting;
    }

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
        if (IOEvents::has($operation->status())) {
            Event::dispatch(new IOEvent(
                $operation->load('createdBy.avatar'),
                IOEvents::get($operation->status())
            ));
        }
    }
}
