<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Requests\Staff\CreateStaffRequest;
use App\Http\Resources\EcgCodes\SearchList\EcgCodesSearchListCollection;
use App\Http\Resources\User\UserAssignLocationCollection;
use App\Http\Resources\Users\UsersSearchListCollection;
use App\Models\Locations\RoomModel;
use App\Models\User;
use App\Models\Users\UserLocationModel;
use Illuminate\Http\Request;

class UsersService
{

    protected User $userModel;
    private UserLocationModel $userLocationModel;

    /**
     * @param User $user
     * @return void
     */

    public function __construct(User $user, UserLocationModel $userLocationModel)
    {
        $this->userModel = $user;
        $this->userLocationModel = $userLocationModel;
    }

    ## This if for Mobile App Model box search
    public function getAllUsersForSearch(Request $request): \Illuminate\Http\JsonResponse
    {
        return AppHelper::sendSuccessResponse(
            true,
            'found',
            new UsersSearchListCollection($this->userModel->getAllUsersForSearch($request))
        );
    }

    public function getAllUsers(Request $request)
    {
        return view('staff.table', [
            'users' => $this->userModel->getAllUsersAdmin($request)
        ])->render();
    }

    public function createStaff(CreateStaffRequest $request): \Illuminate\Http\JsonResponse
    {
        return AppHelper::sendSuccessResponse(true, 'created', $this->userModel->createOrUpdateStaff(
            $request->name,
            $request->email,
            $request->designation,
            $request->phone,
            $request->location,
            $request->password,
            $request->status,
            $request->id,
            $request->group,
            $request->room
        ));
    }

    public function codeInteractionTable($id): string
    {
        return view('staff.code_interaction', [
            'receiverTable' => $this->userModel->findById($id)->codeInteraction()->paginate(5),
            'user_id' => $id
        ])->render();
    }

    public function locationAssignTable($id, $wantJson)
    {
        $locations = $this->userModel->findById($id)->locations();
        if ($wantJson) {
            return AppHelper::sendSuccessResponse(true, 'found',
                new UserAssignLocationCollection($locations->groupBy('building_id')->paginate(1000))
            );
        } else {
            return view('staff.location_assigned', [
                'userLocation' => $locations->paginate(5),
                'user_id' => $id,
                'allLocations' => RoomModel::getDistinctRooms()
            ])->render();
        }

    }

    function assignLocation($userId, $roomLocationId): \Illuminate\Http\JsonResponse
    {
        $this->userLocationModel->storeLoc($roomLocationId, $userId);
        return AppHelper::sendSuccessResponse(true);
    }
}
