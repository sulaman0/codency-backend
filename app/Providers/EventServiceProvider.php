<?php

namespace App\Providers;

use App\Events\EcgAlert\EcgAlertEvent;
use App\Events\EcgAlertNotificationEvent;
use App\Listeners\ECGAlert\EcgAlertNotifyToOtherListener;
use App\Listeners\Registered\SendWelcomeEmailListener;
use App\Models\Locations\RoomModel;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            // SendEmailVerificationNotification::class,
            SendWelcomeEmailListener::class
        ],

        // WebSocket || Pusher Implementation.
        EcgAlertEvent::class => [],

        // Firebase & Push Notification
        EcgAlertNotificationEvent::class => [
            EcgAlertNotifyToOtherListener::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        RoomModel::observe(RoomModel::class);

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
