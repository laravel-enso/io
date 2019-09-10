<?php

namespace LaravelEnso\IO\app\Observers;

use Illuminate\Support\Facades\Event;
use LaravelEnso\IO\app\Enums\IOEvents;
use LaravelEnso\IO\app\Events\IOEvent;
use LaravelEnso\IO\app\Enums\IOStatuses;
use LaravelEnso\IO\app\Contracts\IOOperation;

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
