<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Requests\Location\CreateLocationRequest;
use App\Models\Locations\FloorModel;
use App\Models\Locations\LocationModel;
use App\Models\Locations\RoomModel;
use Illuminate\Http\Request;

class LocationsService
{
    private LocationModel $locationModel;
    private FloorModel $floorModel;
    private RoomModel $roomModel;

    /**
     * @param LocationModel $locationModel
     */
    public function __construct(LocationModel $locationModel, FloorModel $floorModel, RoomModel $roomModel)
    {
        $this->locationModel = $locationModel;
        $this->floorModel = $floorModel;
        $this->roomModel = $roomModel;
    }

    function getAllLocations()
    {
        return $this->locationModel->getAllLocations();
    }

    function getAllLocationAdmin(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        if ($request->location_type == 'rooms' || ($request->details_of == 'floors' && $request->buildingId && $request->locationId)) {
            return view('location.rooms', [
                'locations' => $this->roomModel->getAllRoomsAdmin($request, $request->buildingId, $request->locationId)
            ]);
        } else if ($request->location_type == 'floors' || ($request->details_of == 'buildings' && $request->ref)) {
            return view('location.floors', [
                'locations' => $this->floorModel->getAllFloorAdmin($request, $request->ref)
            ]);
        } else {
            return view('location.table', [
                'locations' => $this->locationModel->getAllLocationAdmin($request)
            ]);
        }

    }

    public function createLocation(CreateLocationRequest $request): \Illuminate\Http\JsonResponse
    {
        if ($request->step == 2) {
            $this->floorModel->saveFloor($request->building, $request->floor_name);
        } else if ($request->step == 3) {
            $this->roomModel->saveRoom($request->building, $request->floor, $request->room_name);
        } else {
            $this->locationModel->saveBuildingNME($request->building_name);
        }
        return AppHelper::sendSuccessResponse(true, 'created', [
            'buildings' => $this->locationModel->getAllBuildingsDropdown(),
            'floors' => $this->floorModel->getAllFloorDropdown(),
        ]);
    }

    public function updateLocation(Request $request)
    {
        if ($request->loc_type == 'room') {
            $locationModel = $this->roomModel->findById($request->id);
            $locationModel->room_nme = $request->name;
            $locationModel->save();
        } else if ($request->loc_type == 'floor') {
            $locationModel = $this->floorModel->findById($request->id);
            $locationModel->floor_nme = $request->name;
            $locationModel->save();
        } else {
            $locationModel = $this->locationModel->findById($request->id);
            $locationModel->building_nme = $request->name;
            $locationModel->save();
        }

        return AppHelper::sendSuccessResponse(true, 'created', [
            'buildings' => $this->locationModel->getAllBuildingsDropdown(),
            'floors' => $this->floorModel->getAllFloorDropdown(),
        ]);
    }
}
