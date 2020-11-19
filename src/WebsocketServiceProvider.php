<?php

namespace LaravelEnso\IO;

use Illuminate\Support\Facades\App;
use LaravelEnso\Core\Facades\Websockets;
use LaravelEnso\Core\Models\User;
use LaravelEnso\Core\WebsocketServiceProvider as CoreServiceProvider;
use LaravelEnso\Roles\Enums\Roles;

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
