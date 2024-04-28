<?php

namespace App\Models\Users;

use App\Models\Locations\FloorModel;
use App\Models\Locations\LocationModel;
use App\Models\Locations\RoomModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLocationModel extends Model
{
    use HasFactory;

    protected $table = 'user_location';

    static function storeUserLocations($userId, $rooms): void
    {
        foreach ($rooms as $room) {
            self::storeLoc($room, $userId);
        }
    }

    static function storeLoc($room, $userId): void
    {
        $isExists = self::checkLocationIsAssigned($userId, $room);
        if ($isExists) {
            $isExists->delete();
        } else {
            $M = new UserLocationModel();
            $roomModel = RoomModel::find($room);
            $M->user_id = $userId;
            $M->building_id = $roomModel->building_id;
            $M->loc_floor_id = $roomModel->loc_floor_id;;
            $M->loc_room_id = $room;
            $M->save();
        }
    }

    function building()
    {
        return $this->hasOne(LocationModel::class, 'id', 'building_id')->first();
    }

    function floor()
    {
        return $this->hasOne(FloorModel::class, 'id', 'loc_floor_id')->first();
    }

    function room()
    {
        return $this->hasOne(RoomModel::class, 'id', 'loc_room_id')->first();
    }

    function buildingName()
    {
        $B = $this->building();
        return $B ? $B->building_nme : '';
    }

    function floorName()
    {
        $B = $this->floor();
        return $B ? $B->floor_nme : '';
    }

    function roomName()
    {
        $B = $this->room();
        return $B ? $B->room_nme : '';
    }

    function locationNme()
    {
        return sprintf("%s %s %s", $this->buildingName(), $this->floorName(), $this->roomName());
    }

    static function checkLocationIsAssigned($userId, $locationId)
    {
        return UserLocationModel::where('user_id', $userId)->where('loc_room_id', $locationId)->first();
    }
}
