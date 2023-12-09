<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Resources\Users\UsersSearchListCollection;
use App\Models\User;

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

    function getAllUsersForSearch(): \Illuminate\Http\JsonResponse
    {
        return AppHelper::sendSuccessResponse(true, 'found', ['data' => new UsersSearchListCollection($this->userModel->getAllUsersForSearch())]);
    }
}
