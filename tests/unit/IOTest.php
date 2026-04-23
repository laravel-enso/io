<?php

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use LaravelEnso\Core\Facades\Websockets;
use LaravelEnso\IO\Contracts\IOOperation;
use LaravelEnso\IO\Enums\IOTypes;
use LaravelEnso\IO\Events\IOEvent;
use LaravelEnso\IO\Observers\IOObserver;
use LaravelEnso\IO\WebsocketServiceProvider;
use LaravelEnso\Menus\Models\Menu;
use LaravelEnso\Permissions\Models\Permission;
use LaravelEnso\Roles\Enums\Roles;
use LaravelEnso\Roles\Models\Role;
use LaravelEnso\Users\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class IOTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $defaultUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed();
        $this->createOperationsTable();
        $this->admin = User::query()->whereRoleId(app(Roles::class)::Admin)->firstOrFail();
        $defaultRole = $this->role();

        $this->defaultUser = User::factory()->create([
            'role_id' => $defaultRole->id,
            'is_active' => true,
        ]);
    }

    #[Test]
    public function websocket_provider_registers_role_based_channels(): void
    {
        (new WebsocketServiceProvider($this->app))->boot();

        $this->actingAs($this->admin);
        $this->assertSame('operations', Websockets::all()->get('io'));

        $this->actingAs($this->defaultUser);
        $this->assertSame("operations.{$this->defaultUser->id}", Websockets::all()->get('io'));
    }

    #[Test]
    public function broadcast_event_targets_global_and_personal_channels_for_inferior_users(): void
    {
        $operation = TestIOOperation::create([
            'created_by' => $this->defaultUser->id,
            'created_at' => now()->subMinute(),
        ]);

        $event = new IOEvent($operation);
        $channels = array_map(
            static fn ($channel) => $channel->name,
            $event->broadcastOn()
        );

        $this->assertSame(['private-operations', "private-operations.{$this->defaultUser->id}"], $channels);
        $this->assertSame(app(IOTypes::class)::get($operation->operationType()), $event->broadcastAs());
        $this->assertSame('notifications', $event->broadcastQueue());
        $this->assertSame($operation->id, $event->broadcastWith()['operation']['id']);
    }

    #[Test]
    public function broadcast_event_targets_only_global_channel_for_superior_users(): void
    {
        $operation = TestIOOperation::create([
            'created_by' => $this->admin->id,
            'created_at' => now()->subMinute(),
        ]);

        $event = new IOEvent($operation);
        $channels = array_map(
            static fn ($channel) => $channel->name,
            $event->broadcastOn()
        );

        $this->assertSame(['private-operations'], $channels);
    }

    #[Test]
    public function observer_dispatches_events_when_operations_change(): void
    {
        $operation = TestIOOperation::create([
            'created_by' => $this->defaultUser->id,
            'created_at' => now(),
        ]);

        Event::fake([IOEvent::class]);

        $observer = new IOObserver();
        $observer->created($operation);
        $observer->updated($operation);

        Event::assertDispatched(IOEvent::class, 2);
    }

    private function createOperationsTable(): void
    {
        Schema::create('test_io_operations', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('created_by');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    private function role(): Role
    {
        $role = Role::factory()->create([
            'menu_id' => Menu::first(['id'])->id,
        ]);

        $role->permissions()->sync(Permission::pluck('id'));

        return $role;
    }
}

class TestIOOperation extends Model implements IOOperation
{
    protected $table = 'test_io_operations';

    protected $guarded = [];

    public function operationType(): int
    {
        return IOTypes::Export;
    }

    public function status(): int
    {
        return 20;
    }

    public function progress(): ?int
    {
        return 50;
    }

    public function broadcastWith(): array
    {
        return ['name' => 'Test Export'];
    }

    public function createdBy(): Relation
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function createdAt(): Carbon
    {
        return Carbon::parse($this->created_at);
    }
}
