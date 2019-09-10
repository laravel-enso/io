<?php

namespace LaravelEnso\IO\app\Events;

use Illuminate\Queue\SerializesModels;
use LaravelEnso\IO\app\Http\Resources\IO;
use Illuminate\Broadcasting\PrivateChannel;
use LaravelEnso\IO\app\Contracts\IOOperation;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class IOEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $operation;
    private $name;

    public function __construct(IOOperation $operation, $name)
    {
        $this->operation = $operation;
        $this->name = $name;
        $this->queue = 'notifications';
    }

    public function broadcastOn()
    {
        if ($this->operation->createdBy === null) {
            return new PrivateChannel('operations');
        }

        return $this->operation->createdBy->isAdmin()
            || $this->operation->createdBy->isSupervisor()
            ? new PrivateChannel('operations')
            : [
                new PrivateChannel('operations'),
                new PrivateChannel('operations.'.$this->operation->created_by),
            ];
    }

    public function broadcastWith()
    {
        return [
            'operation' => (new IO($this->operation))->resolve(),
        ];
    }

    public function broadcastAs()
    {
        return $this->name;
    }
}
