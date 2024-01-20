<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Requests\Staff\CreateStaffRequest;
use App\Http\Resources\Users\UsersSearchListCollection;
use App\Models\User;
use Illuminate\Http\Request;

class UsersService
{

    protected User $userModel;

    /**
     * @param User $user
     * @return void
     */

    public function __construct(User $user)
    {
        $this->userModel = $user;
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
            $request->group
        ));
    }
}
