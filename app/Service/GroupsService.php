<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Requests\Group\CreateGroupRequest;
use App\Http\Requests\Staff\CreateStaffRequest;
use App\Http\Resources\Users\UsersSearchListCollection;
use App\Models\User;
use App\Models\Users\GroupsModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupsService
{

    protected GroupsModel $group;

    /**
     * @param User $user
     * @return void
     */

    public function __construct(GroupsModel $groupsModel)
    {
        $this->group = $groupsModel;
    }

    public function getAllGroups(Request $request): string
    {
        return view('groups.table', [
            'groups' => $this->group->getAllGroups($request)
        ])->render();
    }

    public function createGroup(CreateGroupRequest $request): JsonResponse
    {
        return AppHelper::sendSuccessResponse(true, 'created',
            $this->group->createUpdateGroup(
                $request->name,
                $request->description,
                $request->users
            ));
    }
}
