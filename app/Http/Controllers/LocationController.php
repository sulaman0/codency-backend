<?php

namespace App\Http\Controllers;

use App\AppHelper\AppHelper;
use App\Http\Requests\Location\CreateLocationRequest;
use App\Models\Locations\FloorModel;
use App\Models\Locations\LocationModel;
use App\Models\Locations\RoomModel;
use App\Service\LocationsService;
use Illuminate\Contracts\View\Factory as FactoryAlias;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class LocationController extends Controller
{

    private LocationsService $locationsService;
    private LocationModel $locationModel;
    private FloorModel $floorModel;
    private RoomModel $roomModel;

    public function __construct(LocationsService $locationsService, LocationModel $locationModel, FloorModel $floorModel, RoomModel $roomModel)
    {
        $this->locationsService = $locationsService;
        $this->locationModel = $locationModel;
        $this->floorModel = $floorModel;
        $this->roomModel = $roomModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): FactoryAlias|Application|View|\Illuminate\Contracts\Foundation\Application
    {
        return view('location.index', [
            'buildings' => $this->locationModel->getAllBuildingsDropdown(),
            'floors' => $this->floorModel->getAllFloorDropdown(),
        ]);
    }

    public function tableRecord(Request $request)
    {
        try {
            return $this->locationsService->getAllLocationAdmin($request);
        } catch (\Exception $exception) {
            return "Error: " . $exception->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateLocationRequest $request): \Illuminate\Http\JsonResponse|bool
    {
        try {
            return $this->locationsService->createLocation($request);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        if ($request->loc_type == 'floor') {
            $locationModel = $this->floorModel->findById($id);
            $nme = $locationModel->floor_nme;
        } else if ($request->loc_type == 'room') {
            $locationModel = $this->roomModel->findById($id);
            $nme = $locationModel->room_nme;
        } else {
            $locationModel = $this->locationModel->findById($id);
            $nme = $locationModel->building_nme;
        }
        return AppHelper::sendSuccessResponse(true, 'found', [
            'type' => $request->loc_type ?: '',
            'name' => $nme,
            'id' => $locationModel->id
        ]);

//        if ($request->wantsJson()) {
//            return AppHelper::sendSuccessResponse(true, 'found', [
//                'type' => $request->type,
//                'name' => $nme,
//                'id' => $locationModel->id
//            ]);
//        } else {
//            return view('location.details', [
//                'floors' => $locationModel->floors(),
//                'rooms' => $locationModel->rooms(),
//            ]);
//        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            return $this->locationsService->updateLocation($request);
        } catch (\Exception $exception) {
            return AppHelper::logErrorException($exception);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // get location on based of building || floor
    public function floorOrRooms(Request $request)
    {
        $buildingId = explode(',', $request->building_id);
        $floorId = explode(',', $request->floor_id);

        $floors = $rooms = [];
        if ($buildingId) {
            $floors = $this->floorModel->getAllFloorAdmin(null, $buildingId, false);
        }
        if ($buildingId && $floorId) {
            $rooms = $this->roomModel->getAllRoomsAdmin(null, $buildingId, $floorId, false);
        }

        return AppHelper::sendSuccessResponse(true, 'responded', [
            'floors' => $floors,
            'rooms' => $rooms
        ]);
    }
}
