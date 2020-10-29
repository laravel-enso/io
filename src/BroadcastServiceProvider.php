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
            fn ($user, $userId) => (int) $user->id === (int) $userId
        );

        Broadcast::channel('operations', fn ($user) => $user->isAdmin() || $user->isSupervisor());
    }
}
