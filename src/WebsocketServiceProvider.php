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
        $roles = App::make(Roles::class);

        Websockets::register([
            'io' => fn (User $user) => in_array($user->role_id, [$roles::Admin, $roles::Supervisor])
                ? 'operations'
                : 'operations.'.$user->id,
        ]);
    }
}
