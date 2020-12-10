<?php

namespace LaravelEnso\IO\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;
use LaravelEnso\IO\Enums\IOTypes;
use LaravelEnso\IO\Http\Resources\IO;

class IOEvent implements ShouldBroadcast
{
    use SerializesModels;

    private Model $operation;

    public function __construct(Model $operation)
    {
        $this->operation = $operation;

        $this->broadcastQueue = 'notifications';
    }

    public function broadcastOn()
    {
        $channels = [new PrivateChannel('operations')];

        if ($this->inferiorRole()) {
            $channels[] = new PrivateChannel(
                "operations.{$this->operation->created_by}"
            );
        }

        return $channels;
    }

    public function broadcastWith()
    {
        $this->operation->load('createdBy.avatar', 'createdBy.person');

        return ['operation' => (new IO($this->operation))->resolve()];
    }

    public function broadcastAs()
    {
        return IOTypes::get($this->operation->operationType());
    }

    private function inferiorRole(): bool
    {
        return ! $this->operation->createdBy->isAdmin()
            && ! $this->operation->createdBy->isSupervisor();
    }
}
