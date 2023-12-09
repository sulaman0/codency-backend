<?php

namespace App\Service;

use App\Http\Resources\Users\UsersSearchListCollection;
use App\Models\User;

class UsersService
{

    protected User $userModel;

    /**
     * @param User $user
     * @return void
     */
    function __constructor(User $user)
    {
        $this->userModel = $user;
    }

    function getAllUsersForSearch(): UsersSearchListCollection
    {
        return new UsersSearchListCollection($this->userModel->getAllUsersForSearch());
    }
}
