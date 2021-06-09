<?php

namespace LaravelEnso\IO;

use LaravelEnso\Core\Facades\Websockets;
use LaravelEnso\Core\WebsocketServiceProvider as CoreServiceProvider;
use LaravelEnso\Users\Models\User;

class WebsocketServiceProvider extends CoreServiceProvider
{
    public function boot()
    {
        Websockets::register([
            'io' => fn (User $user) => $user->isAdmin() || $user->isSupervisor()
                ? 'operations'
                : 'operations.'.$user->id,
        ]);
    }
}
