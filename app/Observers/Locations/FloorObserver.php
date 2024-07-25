<?php

namespace App\Observers\Locations;

use App\Models\Locations\FloorModel;

class FloorObserver
{
    public function updated(FloorModel $floorModel): void
    {
        $floorModel->roomOBject()->update([
            'audio_status' => 'pending',
        ]);
    }
}
