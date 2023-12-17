<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\Http\Requests\Auth\Profile\UpdatePasswordRequest;
use App\Http\Requests\CallOnHomeRequest;
use App\Http\Resources\User\UserResource;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\Locations\LocationModel;
use App\Models\User;
use App\Service\UsersService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Pusher\Pusher;

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

    function usersList(UsersService $usersService): JsonResponse|\App\Http\Resources\Users\UsersSearchListCollection
    {
        try {
            return $usersService->getAllUsersForSearch();
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    function authorizePusherChannel(Request $request)
    {
        $pusher = new Pusher(env('PUSHER_APP_KEY', 'f0c4b5800196a5c61a74'), env('PUSHER_APP_SECRET', 'ea4dbdb5a749ae44d02c'), env('PUSHER_APP_ID', '1502051'));
        echo $pusher->authorizeChannel($request->channel_name, $request->socket_id);
        exit();
    }

    function deleteModel(Request $request)
    {
        try {
            switch ($request->model) {
                case 'location':
                    LocationModel::find($request->ref)->delete();
                    break;
                case 'ecgCode':
                    EcgCodesModel::find($request->ref)->delete();
                    break;
                case 'user':
                    User::find($request->ref)->delete();
                    break;
            }
            return AppHelper::sendSuccessResponse();
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }
}
