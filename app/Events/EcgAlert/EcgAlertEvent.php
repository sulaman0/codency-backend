<?php

namespace App\Events\EcgAlert;

use App\Http\Resources\EcgAlerts\EcgAlertsResource;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

// Pusher Implementation.
class EcgAlertEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public EcgAlertsResource $ecgAlertsResource;

    /**
     * Create a new event instance.
     */
    public function __construct(EcgAlertsResource $ecgAlertsResource)
    {
        $this->ecgAlertsResource = $ecgAlertsResource;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('ecg-alert-update'),
        ];
    }

    public function broadcastAs()
    {
        return 'ecg-alert-update';
    }
}
