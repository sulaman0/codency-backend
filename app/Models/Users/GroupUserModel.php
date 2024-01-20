<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class GroupUserModel extends Model
{
    protected $table = 'group_user';

    public static function saveUserGroup($userId, $groupId)
    {
        $model = new GroupUserModel();
        $model->user_id = $userId;
        $model->group_id = $groupId;
        $model->save();
    }

    public static function saveUserGroupBulk($userIdAr, $groupId)
    {
        foreach ($userIdAr as $userId) {
            self::saveUserGroup($userId, $groupId);
        }
    }

    public static function saveUserGroupBulkInverse($groupIdAr, $userId)
    {
        foreach ($groupIdAr as $groupId) {
            self::saveUserGroup($userId, $groupId);
        }
    }

    public static function deleteByGroupId(mixed $id)
    {
        GroupUserModel::where('group_id', $id)->delete();
    }

    public static function deleteByUserId(mixed $id)
    {
        GroupUserModel::where('user_id', $id)->delete();
    }

    public static function getStaffIds(mixed $groupId)
    {
        return GroupUserModel::where('group_id', $groupId)->pluck('user_id')->toArray();
    }
}
