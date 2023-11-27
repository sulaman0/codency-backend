<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Resources\EcgCodes\EcgCodesCollection;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class EcgCodesService
{
    protected EcgCodesModel $ecgCodesModel;

    /**
     * @param EcgCodesModel $ecgCodesModel
     */
    public function __construct(EcgCodesModel $ecgCodesModel)
    {
        $this->ecgCodesModel = $ecgCodesModel;
    }

    public function getAlLCodes(Request $request): \Illuminate\Http\JsonResponse
    {
        /** @var $loggedInUserId User */
        $loggedInUserId = AppHelper::getUserFromRequest($request);
//        $ecgCodes = $loggedInUserId->ecgCodes()->paginate();
        $ecgCodes = EcgCodesModel::paginate();
        return AppHelper::sendSuccessResponse(true, 'result', new EcgCodesCollection($ecgCodes));
    }
}
