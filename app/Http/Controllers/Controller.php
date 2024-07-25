<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\AppHelper\FirebaseNotification;
use App\Events\EcgAlert\EcgAlertEvent;
use App\Http\Requests\Auth\Profile\UpdatePasswordRequest;
use App\Http\Requests\CallOnHomeRequest;
use App\Http\Resources\EcgAlerts\EcgAlertsResource;
use App\Http\Resources\User\UserResource;
use App\Listeners\Registered\SendWelcomeEmailListener;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\Locations\FloorModel;
use App\Models\Locations\LocationModel;
use App\Models\Locations\RoomModel;
use App\Models\RoomAndAlert\RoomAlertModel;
use App\Models\User;
use App\Models\Users\GroupsModel;
use App\Notifications\Users\SendWelcomeEmailToUsersNotifications;
use App\Service\Misc\DashboardService;
use App\Service\UsersService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    function convertTextToSound($text, $fileName)
    {
        if (Storage::disk('audio')->exists($fileName)) {
            Storage::disk('audio')->delete($fileName); // delete the audio file if exits.
        }

        // Create file path
        $path = Storage::disk('audio')->path('/');

        $data = [
            'token' => 'ec2e672c45df5ba3a694af6886fd5a25',
            'email' => 'qkhan.it@gmail.com',
            'voice' => 'John',
            'text' => $text,
            'format' => 'mp3',
            'speed' => 1,
            'pitch' => 0,
            'emotion' => 'good',
        ];
        $url = "https://speechgen.io/index.php?r=api/text";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

        $rawResponse = $response = curl_exec($ch);
        $response = json_decode($response, true);
        if (curl_errno($ch)) {
            var_dump("Connection error with text recognition server, " . curl_error($ch));
        } else {
            var_dump($response);
            if ($response["status"] == 1) {
                //Copy
                echo " ok " . $response["file"];
                copy($response["file"], $path . $response["format"]);
                dd($response);
            } else {
                //Error, no voiceover possible
                echo $response["error"];
            }
        }
        curl_close($ch);

        return [
            'api_response' => $rawResponse,
        ];
    }

    function testFunction(Request $request)
    {

        RoomModel::where('audio_status', 'pending')->chunk(function ($rooms) {
            foreach ($rooms as $room) {
                // set the status location is now in audio process.
                $room->setAudioCompilingStatus('processing');
                // location string.
                $audio = $room->locationName();
                $ecgAlerts = EcgAlertsModel::all();
                foreach ($ecgAlerts as $ecgAlert) {
                    // set the status for alert code.
                    $ecgAlert->setAudioCompilingStatus('processing');

                    // make an audio file
                    $audio = sprintf("%s %s", $audio, $ecgAlert->ecg_code_nme);

                    $audioParse = $this->convertTextToSound();
                    $fileName = sprintf("%s_%s.mp3", $room->id, $ecgAlert->id);

                    if ($audioParse && Storage::disk('audio')->exists($fileName)) {
                        RoomAlertModel::saveAudio(
                            $room->id,
                            $ecgAlert->id,
                            '',
                            $audio
                        );
                        $room->setAudioCompilingStatus('synced');
                        $ecgAlert->setAudioCompilingStatus('synced');

                    }
                }
            }
        });
        EcgAlertsModel::where('audio_status', 'pending')->chunk(100, function ($ecgAlerts) {
            foreach ($ecgAlerts as $alert) {
                $alert->setAudioCompilingStatus('processing');
                $audio = $alert->ecg_code_nme;
                $rooms = RoomModel::all();
                foreach ($rooms as $room) {
                    $room->setAudioCompilingStatus('processing');
                    $audio = sprintf("%s %s", $room->locationName(), $audio);
                    $audioParse = $this->convertTextToSound();
                    $fileName = sprintf("%s_%s.mp3", $room->id, $alert->id);

                    if ($audioParse && Storage::disk('audio')->exists($fileName)) {
                        RoomAlertModel::saveAudio(
                            $room->id,
                            $alert->id,
                            '',
                            $audio
                        );
                        $room->setAudioCompilingStatus('synced');
                        $alert->setAudioCompilingStatus('synced');
                    }
                }
            }
        });


//        $this->convertTextToSound();
        dd("=== END");

//        $ecgAlertModel = EcgAlertsModel::find(125);
//        ## Send this notification to all other apps.
//        // Doing this with PUSHER
//        EcgAlertEvent::broadcast(new EcgAlertsResource($ecgAlertModel));
//        //dump(new EcgAlertsResource($ecgAlertModel));
//        dd("Sent This ONe.");
        $token = $request->get('token',
            'dF1UfZTERYadIrTguxgA68:APA91bFfCNKcC0tBXKFDU6CXBpbXau1P6daujx-9DTsbhkeXNkkF3yvXLHHaNmHc8iQ2C6oRlBYsHYRj5kpvrMiG-T0oKloEwS4a_WM_jxgdSkDLB8SPwymzJf5PVk7Bh5Y79XvcRAa5');
        $deviceType = $request->get('device_type', 'android');
        $token = [
            'device_type' => $deviceType,
            'fcm_token' => $token,
        ];
        $res = FirebaseNotification::sendNotification([
            $token
        ], [
            'head' => 'Fire Alarm Manual URL',
            'body' => 'Building 09 Hurry Up',
            'extra' => [
                'module' => 'ecg_alert',
                'ref' => 1,
                'web_url' => route('reports.code_pressed'),
                'title' => "This is new title",
                'body' => "this is the body",
                'message' => "This is ehead"
            ]
        ]);


        dump($token);
        dd($res);

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
                    if ($request->type == 'floor') {
                        FloorModel::find($request->ref)->update(['status' => $status]);
                    } else if ($request->type == 'room') {
                        RoomModel::find($request->ref)->update(['status' => $status]);
                    } else {
                        LocationModel::find($request->ref)->update(['status' => $status]);
                    }
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
