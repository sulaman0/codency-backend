<?php

namespace App\Http\Controllers;

use App\Models\EcgCodes\EcgCodesModel;
use App\Models\Locations\LocationModel;
use App\Models\User;
use App\Service\EcgAlertsService;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    private EcgAlertsService $ecgAlertsService;
    private User $user;
    private EcgCodesModel $ecgCodesModel;
    private LocationModel $locationModel;

    /**
     * @param EcgAlertsService $ecgAlertsService
     * @param User $user
     */
    public function __construct(EcgAlertsService $ecgAlertsService, User $user, EcgCodesModel $ecgCodesModel, LocationModel $locationModel)
    {
        $this->ecgAlertsService = $ecgAlertsService;
        $this->user = $user;
        $this->ecgCodesModel = $ecgCodesModel;
        $this->locationModel = $locationModel;
    }


    function index()
    {
        return view('reports.code_pressed', [
            'users' => $this->user->getAllUsersForSearch(),
            'codes' => $this->ecgCodesModel->getAllCodesForSearch(),
            'locations' => $this->locationModel->getAllLocations()
        ]);
    }

    function amplifierStatus()
    {
        return view('reports.amplifier_status', []);
    }

    function tableRecord(Request $request): string
    {
        try {
            return $this->ecgAlertsService->getAlertsAdmin($request);
        } catch (\Exception $exception) {
            return "Error: " . $exception->getMessage();
        }
    }

    function amplifierStatusTableRecord(Request $request): string
    {
        try {
            return $this->ecgAlertsService->getAlertsAdmin($request);
        } catch (\Exception $exception) {
            return "Error: " . $exception->getMessage();
        }
    }
}
