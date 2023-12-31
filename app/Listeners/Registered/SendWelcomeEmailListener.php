<?php

namespace App\Listeners\Registered;

use App\Models\User;
use App\Notifications\EcgAlert\EcgAlertNotification;
use App\Notifications\Users\SendWelcomeEmailToUsersNotifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendWelcomeEmailListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        /** @var $user User */
        $user = $event->user;
        $user->notify(new SendWelcomeEmailToUsersNotifications());
    }
}
