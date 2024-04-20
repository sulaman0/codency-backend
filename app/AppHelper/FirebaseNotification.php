<?php

namespace App\AppHelper;

use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseNotification
{
    public static function sendNotification(array $fcmTokens, $body)
    {
        try {
            $messaging = app('firebase.messaging');
            $messageAr = [];
            foreach ($fcmTokens as $fcmToken) {
                if (empty($fcmToken['fcm_token'])) {
                    continue;
                }

                if ($fcmToken['device_type'] == 'android') {

                    $message = CloudMessage::new()
                        ->withTarget('token', $fcmToken['fcm_token'])
                        ->withData($body['extra']);


                    Firebase::messaging()->send($message);
//                dump($message);

                    // for android don't send notification array key.
//                $v_local = CloudMessage::withTarget('token', $fcmToken['fcm_token'])
//                    ->withDefaultSounds()
//                    ->withHighestPossiblePriority()
//                    ->withData($body['extra']);
                } else {
                    // for ios & web send notification key
                    $v_local = CloudMessage::withTarget('token', $fcmToken['fcm_token'])
                        ->withNotification(Notification::create($body['head'], $body['body']))
                        ->withDefaultSounds()
                        ->withHighestPossiblePriority()
                        ->withData($body['extra']);
                }

                if (!empty($v_local)) {
                    $messageAr[] = $v_local;
                }
            }

            if (!empty($messageAr)) {
                $response = $messaging->sendAll($messageAr);
                return $response;
            }
        } catch (\Exception $exception) {
            AppHelper::logErrorException($exception);
            return [];
        }
    }

}
