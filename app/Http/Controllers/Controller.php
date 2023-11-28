<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\Http\Requests\Auth\Profile\UpdatePasswordRequest;
use App\Http\Requests\CallOnHomeRequest;
use App\Http\Resources\User\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    function callOnHome(CallOnHomeRequest $request)
    {

    }

    function updatePassword(UpdatePasswordRequest $request): JsonResponse
    {
        try {
            $IsProfileUpdated = User::updateMyProfilePassword($request);
            return AppHelper::sendSuccessResponse($IsProfileUpdated,
                $IsProfileUpdated ? 'common.password_has_been_updated' : 'common.failed_to_update_password',
                new UserResource(User::getProfileById(AppHelper::getUserFromRequest($request)->id), true)
            );
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    function testFunction()
    {
        $U = new User();
        $U->name = "SLMN";
        $U->email = "abc@gmail.com";
        $U->designation = "abc@gmail.com";
        $U->password = Hash::make('testing09');
        $U->save();
    }
}
