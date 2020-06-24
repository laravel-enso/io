<?php

namespace LaravelEnso\IO\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use LaravelEnso\IO\Contracts\IOOperation;
use LaravelEnso\IO\Http\Resources\IO;

class IOEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private IOOperation $operation;
    private string $name;

    public function __construct(IOOperation $operation, string $name)
    {
        $this->operation = $operation;
        $this->name = $name;
        $this->queue = 'notifications';
    }

    public function broadcastOn()
    {
        return $this->shouldIncludeCreator()
            ? [
                new PrivateChannel('operations'),
                new PrivateChannel("operations.{$this->operation->created_by}"),
            ] : new PrivateChannel('operations');
    }

    public function broadcastWith()
    {
        return ['operation' => (new IO($this->operation))->resolve()];
    }

    public function broadcastAs()
    {
        return $this->name;
    }

    private function shouldIncludeCreator()
    {
        return $this->operation->createdBy
            && ! $this->operation->createdBy->isAdmin()
            && ! $this->operation->createdBy->isSupervisor();
    }
}
