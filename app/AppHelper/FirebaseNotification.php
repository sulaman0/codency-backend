<?php

namespace App\AppHelper;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\WebPushConfig;

class FirebaseNotification
{
    public static function sendNotification(array $fcmTokens, $body)
    {
        $messaging = app('firebase.messaging');
        $messageAr = [];
        foreach ($fcmTokens as $fcmToken) {
            $v_local = CloudMessage::withTarget('token', $fcmToken)
                ->withNotification(Notification::create($body['head'], $body['body']))
                ->withDefaultSounds()
                ->withHighestPossiblePriority()
                ->withData($body['extra']);
            $messageAr[] = $v_local;
        }

        $response = $messaging->sendAll($messageAr);
        Log::info("Firebase_Push_Notification", [
            'response' => $response
        ]);
    }

}
