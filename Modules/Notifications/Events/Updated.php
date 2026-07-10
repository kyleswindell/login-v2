<?php
/*
|--------------------------------------------------------------------------
| File: Modules/Notifications/Events/Updated.php
| Purpose: Broadcasts updated notification payloads.
|--------------------------------------------------------------------------
*/

declare(strict_types=1);

namespace App\Modules\Notifications\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class Updated implements ShouldBroadcast
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * @param  array<string, mixed>  $notification
     */
    public function __construct(
        public readonly int $userId,
        public readonly array $notification,
    ) {}

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel("App.Models.User.{$this->userId}");
    }

    public function broadcastAs(): string
    {
        return 'notification.updated';
    }

    /**
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'notification' => $this->notification,
        ];
    }
}
