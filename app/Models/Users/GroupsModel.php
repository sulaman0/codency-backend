<?php

namespace App\Models\Users;

use App\AppHelper\AppHelper;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

class GroupsModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'groups';

    public function createUpdateGroup($name, $description, $users, $id = null): bool
    {
        $groupModel = $this->findGroupById($id);
        $isEdit = true;
        if (empty($groupModel)) {
            $groupModel = new GroupsModel();
            $isEdit = false;
        }

        $groupModel->name = $name;
        $groupModel->description = $description;
        $groupModel->created_by_id = AppHelper::getLoggedInWebUser()->id;
        $groupModel->save();

        if ($isEdit) {
            GroupUserModel::deleteByGroupId($groupModel->id);
        }

        GroupUserModel::saveUserGroupBulk($users, $groupModel->id);
        return true;
    }

    public function findGroupById($id)
    {
        return GroupsModel::find($id);
    }

    public function deleteGroup($id)
    {
        $this->findGroupById($id)->delete();
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'group_user', 'group_id');
    }

    public function usersArray($onlyIds = false): array
    {
        if ($onlyIds) {
            return $this->users()->pluck('group_user.user_id')->toArray();
        }
        return $this->users()->get()->toArray();
    }

    public function getAllGroups(Request $request)
    {
        $groupModel = GroupsModel::where('id', '<>', 0);
        if (!empty($request->search)) {
            $groupModel->where('name', 'LIKE', '%' . $request->search . '%');
        }
        return $groupModel->paginate(10);
    }

    public function findById($id)
    {
        return GroupsModel::find($id);
    }

    public function getAllGroupsSearch()
    {
        return GroupsModel::all();
    }

}
