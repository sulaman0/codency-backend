<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Requests\EcgCodes\CreateNewEcgCodeRequest;
use App\Http\Requests\EcgCodes\EditEcgCodeRequest;
use App\Http\Requests\EcgCodes\NewEcgCodeAlertRequest;
use App\Http\Requests\EcgCodes\RespondEcgCodeRequest;
use App\Http\Resources\EcgCodes\EcgCodesCollection;
use App\Http\Resources\EcgCodes\SearchList\EcgCodesSearchListCollection;
use App\Models\EcgAlert\EcgAlertsModel;
use App\Models\EcgCodes\EcgCodesAlertsAssignedToUsersModel;
use App\Models\EcgCodes\EcgCodesAssignedToUsersModel;
use App\Models\EcgCodes\EcgCodesModel;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EcgCodesService
{
    protected EcgCodesModel $ecgCodesModel;
    protected EcgAlertsModel $ecgAlertsModel;
    private EcgCodesAssignedToUsersModel $ecgCodesAssignedToUsersModel;
    protected EcgCodesAlertsAssignedToUsersModel $ecgCodesAlertsAssignedToUsersModel;

    /**
     * @param EcgCodesModel $ecgCodesModel
     * @param EcgAlertsModel $ecgAlertsModel
     * @param EcgCodesAssignedToUsersModel $ecgCodesAssignedToUsersModel
     * @param EcgCodesAlertsAssignedToUsersModel $ecgCodesAlertsAssignedToUsersModel
     */
    public function __construct(
        EcgCodesModel                      $ecgCodesModel,
        EcgAlertsModel                     $ecgAlertsModel,
        EcgCodesAssignedToUsersModel       $ecgCodesAssignedToUsersModel,
        EcgCodesAlertsAssignedToUsersModel $ecgCodesAlertsAssignedToUsersModel
    )
    {
        $this->ecgCodesModel = $ecgCodesModel;
        $this->ecgAlertsModel = $ecgAlertsModel;
        $this->ecgCodesAssignedToUsersModel = $ecgCodesAssignedToUsersModel;
        $this->ecgCodesAlertsAssignedToUsersModel = $ecgCodesAlertsAssignedToUsersModel;
    }

    public function getAlLCodes(Request $request, $isApiCall = true)
    {
        /** @var $loggedInUserId User */
        $loggedInUserId = AppHelper::getUserFromRequest($request);
        if ($isApiCall) {
            return AppHelper::sendSuccessResponse(
                true, 'result',
                new EcgCodesCollection($this->ecgCodesModel->getAllCodes($loggedInUserId->id))
            );
        } else {
            return view('ecg_codes.table', [
                'ecg_codes' => $this->ecgCodesModel->getAllCodesAdmin($request)
            ])->render();
        }

    }

    public function senderTable($id): string
    {
        return view('ecg_codes.senderTable', [
            'senderTable' => $this->ecgCodesModel->findById($id)->assignedToUsersObject()->paginate(5)
        ])->render();
    }

    public function receiverTable($id): string
    {
        return view('ecg_codes.receiverTable', [
            'receiverTable' => $this->ecgCodesModel->findById($id)->alertsAssignedToUsersObject()->paginate(5)
        ])->render();
    }

    public function getAlLCodesForSearch($request): JsonResponse
    {
        return AppHelper::sendSuccessResponse(true, 'found',
            new EcgCodesSearchListCollection($this->ecgCodesModel->getAllCodesForSearch($request->search))
        );
    }

    public function createEcgCode(CreateNewEcgCodeRequest $request): JsonResponse
    {
        DB::transaction(function () use ($request) {
            // Ecg Code is created
            $ecgCode = $this->ecgCodesModel->createEcgCode(
                $request->code_nme,
                $request->action,
                $request->code,
                $request->details,
                $request->color_code,
                $request->lang,
                null,
                $request->times_to_play
            );

            // Assign Codes to Users
            foreach ($request->senders_list as $senders) {
                $this->ecgCodesAssignedToUsersModel->assignedCodesToUser($senders, $ecgCode->id);
            }

            // Assign Alerts to Users
            foreach ($request->receivers_list as $senders) {
                $this->ecgCodesAlertsAssignedToUsersModel->assignedCodesAlertsToUser($senders, $ecgCode->id);
            }

            // Now Uploading Tunes
            $fileUploadBasePath = 'ecg_codes/' . $ecgCode->id;
            ## upload file English TUne
            $uploadedFileName = Storage::disk('public')->put($fileUploadBasePath, $request->tune_en);
            ## get full path
            $mediaUrlEnglish = Storage::disk('public')->url($uploadedFileName);

            ## upload file English TUne
            $uploadedFileName = Storage::disk('public')->put($fileUploadBasePath, $request->tune_ar);
            ## get full path
            $mediaUrlArabic = Storage::disk('public')->url($uploadedFileName);

            $ecgCode->tune_en = $mediaUrlEnglish;
            $ecgCode->tune_ar = $mediaUrlArabic;
            $ecgCode->save();
        });

        return AppHelper::sendSuccessResponse();
    }

    public function updateEcgCode(EditEcgCodeRequest $request, $id)
    {

        // Ecg Code is created
        $ecgCode = $this->ecgCodesModel->createEcgCode(
            $request->code_nme,
            $request->action,
            $request->code,
            $request->details,
            $request->color_code,
            $request->lang,
            $id,
            $request->times_to_play
        );

        // Assign Codes to Users
        $this->ecgCodesAssignedToUsersModel->deleteCodesByIdAndCodeId($ecgCode->id);
        foreach ($request->senders_list as $senders) {
            $this->ecgCodesAssignedToUsersModel->assignedCodesToUser($senders, $ecgCode->id);
        }

        // Assign Alerts to Users
        $this->ecgCodesAlertsAssignedToUsersModel->deleteCodesByCodeId($ecgCode->id);
        foreach ($request->receivers_list as $senders) {
            $this->ecgCodesAlertsAssignedToUsersModel->assignedCodesAlertsToUser($senders, $ecgCode->id);
        }

        // Now Uploading Tunes
        $fileUploadBasePath = 'ecg_codes/' . $ecgCode->id;

        if ($request->hasFile('tune_en')) {
            ## upload file English TUne
            $uploadedFileName = Storage::disk('public')->put($fileUploadBasePath, $request->tune_en);
            ## get full path
            $mediaUrlEnglish = Storage::disk('public')->url($uploadedFileName);
            $ecgCode->tune_en = $mediaUrlEnglish;
        }

        if ($request->hasFile('tune_ar')) {
            ## upload file English TUne
            $uploadedFileName = Storage::disk('public')->put($fileUploadBasePath, $request->tune_ar);
            ## get full path
            $mediaUrlArabic = Storage::disk('public')->url($uploadedFileName);
            $ecgCode->tune_ar = $mediaUrlArabic;
        }

        $ecgCode->save();
        return AppHelper::sendSuccessResponse();
    }


}
