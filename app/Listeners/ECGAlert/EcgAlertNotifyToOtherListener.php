<?php

namespace App\Listeners\ECGAlert;

use App\Events\EcgAlertNotificationEvent;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\User;
use App\Notifications\EcgAlert\EcgAlertNotification;


class EcgAlertNotifyToOtherListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EcgAlertNotificationEvent $event): void
    {
        /** @var $ecgAlertModel EcgAlertsModel */
        $ecgAlertModel = $event->ecgAlertsModel;
        $ecgAlertAssignedUsers = $ecgAlertModel->assignedUsers();
        foreach ($ecgAlertAssignedUsers as $ecgAlertAssignedUser) {
            $userModel = $ecgAlertAssignedUser->user();
            if ($userModel instanceof User) {
                $userModel->notify(new EcgAlertNotification($ecgAlertModel->id, $userModel->fcmToken(), $ecgAlertModel->ecg_code_nme));
            }
        }
    }
}
