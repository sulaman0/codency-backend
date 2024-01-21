<?php

namespace App\Events;

use App\Models\EcgAlert\EcgAlertsModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EcgAlertNotificationEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public EcgAlertsModel $ecgAlertsModel;
    public string $action;

    /**
     * Create a new event instance.
     */
    public function __construct(EcgAlertsModel $ecgAlertsModel, $action)
    {
        //
        $this->ecgAlertsModel = $ecgAlertsModel;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
