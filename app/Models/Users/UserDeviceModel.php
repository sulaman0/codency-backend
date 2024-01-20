<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeviceModel extends Model
{
    use HasFactory;

    protected $table = 'user_devices';

    static function storeUserDeviceInformation(int $userId, string $fcmToken, string $deviceType)
    {
        $M = self::getByUserId($userId);
        if (empty($M)) {
            $M = new UserDeviceModel();
        }

        $M->user_id = $userId;
        $M->fcm_token = $fcmToken;
        $M->device_type = $deviceType;
        $M->save();
    }

    function fcm_token()
    {
        return $this->fcm_token;
    }

    public static function getByUserId($userId)
    {
        return UserDeviceModel::where('user_id', $userId)->first();
    }
}
