<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Events\EcgAlert\EcgAlertEvent;
use App\Events\EcgAlertNotificationEvent;
use App\Http\Requests\EcgCodes\NewEcgCodeAlertRequest;
use App\Http\Requests\EcgCodes\RespondEcgCodeRequest;
use App\Http\Resources\EcgAlerts\EcgAlertsCollection;
use App\Http\Resources\EcgAlerts\EcgAlertsResource;
use App\Http\Resources\EcgAlerts\UnPlayedAlarmCollection;
use App\Models\Amplifier\EcgAmplifierStatusModel;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\EcgCodes\EcgCodesAlertsAssignedToUsersModel;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\User;
use App\Models\Users\UserLocationModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;


class EcgAlertsService
{
    protected EcgCodesModel $ecgCodesModel;
    protected EcgAlertsModel $ecgAlertsModel;
    protected EcgCodesAlertsAssignedToUsersModel $ecgCodesAlertsAssignedToUsersModel;
    private EcgAmplifierStatusModel $ecgAmplifierStatusModel;

    /**
     * @param EcgCodesModel $ecgCodesModel
     * @param EcgAlertsModel $ecgAlertsModel
     */
    public function __construct(
        EcgCodesModel                      $ecgCodesModel, EcgAlertsModel $ecgAlertsModel,
        EcgCodesAlertsAssignedToUsersModel $ecgCodesAlertsAssignedToUsersModel,
        EcgAmplifierStatusModel            $ecgAmplifierStatusModel)
    {
        $this->ecgCodesModel = $ecgCodesModel;
        $this->ecgAlertsModel = $ecgAlertsModel;
        $this->ecgCodesAlertsAssignedToUsersModel = $ecgCodesAlertsAssignedToUsersModel;
        $this->ecgAmplifierStatusModel = $ecgAmplifierStatusModel;
    }

    /**
     * @throws Exception
     */
    public function pressCode(NewEcgCodeAlertRequest $request)
    {
        ## User Model
        $loggedInUser = AppHelper::getUserFromRequest($request);
        ## User Location
        $userLocation = UserLocationModel::find($request->loc_id);
        ## EcgCode Model
        $ecgCodeModel = $this->ecgCodesModel->findById($request->code_id);
        ## Save Alert
        $ecgAlertModel = $this->ecgAlertsModel->saveAlert(
            $request->code_id,
            $ecgCodeModel->name,
            $request->loc_id, // is, user_location_id
            $userLocation->locationNme(),
            $loggedInUser->id,
            AppHelper::getMySQLFormattedDateTime(Carbon::now()),
            $ecgCodeModel->action
        );
        if ($ecgAlertModel) {
            $this->sentToDevices($ecgAlertModel);
            if ($ecgCodeModel->action == "sent_to_amplifier_directly") {
                ## Send alert directly
                return $this->sendToAmplifier($ecgAlertModel, $ecgCodeModel);
            }

        } else {
            throw new BadRequestException("Failed to Save the Alert");
        }
    }

    public function sentToDevices($ecgAlertModel, $responseAction = 'created')
    {
        ## Send this notification to all other apps.
        // Doing this with PUSHER
        EcgAlertEvent::broadcast(new EcgAlertsResource($ecgAlertModel));
        // Doing firebase notification.
        EcgAlertNotificationEvent::dispatch(
            $ecgAlertModel,
            $responseAction,
        );
    }

    /**
     * @throws Exception
     */
    public function respondToCde(RespondEcgCodeRequest $request, $ecgAlertId)
    {
        ## User Model
        $loggedInUser = AppHelper::getUserFromRequest($request);
        ## EcgCode Model
        $ecgAlertModel = $this->ecgAlertsModel->getByIdFindFail($ecgAlertId);
        $ecgCode = $ecgAlertModel->ecgCode();
        $message = '';

        ## Validate is allow  user to  press this option.
        if (!$ecgAlertModel->shouldShowActionBtn($ecgAlertModel->played_type)) {
            throw new BadRequestException("You're not allowed to Press this action..");
        }

        ## Validate Is this user is valid to respond this Alert.
        $isValidToRespond = $this->ecgCodesAlertsAssignedToUsersModel
            ->isUserAllowToRespondEcgCode($loggedInUser->id, $ecgAlertModel->ecg_code_id);

        if (
            $ecgAlertModel instanceof EcgAlertsModel
            && $isValidToRespond instanceof EcgCodesAlertsAssignedToUsersModel
        ) {
            ## Update status of responding
            $this->ecgAlertsModel->updateAlertResponded($ecgAlertModel,
                $loggedInUser->id, AppHelper::getMySQLFormattedDateTime(Carbon::now()), $request->action);

            ## Check whether to sent to Amplifier or not.
            if ($request->action == "accept") {
                $this->sentToDevices($ecgAlertModel, 'manager_accepted');
                ## Now send to Amplifier
                $message = $ecgAlertModel->ecg_code_nme . ' accepted';
                $this->sendToAmplifier($ecgAlertModel, $ecgCode);
                return $message;
            } else {
                $message = $ecgAlertModel->ecg_code_nme . ' rejected to play on Amplifier';
                $this->sentToDevices($ecgAlertModel, 'manager_rejected');
                return $message;
            }
        } else {
            throw new BadRequestException("You're not allowed to Press this action.");
        }
    }

    public function getAlerts(Request $request): JsonResponse
    {
        /** @var $loggedInUserId User */
        $loggedInUserId = AppHelper::getUserFromRequest($request);
        return AppHelper::sendSuccessResponse(
            true,
            'result',
            new EcgAlertsCollection($this->ecgAlertsModel->getAllAlerts($loggedInUserId->id, $request))
        );
    }

    public function getAlertsAdmin(Request $request): string
    {
        return view('reports.table', [
            'alerts' => $this->ecgAlertsModel->getAllAlertAdmin($request)
        ])->render();
    }

    public function getAmplifierStatusAdmin(Request $request): string
    {
        return view('reports.amplifier_status_table', [
            'updates' => $this->ecgAmplifierStatusModel->getAllUpdates($request)
        ])->render();
    }

    private function sendToAmplifier(EcgAlertsModel $ecgAlertsModel, EcgCodesModel $ecgCode): bool
    {
        $ecgAlertsModel->should_play_to_amplifier = 1;
        $ecgAlertsModel->save();
        return true;
    }

    public function getUnPlayedAlarmToAmplifier(Request $request): JsonResponse
    {
        try {
            $this->ecgAmplifierStatusModel->saveAmplifierStatus(
                $request->header('Header-X-Unique'),
                $request->header('header-x-battery-health') ?: '100%'
            );
            return AppHelper::sendSuccessResponse(
                true,
                'un-played',
                new UnPlayedAlarmCollection($this->ecgAlertsModel->unPlayedAlarmToAmplifier())
            );
        } catch (Exception $exception) {
            Log::error("FAILED_TO_MARK_ALARM_PLAYED", [
                'exception' => $exception,
                'exception_msg' => $exception->getMessage(),
            ]);
            return AppHelper::sendSuccessResponse(false, "failed to get notifications");
        }
    }

    public function markAlarmPlayed($id): JsonResponse
    {
        try {
            $response = $this->ecgAlertsModel->playedToAmplifier($id);
            $this->sentToDevices(EcgAlertsModel::getByIdFindFail($id), 'alarm_played');
            return AppHelper::sendSuccessResponse(true, 'played', $response);
        } catch (Exception $exception) {
            Log::error("FAILED_TO_MARK_ALARM_PLAYED", [
                'exception' => $exception,
                'exception_msg' => $exception->getMessage(),
                'amplifierId' => $id
            ]);
            return AppHelper::sendSuccessResponse(false, "failed to Played");
        }
    }
}
