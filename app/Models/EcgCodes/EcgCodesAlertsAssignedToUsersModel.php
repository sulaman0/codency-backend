<?php

namespace App\Models\EcgCodes;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcgCodesAlertsAssignedToUsersModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_codes_alert_assigned_users';

    function isUserAllowToRespondEcgCode($userId, $ecgCodeId)
    {
        return EcgCodesAlertsAssignedToUsersModel::where('user_id', $userId)->where('ecg_code_id', $ecgCodeId)->first();
    }

    function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->first();
    }
}
