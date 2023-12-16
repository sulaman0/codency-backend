<?php

namespace App\Service;

use App\Models\Locations\LocationModel;

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
}
