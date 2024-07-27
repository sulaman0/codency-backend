<?php

namespace App\Observers\Locations;

use App\Models\Locations\RoomModel;
use Illuminate\Support\Facades\Log;

class RoomObserver
{
    /**
     * Handle the RoomModel "updated" event.
     */
    public function updated(RoomModel $roomModel): void
    {

    }
}
