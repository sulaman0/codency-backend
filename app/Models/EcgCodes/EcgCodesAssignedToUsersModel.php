<?php

namespace App\Models\EcgCodes;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcgCodesAssignedToUsersModel extends Model
{
    use HasFactory;

    protected $table = 'ecg_codes_assigned_users';

    function ecgCodes()
    {
        return $this->hasOne(EcgCodesModel::class, 'id', 'ecg_code_id')->first();
    }

    function findCodesByIdAndCodeId($groupId, $codeId)
    {
        return EcgCodesAssignedToUsersModel::where('group_id', $groupId)->where('ecg_code_id', $codeId)->first();
    }

    function deleteCodesByIdAndCodeId($codeId)
    {
        return EcgCodesAssignedToUsersModel::where('ecg_code_id', $codeId)->delete();
    }

    function assignedCodesToUser($userId, $codeId)
    {
        $M = $this->findCodesByIdAndCodeId($userId, $codeId);
        if (empty($M)) {
            $M = new EcgCodesAssignedToUsersModel();
        }
        $M->group_id = $userId;
        $M->ecg_code_id = $codeId;
        $M->save();
    }

    public static function getStaffIds(mixed $ecgCodeId)
    {
        return EcgCodesAssignedToUsersModel::where('ecg_code_id', $ecgCodeId)->pluck('user_id')->toArray();
    }
}
