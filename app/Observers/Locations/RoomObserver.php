<?php

namespace App\Observers\Locations;

use App\Models\Locations\RoomModel;

class RoomObserver
{
    /**
     * Handle the RoomModel "created" event.
     */
    public function created(RoomModel $roomModel): void
    {
        //
    }

    /**
     * Handle the RoomModel "updated" event.
     */
    public function updated(RoomModel $roomModel): void
    {
        $roomModel->updateAction();
    }

    /**
     * Handle the RoomModel "deleted" event.
     */
    public function deleted(RoomModel $roomModel): void
    {
        //
    }

    /**
     * Handle the RoomModel "restored" event.
     */
    public function restored(RoomModel $roomModel): void
    {
        //
    }

    /**
     * Handle the RoomModel "force deleted" event.
     */
    public function forceDeleted(RoomModel $roomModel): void
    {
        //
    }
}
