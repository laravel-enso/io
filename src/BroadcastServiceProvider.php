<?php

namespace LaravelEnso\IO;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Broadcast::channel('operations.{userId}', function ($user, $operationId) {
            return (int) $user->id === (int) $operationId;
        });

        Broadcast::channel('operations', function ($user) {
            return $user->isAdmin() || $user->isSupervisor();
        });
    }
}
