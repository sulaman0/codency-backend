<?php

namespace App\Models\EcgCodes;

use App\Models\User;
use App\Models\Users\GroupUserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcgCodesAlertsAssignedToUsersModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_codes_alert_assigned_users';

    function isUserAllowToRespondEcgCode($userId, $ecgCodeId)
    {
        $groupIds = User::groupsIds($userId);
        return EcgCodesAlertsAssignedToUsersModel::whereIn('group_id', $groupIds)
            ->where('ecg_code_id', $ecgCodeId)->first();
    }

    function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->first();
    }

    function findCodesByIdAndCodeId($groupId, $codeId)
    {
        return EcgCodesAlertsAssignedToUsersModel::where('group_id', $groupId)->where('ecg_code_id', $codeId)->first();
    }

    function deleteCodesByCodeId($codeId)
    {
        return EcgCodesAlertsAssignedToUsersModel::where('ecg_code_id', $codeId)->delete();
    }

    function assignedCodesAlertsToUser($userId, $codeId)
    {
        $M = $this->findCodesByIdAndCodeId($userId, $codeId);
        if (empty($M)) {
            $M = new EcgCodesAlertsAssignedToUsersModel();
        }
        $M->group_id = $userId;
        $M->ecg_code_id = $codeId;
        $M->save();
    }
}
