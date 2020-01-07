<?php

namespace LaravelEnso\IO\App\Observers;

use Illuminate\Support\Facades\Event;
use LaravelEnso\IO\App\Contracts\IOOperation;
use LaravelEnso\IO\App\Enums\IOEvents;
use LaravelEnso\IO\App\Enums\IOStatuses;
use LaravelEnso\IO\App\Events\IOEvent;

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
