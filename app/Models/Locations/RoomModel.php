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

    function getAllRoomsAdmin(Request $request = null, $buildingId = null, $floorId = null, $paginated = null)
    {
        $M = RoomModel::where('id', '<>', 0);
        if ($request && $request->search) {
            $M = $M->where(function ($query) use ($request) {
                $query->orWhere('room_nme', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($buildingId) {
            if (is_array($buildingId)) {
                $M->whereIn('building_id', $buildingId);
            } else {
                $M->where('building_id', $buildingId);
            }
        }

        if ($floorId) {
            if (is_array($floorId)) {
                $M->whereIn('loc_floor_id', $floorId);
            } else {
                $M->where('loc_floor_id', $floorId);
            }
        }

        if ($request && $request->status && $request->status <> 'all') {
            $M->where('status', $request->status);
        }

        if ($paginated) {
            return $M->orderBy('id', 'desc')->paginate(10);
        } else {
            return $M->orderBy('id', 'desc')->get();
        }

    }

    function buildingObject()
    {
        return $this->hasMany(LocationModel::class, 'id', 'building_id');
    }

    function buildingNme()
    {
        $B = $this->buildingObject()->first();
        return $B ? $B->building_nme : '';
    }

    function floorObject()
    {
        return $this->hasMany(FloorModel::class, 'id', 'loc_floor_id');
    }

    function floorNme()
    {
        $B = $this->floorObject()->first();
        return $B ? $B->floor_nme : '';
    }

    public function findById($id)
    {
        return RoomModel::find($id);
    }

    function locationName()
    {
        return sprintf("%s, %s - %s", $this->buildingNme(), $this->floorNme(), $this->room_nme);
    }


}
