<?php

namespace App\Http\Controllers;

use App\Models\EcgCodes\EcgCodesModel;
use App\Models\Locations\LocationModel;
use App\Models\Locations\RoomModel;
use App\Models\User;
use App\Models\Users\UserLocationModel;
use App\Service\EcgAlertsService;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    private EcgAlertsService $ecgAlertsService;
    private User $user;
    private EcgCodesModel $ecgCodesModel;
    private LocationModel $locationModel;
    private UserLocationModel $userLocationModel;
    private RoomModel $roomModel;

    /**
     * @param EcgAlertsService $ecgAlertsService
     * @param User $user
     */
    public function __construct(
        EcgAlertsService $ecgAlertsService,
        User             $user, EcgCodesModel $ecgCodesModel,
        LocationModel    $locationModel,
        RoomModel        $roomModel,
    )
    {
        $this->ecgAlertsService = $ecgAlertsService;
        $this->user = $user;
        $this->ecgCodesModel = $ecgCodesModel;
        $this->locationModel = $locationModel;
        $this->roomModel = $roomModel;
    }


    function index()
    {
        return view('reports.code_pressed', [
            'users' => $this->user->getAllUsersForSearch(),
            'codes' => $this->ecgCodesModel->getAllCodesForSearchNoPagination(),
            'locations' => $this->roomModel->getAllRoomDropdown()
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
            return $this->ecgAlertsService->getAmplifierStatusAdmin($request);
        } catch (\Exception $exception) {
            return "Error: " . $exception->getMessage();
        }
    }
}
