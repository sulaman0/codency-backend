<?php

namespace App\Listeners\ECGAlert;

use App\AppHelper\AppHelper;
use App\AppHelper\FirebaseNotification;
use App\Events\EcgAlertNotificationEvent;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\User;
use App\Models\Users\GroupUserModel;
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
        $action = $event->action;
        $alarmTriggeredById = $ecgAlertModel->alarm_triggered_by_id;

        $ecgAlertAssignedGroups = $ecgAlertModel->assignedUsers();
        $fcmAr = [];
        foreach ($ecgAlertAssignedGroups as $ecgAlertAssignedGroup) {
            $users = GroupUserModel::getStaffIds($ecgAlertAssignedGroup->group_id);
            foreach ($users as $user) {
                $userModel = User::findById($user);
                if ($userModel instanceof User) {

                    if ($action == 'created') {

                        // User id is not equal.
                        if ($alarmTriggeredById <> $userModel->id) {
                            $fcmToken = $userModel->fcmToken();
                            if (!empty($fcmToken)) {
                                $fcmAr[] = $fcmToken;
                            }
                            // On Action Created
                            $userModel->notify(new EcgAlertNotification(
                                $ecgAlertModel->id,
                                $ecgAlertModel->ecg_code_nme,
                                $ecgAlertModel->locationNME(),
                            ));
                        }

                    } elseif ($action == 'manager_accepted' || $action == 'manager_rejected') {
                        // User id is not equal.
                        if ($ecgAlertModel->respond_by_id <> $userModel->id) {
                            $fcmToken = $userModel->fcmToken();
                            if (!empty($fcmToken)) {
                                $fcmAr[] = $fcmToken;
                            }
                        }
                    } elseif ($action == 'alarm_played') {
                        // Sent to all
                        $fcmToken = $userModel->fcmToken();
                        if (!empty($fcmToken)) {
                            $fcmAr[] = $fcmToken;
                        }
                    }

                }

            }
        }

        $this->sendMobileNotification(
            $fcmAr,
            $ecgAlertModel,
            $action
        );
    }

    private function sendMobileNotification($fcmAr, EcgAlertsModel $ecgAlertsModel, $action = null)
    {
        $head = $ecgAlertsModel->ecg_code_nme;
        $body = 'Location: ' . $ecgAlertsModel->locationNME();
        if (!empty($action) && $action == 'manager_accepted') {
            $head = $ecgAlertsModel->ecg_code_nme . ' Accepted By ' . $ecgAlertsModel->respondedBy()->name;
        } elseif (!empty($action) && $action == 'manager_rejected') {
            $head = $ecgAlertsModel->ecg_code_nme . ' Rejected By ' . $ecgAlertsModel->respondedBy()->name;
        } elseif (!empty($action) && $action == 'alarm_played') {
            $head = $ecgAlertsModel->ecg_code_nme . ' Played To Amplifier';
        }

        FirebaseNotification::sendNotification($fcmAr, [
            'head' => $head,
            'body' => $body,
            'extra' => [
                'module' => 'ecg_alert',
                'ref' => $ecgAlertsModel->id,
                'web_url' => route('reports.code_pressed')
            ]
        ]);
    }
}
