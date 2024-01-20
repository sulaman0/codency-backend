<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\AppHelper\FirebaseNotification;
use App\Http\Requests\Auth\Profile\UpdatePasswordRequest;
use App\Http\Requests\CallOnHomeRequest;
use App\Http\Resources\User\UserResource;
use App\Listeners\Registered\SendWelcomeEmailListener;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\Locations\LocationModel;
use App\Models\User;
use App\Models\Users\GroupsModel;
use App\Notifications\Users\SendWelcomeEmailToUsersNotifications;
use App\Service\Misc\DashboardService;
use App\Service\UsersService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
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

        FirebaseNotification::sendNotification([
            'eipdMQKKFSogNArX8naDgi:APA91bFddd2meYAYMbCCCWr4U8fAZmmpCnTcQGp7G-bvJLFuUSSMAthzvTnSWy8m-lJ1Gxnfd3GXL4QEI5z__S9k8EU--RrLFEh3uMeaG4vBbNv7WJ1W_u9kH-nn03IC_Gl_NS3ZPC73'
        ], [
            'head' => 'Fire Alarm ' . time(),
            'body' => 'Building 09 Hurry Up',
            'extra' => [
                'module' => 'ecg_alert',
                'ref' => 1,
                'web_url' => route('reports.code_pressed'),
            ]
        ]);

        dd("END");
        $messaging = app('firebase.messaging');
        $deviceToken = "";
        $message = CloudMessage::withTarget('token', $deviceToken)
            ->withNotification(Notification::create('TitleNew', 'BodyNew'))
            ->withDefaultSounds()
            ->withData(['key' => 'value']);

        $messages = [$message];

        $s = $messaging->sendAll($messages);
        dd($s);

        $message = CloudMessage::fromArray([
            'token' => $deviceToken,
            'notification' => [/* Notification data as array */], // optional
            'data' => [/* data array */], // optional
        ]);

        $messaging->send($message);


        dd($messaging);


        $factory = (new Factory)
            ->withServiceAccount(__DIR__ . '/codency_admin_firebase_sdk.json');
        $cloudMessaging = $factory->createMessaging();

        $message = CloudMessage::withTarget('topic', 'topic-1')
            ->withNotification(Notification::create('Title', 'Body'))
            ->withData(['key' => 'value']);

        $cloudMessaging->send($message);

        dd($cloudMessaging);

        $User = User::where('email', 'abc@gmail.com')->first();
        $User->password = Hash::make('testing09');
        $User->save();
        dd($User);
//        $User = User::where('email', 'qkhan.it@gmail.com')->first();
//        return view('email_templates.auth.welcome', [
//                'username' => "Mr. Sulaman Khan",
//                'emailTemplateTitle' => 'Welcome to Codency',
//                'email' => $User->email,
//                'password' => 12345678,
//            ]
//        );


//        $User = User::where('email', 'symikhan70@gmail.com')->first();
//        return view('email_templates.auth.welcome', [
//                'user' => $User,
//                'emailTemplateTitle' => 'Welcome to Codency'
//            ]
//        );

//        $User->notify(new SendWelcomeEmailToUsersNotifications());
//       dispatch(SendWelcomeEmailListener::class)
//        event(new Registered($User));
    }

    function usersList(UsersService $usersService, Request $request): JsonResponse|\App\Http\Resources\Users\UsersSearchListCollection
    {
        try {
            return $usersService->getAllUsersForSearch($request);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    function authorizePusherChannel(Request $request)
    {
        $pusher = new Pusher(
            env('PUSHER_APP_KEY', '2e90000284a3902c8da3'),
            env('PUSHER_APP_SECRET', '97d38e63930668cd77e5'),
            env('PUSHER_APP_ID', '1742362')
        );
        echo $pusher->authorizeChannel($request->channel_name, $request->socket_id);
        exit();
    }

    public function deleteModel(Request $request)
    {
        try {
            $status = $request->status == 0 ? 'active' : 'blocked';
            switch ($request->model) {
                case 'location':
                    LocationModel::find($request->ref)->update(['status' => $status]);
                    break;
                case 'ecgCode':
                    EcgCodesModel::find($request->ref)->update(['status' => $status]);
                    break;
                case 'user':
                    User::find($request->ref)->update(['status' => $status]);
                case 'group':
                    GroupsModel::find($request->ref)->delete();
                    break;
                case 'default':
                    break;
            }
            return AppHelper::sendSuccessResponse();
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    function loadDashboardContent(DashboardService $dashboardService, Request $request)
    {
        try {
            return $dashboardService->dashboardRecord($request);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    public function saveFcmToken(Request $request)
    {
        \App\Models\Users\UserDeviceModel::storeUserDeviceInformation(
            AppHelper::getLoggedInWebUser()->id,
            $request->token,
            'web'
        );
    }
}
