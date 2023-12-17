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

    function findCodesByIdAndCodeId($userId, $codeId)
    {
        return EcgCodesAlertsAssignedToUsersModel::where('user_id', $userId)->where('ecg_code_id', $codeId)->first();
    }

    function deleteCodesByCodeId($codeId)
    {
        return EcgCodesAlertsAssignedToUsersModel::where('ecg_code_id', $codeId)->first();
    }

    function assignedCodesAlertsToUser($userId, $codeId)
    {
        $M = $this->findCodesByIdAndCodeId($userId, $codeId);
        if (empty($M)) {
            $M = new EcgCodesAlertsAssignedToUsersModel();
        }
        $M->user_id = $userId;
        $M->ecg_code_id = $codeId;
        $M->save();
    }
}
