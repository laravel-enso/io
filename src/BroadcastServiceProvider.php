<?php

namespace LaravelEnso\IO;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $himself = fn ($user, $userId) => (int) $user->id === (int) $userId;
        Broadcast::channel('operations.{userId}', $himself);

        $superiorRole = fn ($user) => $user->isAdmin() || $user->isSupervisor();
        Broadcast::channel('operations', $superiorRole);
    }
}
