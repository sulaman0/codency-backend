<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Requests\EcgCodes\NewEcgCodeAlertRequest;
use App\Http\Requests\EcgCodes\RespondEcgCodeRequest;
use App\Http\Resources\EcgCodes\EcgCodesCollection;
use App\Http\Resources\EcgCodes\SearchList\EcgCodesSearchListCollection;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EcgCodesService
{
    protected EcgCodesModel $ecgCodesModel;
    protected EcgAlertsModel $ecgAlertsModel;

    /**
     * @param EcgCodesModel $ecgCodesModel
     * @param EcgAlertsModel $ecgAlertsModel
     */
    public function __construct(EcgCodesModel $ecgCodesModel, EcgAlertsModel $ecgAlertsModel)
    {
        $this->ecgCodesModel = $ecgCodesModel;
        $this->ecgAlertsModel = $ecgAlertsModel;
    }

    public function getAlLCodes(Request $request, $isApiCall = true)
    {
        /** @var $loggedInUserId User */
        $loggedInUserId = AppHelper::getUserFromRequest($request);
        if ($isApiCall) {
            return AppHelper::sendSuccessResponse(true, 'result', new EcgCodesCollection($this->ecgCodesModel->getAllCodes($loggedInUserId->id)));
        } else {
            return view('ecg_codes.table', [
                'ecg_codes' => $this->ecgCodesModel->getAllCodesAdmin($request)
            ])->render();
        }

    }

    public function getAlLCodesForSearch($request): JsonResponse
    {
        return AppHelper::sendSuccessResponse(true, 'found', [
            'data' => new EcgCodesSearchListCollection($this->ecgCodesModel->getAllCodesForSearch($request->search))
        ]);
    }


}
