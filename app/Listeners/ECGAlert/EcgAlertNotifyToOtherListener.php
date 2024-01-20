<?php

namespace App\Listeners\ECGAlert;

use App\AppHelper\FirebaseNotification;
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
        $fcmAr = [];
        foreach ($ecgAlertAssignedUsers as $ecgAlertAssignedUser) {
            $userModel = $ecgAlertAssignedUser->user();
            if ($userModel instanceof User) {
                $fcmAr[] = $userModel->fcmToken();
                $userModel->notify(new EcgAlertNotification(
                    $ecgAlertModel->id,
                    $ecgAlertModel->ecg_code_nme,
                    $ecgAlertModel->locationNME(),
                ));
            }
        }

        $this->sendMobileNotification($fcmAr,
            $ecgAlertModel->ecg_code_nme,
            $ecgAlertModel->locationNME(),
            $ecgAlertModel->id
        );
    }

    private function sendMobileNotification($fcmAr, $name, $loc, $id)
    {
        FirebaseNotification::sendNotification($fcmAr, [
            'head' => $name,
            'body' => 'Location: ' . $loc,
            'extra' => [
                'module' => 'ecg_alert',
                'ref' => $id
            ]
        ]);
    }
}
