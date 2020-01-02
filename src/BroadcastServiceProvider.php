<?php

namespace LaravelEnso\IO;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Broadcast::channel(
            'operations.{userId}',
            fn ($user, $operationId) => (int) $user->id === (int) $operationId
        );

        Broadcast::channel('operations', fn ($user) => $user->isAdmin() || $user->isSupervisor());
    }
}
