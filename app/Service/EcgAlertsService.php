<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Events\EcgAlert\EcgAlertEvent;
use App\Events\EcgAlertNotificationEvent;
use App\Events\Space\SpaceDiscussion\SpaceNewMessageEvent;
use App\Http\Requests\EcgCodes\NewEcgCodeAlertRequest;
use App\Http\Requests\EcgCodes\RespondEcgCodeRequest;
use App\Http\Resources\EcgAlerts\EcgAlertsCollection;
use App\Http\Resources\EcgAlerts\EcgAlertsResource;
use App\Http\Resources\EcgAlerts\UnPlayedAlarmCollection;
use App\Http\Resources\EcgCodes\EcgCodesCollection;
use App\Models\Amplifier\EcgAmplifierStatusModel;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\EcgCodes\EcgCodesAlertsAssignedToUsersModel;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Print_;


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
    public function __construct(EcgCodesModel $ecgCodesModel, EcgAlertsModel $ecgAlertsModel, EcgCodesAlertsAssignedToUsersModel $ecgCodesAlertsAssignedToUsersModel, EcgAmplifierStatusModel $ecgAmplifierStatusModel)
    {
        $this->ecgCodesModel = $ecgCodesModel;
        $this->ecgAlertsModel = $ecgAlertsModel;
        $this->ecgCodesAlertsAssignedToUsersModel = $ecgCodesAlertsAssignedToUsersModel;
        $this->ecgAmplifierStatusModel = $ecgAmplifierStatusModel;
    }

    /**
     * @throws \Exception
     */
    public function pressCode(NewEcgCodeAlertRequest $request)
    {
        ## User Model
        $loggedInUser = AppHelper::getUserFromRequest($request);
        ## EcgCode Model
        $ecgCodeModel = $this->ecgCodesModel->findById($request->code_id);
        ## Save Alert
        $ecgAlertModel = $this->ecgAlertsModel->saveAlert(
            $request->code_id,
            $ecgCodeModel->name,
            $loggedInUser->location_id,
            $loggedInUser->locationNme(),
            $loggedInUser->id,
            AppHelper::getMySQLFormattedDateTime(Carbon::now())
        );

        if ($ecgAlertModel) {
            ## Send this notification to all other apps.
            EcgAlertEvent::broadcast(new EcgAlertsResource($ecgAlertModel));
            EcgAlertNotificationEvent::dispatch($ecgAlertModel);

            if ($ecgCodeModel->action == "sent_to_amplifier_directly") {
                ## Send alert directly
                return $this->sendToAmplifier($ecgAlertModel, $ecgCodeModel);
            }

        } else {
            throw new \Exception("Failed to Save the Alert");
        }
    }

    /**
     * @throws \Exception
     */
    public function respondToCde(RespondEcgCodeRequest $request, $ecgAlertId)
    {
        ## User Model
        $loggedInUser = AppHelper::getUserFromRequest($request);

        ## EcgCode Model
        $ecgAlertModel = $this->ecgAlertsModel->getByIdFindFail($ecgAlertId);
        $ecgCode = $ecgAlertModel->ecgCode();

        ## Validate is allow  user to  press this option.
        if (!$ecgAlertModel->shouldShowActionBtn($ecgCode->action)) {
            throw new \Exception("You're not allowed to Press this action.");
        }

        ## Validate Is this user is valid to respond this Alert.
        $isValidToRespond = $this->ecgCodesAlertsAssignedToUsersModel->isUserAllowToRespondEcgCode($loggedInUser->id, $ecgAlertModel->ecg_code_id);


        if (
            $ecgAlertModel instanceof EcgAlertsModel
            && $isValidToRespond instanceof EcgCodesAlertsAssignedToUsersModel
            && $ecgCode->action == "sent_to_manager"
        ) {
            ## Update status of responding
            $this->ecgAlertsModel->updateAlertResponded($ecgAlertModel,
                $loggedInUser->id, AppHelper::getMySQLFormattedDateTime(Carbon::now()), $request->action);

            ## Check whether to sent to Amplifier or not.
            if ($request->action == "accept") {
                ## Now send to Amplifier
                return $this->sendToAmplifier($ecgAlertModel, $ecgCode);
            } else {
                return true;
            }
        } else {
            throw new \Exception("You're not allowed to Press this action.");
        }
    }

    public function getAlerts(Request $request): JsonResponse
    {
        /** @var $loggedInUserId User */
        $loggedInUserId = AppHelper::getUserFromRequest($request);
        return AppHelper::sendSuccessResponse(true, 'result', new EcgAlertsCollection($this->ecgAlertsModel->getAllAlerts($loggedInUserId->id, $request)));
    }

    public function getAlertsAdmin(Request $request): string
    {
        return view('reports.table', [
            'alerts' => $this->ecgAlertsModel->getAllAlertAdmin($request)
        ])->render();
    }

    private function sendToAmplifier(EcgAlertsModel $ecgAlertsModel, EcgCodesModel $ecgCode): bool
    {
        $ecgAlertsModel->should_play_to_amplifier = 1;
        $ecgAlertsModel->played_type = $ecgCode->action;
        $ecgAlertsModel->save();
        return true;
    }

    public function getUnPlayedAlarmToAmplifier(Request $request): JsonResponse
    {
        $this->ecgAmplifierStatusModel->saveAmplifierStatus($request->header('header-x-unique'), $request->header('header-x-battery-health'));
        return AppHelper::sendSuccessResponse(true, 'un-played', new UnPlayedAlarmCollection($this->ecgAlertsModel->unPlayedAlarmToAmplifier()));
    }

    public function markAlarmPlayed($id): JsonResponse
    {
        Log::info("AMPLIFIER PLAYED TO SERVER UPDATE");
        return AppHelper::sendSuccessResponse(true, 'played', $this->ecgAlertsModel->playedToAmplifier($id));
    }
}
