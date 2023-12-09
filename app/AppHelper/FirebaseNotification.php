<?php

namespace App\AppHelper;

use Illuminate\Support\Facades\Log;

class FirebaseNotification
{
    const TOKEN = "AAAAtFBubiU:APA91bHNNIFGdzZg-chRITjxQxK1RkXOwxZkhmHVNhiD0fnWkz6NxhDYtQIiyhtOOeDuj-_erAy3j-tVHPnafW-o5IdUzX6OSj9jCw1kfvLsxOHEhrN4i_usM-gA1DPjs7O33eEfQKOk	";

    /**
     * @Purpose Send Firebase Push Notifications
     * @param array $notification it sample will be
     *  $notification = ['title' => 'This it title of notificaiton' , 'body' => 'Body of Notifictionasdf',  'data' => [ 'key' => 'value']]
     * @param array $fcmIds
     * @param bool $adminPortal
     * @return bool|mixed|string
     */
    static function sendFireBaseNotification(array $notification, array $fcmIds, bool $adminPortal = false)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $notification['sound'] = 'default';

        $notification['data']['title'] = $notification['title'];
        $notification['data']['body'] = $notification['body'];

        $fields = array(
            'registration_ids' => $fcmIds,
//            'notification' => $notification,
            'data' => $notification['data']
        );


        $Key = self::TOKEN;
        $headers = array(
            'Authorization:key=' . $Key,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        if ($result === FALSE) {
            return curl_error($ch);
        }
        curl_close($ch);
        return array_merge(json_decode($result, true), $fields);
    }

}
