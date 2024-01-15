<?php

namespace App\Models\Users;

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

    public function createUpdateGroup($name, $description, $users, $id): bool
    {
        $groupModel = $this->findGroupById($id);
        if (empty($groupModel)) {
            $groupModel = new GroupsModel();
        }

        $groupModel->name = $name;
        $groupModel->description = $description;
        $groupModel->save();

        $users = User::whereIn($users)->get();
        $groupModel->users()->attach($users);
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
        return $this->belongsToMany(User::class);
    }

    public function getAllGroups(Request $request)
    {
        $groupModel = GroupsModel::where('id', '<>', 0);
        if (!empty($request->search)) {
            $groupModel->where('name', 'LIKE', '%' . $request->search . '%');
        }
        return $groupModel->paginate(10);
    }

}
