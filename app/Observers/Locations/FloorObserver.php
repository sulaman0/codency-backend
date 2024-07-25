<?php

namespace App\Observers\Locations;

use App\Models\Locations\FloorModel;

class FloorObserver
{
    public function updated(FloorModel $floorModel): void
    {
        foreach ($floorModel->roomOBject()->get() as $room) {
            $room->updateAction();
        }
    }
}
