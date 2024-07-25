<?php

namespace App\Observers\Locations;

use App\Models\Locations\LocationModel;

class LocationAsBuildingObserver
{
    public function updated(LocationModel $locationModel): void
    {
        foreach ($locationModel->roomOBject()->get() as $room) {
            $room->updateAction();
        }
    }
}
