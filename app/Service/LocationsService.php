<?php

namespace App\Service;

use App\AppHelper\AppHelper;
use App\Http\Requests\Location\CreateLocationRequest;
use App\Models\Locations\LocationModel;
use Illuminate\Http\Request;

class LocationsService
{
    private LocationModel $locationModel;

    /**
     * @param LocationModel $locationModel
     */
    public function __construct(LocationModel $locationModel)
    {
        $this->locationModel = $locationModel;
    }

    function getAllLocations()
    {
        return $this->locationModel->getAllLocations();
    }

    function getAllLocationAdmin(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('location.table', [
            'locations' => $this->locationModel->getAllLocationAdmin($request)
        ]);
    }

    public function createLocation(CreateLocationRequest $request): \Illuminate\Http\JsonResponse
    {
        return AppHelper::sendSuccessResponse(true, 'created',
            $this->locationModel->createOrUpdateLocation(
                $request->loc_name,
                $request->building_nme,
                $request->id
            ));
    }
}
