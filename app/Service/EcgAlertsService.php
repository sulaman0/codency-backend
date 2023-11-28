<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Requests\EcgCodes\NewEcgCodeAlertRequest;
use App\Http\Requests\EcgCodes\RespondEcgCodeRequest;
use App\Http\Resources\EcgCodes\EcgCodesCollection;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EcgAlertsService
{
    protected EcgCodesModel $ecgCodesModel;
    private EcgAlertsModel $ecgAlertsModel;

    /**
     * @param EcgCodesModel $ecgCodesModel
     * @param EcgAlertsModel $ecgAlertsModel
     */
    public function __construct(EcgCodesModel $ecgCodesModel, EcgAlertsModel $ecgAlertsModel)
    {
        $this->ecgCodesModel = $ecgCodesModel;
        $this->ecgAlertsModel = $ecgAlertsModel;
    }

    public function pressCode(NewEcgCodeAlertRequest $request): bool
    {
        ## User Model
        $loggedInUser = AppHelper::getUserFromRequest($request);
        ## EcgCode Model
        $ecgCodeModel = $this->ecgCodesModel->findById($request->code_id);
        ## Save Alert
        return $this->ecgAlertsModel->saveAlert(
            $request->code_id,
            $ecgCodeModel->name,
            $loggedInUser->location_id,
            $loggedInUser->locationNme(),
            $loggedInUser->id,
            AppHelper::getMySQLFormattedDateTime(Carbon::now())
        );
    }

    public function respondToCde(RespondEcgCodeRequest $request, $ecgCodeId)
    {
        ## User Model
        $loggedInUser = AppHelper::getUserFromRequest($request);

        ## EcgCode Model
        $ecgCodeModel = $this->ecgCodesModel->findById($ecgCodeId);

        $this->ecgAlertsModel->updateAlertResponded($ecgCodeModel,
            $loggedInUser->id, AppHelper::getMySQLFormattedDateTime(Carbon::now()), $request->action);
    }
}
