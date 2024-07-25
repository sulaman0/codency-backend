<?php

namespace App\Observers\Locations;

use App\Models\Locations\LocationModel;
use App\Models\Locations\RoomModel;

class LocationAsBuildingObserver
{
    public function updated(LocationModel $locationModel): void
    {
        $locationModel->roomOBject()->update([
            'audio_status' => 'pending',
        ]);
    }
}
