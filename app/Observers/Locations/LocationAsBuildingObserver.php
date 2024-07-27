<?php

namespace App\Observers\Locations;

use App\Models\Locations\LocationModel;
use Illuminate\Support\Facades\Log;

class LocationAsBuildingObserver
{
    public function updated(LocationModel $locationModel): void
    {
    }
}
