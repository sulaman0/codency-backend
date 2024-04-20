<?php

namespace App\Models\Locations;

use App\AppHelper\AppHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FloorModel extends Model
{
    use HasFactory;

    protected $table = 'loc_floor';
    protected $fillable = [
        'status'
    ];

    public function saveFloor(mixed $building, mixed $floor_name)
    {
        $M = new FloorModel();
        $M->building_id = $building;
        $M->floor_nme = $floor_name;
        $M->status = 'active';
        $M->save();
    }

    function getAllFloorDropdown()
    {
        return FloorModel::orderBy('id', 'desc')->get();
    }

    function getAllFloorAdmin(Request $request = null, $buildingId = null, $paginated = true)
    {
        $M = FloorModel::where('id', '<>', 0);
        if ($request && $request->search) {
            $M = $M->where(function ($query) use ($request) {
                $query->orWhere('floor_nme', 'LIKE', '%' . $request->search . '%');
            });
        }

        if ($buildingId) {
            if (is_array($buildingId)) {
                $M->whereIn('building_id', $buildingId);
            } else {
                $M->where('building_id', $buildingId);
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

    function roomOBject()
    {
        return $this->hasMany(RoomModel::class, 'loc_floor_id', 'id');
    }

    function roomCount()
    {
        return $this->roomOBject()->count();
    }

    public function findById(string $id)
    {
        return FloorModel::find($id);
    }

}
