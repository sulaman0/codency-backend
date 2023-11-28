<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Requests\EcgCodes\NewEcgCodeAlertRequest;
use App\Http\Requests\EcgCodes\RespondEcgCodeRequest;
use App\Http\Resources\EcgAlerts\EcgAlertsCollection;
use App\Http\Resources\EcgCodes\EcgCodesCollection;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\EcgCodes\EcgCodesAlertsAssignedToUsersModel;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use mysql_xdevapi\Exception;

class EcgAlertsService
{
    protected EcgCodesModel $ecgCodesModel;
    protected EcgAlertsModel $ecgAlertsModel;
    protected EcgCodesAlertsAssignedToUsersModel $ecgCodesAlertsAssignedToUsersModel;

    /**
     * @param EcgCodesModel $ecgCodesModel
     * @param EcgAlertsModel $ecgAlertsModel
     */
    public function __construct(EcgCodesModel $ecgCodesModel, EcgAlertsModel $ecgAlertsModel, EcgCodesAlertsAssignedToUsersModel $ecgCodesAlertsAssignedToUsersModel)
    {
        $this->ecgCodesModel = $ecgCodesModel;
        $this->ecgAlertsModel = $ecgAlertsModel;
        $this->ecgCodesAlertsAssignedToUsersModel = $ecgCodesAlertsAssignedToUsersModel;
    }

    /**
     * @throws \Exception
     */
    public function pressCode(NewEcgCodeAlertRequest $request): bool
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
            if ($ecgCodeModel->action == "sent_to_amplifier_directly") {
                ## Send alert directly
                $this->sendToAmplifier($ecgAlertModel, $ecgCodeModel);
            }
        } else {
            throw new \Exception("Failed to Save the Alert");
        }
    }

    public function respondToCde(RespondEcgCodeRequest $request, $ecgAlertId)
    {
        ## User Model
        $loggedInUser = AppHelper::getUserFromRequest($request);

        ## EcgCode Model
        $ecgAlertModel = $this->ecgAlertsModel->getByIdFindFail($ecgAlertId);
        $ecgCode = $ecgAlertModel->ecgCode();

        ## Validate Is this user is valid to respond this Alert.
        $isValidToRespond = $this->ecgCodesAlertsAssignedToUsersModel->isUserAllowToRespondEcgCode($loggedInUser->id, $ecgAlertModel->ecg_code_id);

        if ($ecgAlertModel instanceof EcgAlertsModel && $ecgCode->action == "sent_to_manager" && $isValidToRespond instanceof EcgCodesAlertsAssignedToUsersModel) {

            ## Update status of responding
            $this->ecgAlertsModel->updateAlertResponded($ecgAlertModel,
                $loggedInUser->id, AppHelper::getMySQLFormattedDateTime(Carbon::now()), $request->action);

            ## Check whether to sent to Amplifier or not.
            if ($ecgCode->action == 'sent_to_manager') {
                ## Now send to Amplifier
                $this->sendToAmplifier($ecgAlertModel, $ecgCode);
            }

        } else {
            if ($ecgCode->action == "sent_to_amplifier_directly") {
                throw new Exception("Alert Already Played To The Amplifier");
            } else {
                throw new \Exception("Invalid Alert Passed");
            }

        }


    }

    public function getAlerts(Request $request): JsonResponse
    {
        /** @var $loggedInUserId User */
        $loggedInUserId = AppHelper::getUserFromRequest($request);
        return AppHelper::sendSuccessResponse(true, 'result', new EcgAlertsCollection($this->ecgAlertsModel->getAllAlerts($loggedInUserId->id)));
    }

    private function sendToAmplifier(EcgAlertsModel $ecgAlertsModel, EcgCodesModel $ecgCode)
    {
    }
}
