<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class LoginAccessRecorded implements ShouldBroadcastNow
{
    public function broadcastOn(): array
    {
        return [new PrivateChannel('login-accesses')];
    }

    public function broadcastAs(): string
    {
        return 'login.recorded';
    }

    public function broadcastWith(): array
    {
        // Only signal a refresh; personal data stays in the authorized HTTP endpoint.
        return [];
    }
}
