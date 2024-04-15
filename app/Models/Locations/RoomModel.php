<?php

namespace App\Models\Locations;

use App\AppHelper\AppHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RoomModel extends Model
{
    use HasFactory;

    protected $table = 'loc_room';
    protected $fillable = [
        'status'
    ];

    public function saveRoom(mixed $building, mixed $floor, mixed $room_name)
    {
        $M = new RoomModel();
        $M->building_id = $building;
        $M->loc_floor_id = $floor;
        $M->room_nme = $room_name;
        $M->status = 'active';
        $M->save();
    }

    function getAllRoomDropdown()
    {
        return RoomModel::all();
    }

}
